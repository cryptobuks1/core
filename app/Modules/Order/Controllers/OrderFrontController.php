<?php
namespace App\Modules\Order\Controllers;

use App\Modules\Currency\Models\Currencies;
use App\Modules\Order\Models\Order;
use App\Modules\Setting\Models\Setting;
use App\Modules\Wallet\Models\WalletQueue;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use DB;
use Auth;
use Gloudemans\Shoppingcart\Facades\Cart as Cart;
use App\Modules\Wallet\Models\Wallet;

class OrderFrontController extends FrontendController
{

    public function viewPageCheckout(Request $request)
    {

        if (empty($request->all())) {

            return redirect()->route('home')->withErrors(['error' => 'Trang này không tồn tại!']);
        }

        if (Auth::check()) {
            $order = Order::where('order_code', $request->orderid)->first();
            if ($order->token !== $request->input('token')) {
                return redirect()->route('home')->withErrors(['error' => 'Sai mã token!']);
            }

            if ($order->payer_id !== Auth::user()->id || $order->status == 'completed') {

                return redirect()->route('home')->withErrors(['error' => 'Yêu cầu không hợp lệ!']);
            }

            if ($order->payment == 'paid') {
                return redirect()->route('home')->withErrors(['error' => 'Đơn hàng đã được thanh toán, bạn có thể xem chi tiết ở lịch sử đơn hàng!']);
            }
            $cur = session()->get('currency');
            if (!$order || $cur->id !== $order->currency_id) {
                return redirect()->route('home')->withErrors(['error' => 'Mã đơn hàng không đúng!']);
            }

            $wallet = Wallet::where(['user' => Auth::user()->id, 'currency_id' => $order->currency_id])->first();
            // Balance
            $balance = number_format($wallet->balance_decode);
            $actionUrl = route('frontend.order.dopayment');

            /// Lay cac item cua order ra  (orderItems là hàm chung của các module đc viết trong model)
            $classPath = '\App\Modules\\' . $order->module . '\Models\\' . $order->module;

            $object = new $classPath;
            $items = $object->orderItems($order->order_code);

            $total = $order->pay_amount;
            $currency = Currencies::find($order->currency_id);
            $cart = theme_view('cart.' . $order->module, compact('items', 'currency', 'total'))->render();

            $current_2fa = DB::table('settings')->where('key', 'twofactor')->first();
            $twofactor = null;
            if ($current_2fa->value !== 'none' && $order->paygate_code == 'Wallet') {

                $twofactor = \App\Modules\Twofactor\Controllers\TwofactorController::challenge('Order', $order->order_code);

            }

            return theme_view('account.checkout', compact('balance', 'wallet', 'currency', 'twofactor', 'cart', 'order', 'actionUrl'));
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function doPayment(Request $request)
    {
        $order = Order::findOrFail($request->input('order_id'));
        $current_2fa = DB::table('settings')->where('key', 'twofactor')->first();

        if ($current_2fa->value !== 'none' && $order->paygate_code == 'Wallet') {

            $this->validate($request, [
                'check2fa' => 'required'
            ]);

            //// Kiểm tra 2fa
            $valid = \App\Modules\Twofactor\Controllers\TwofactorController::validate_challenge($request->check2fa, 'Order', $order->order_code);

            if ($valid === false) {
                return redirect()->back()->withErrors(['error' => 'Mã xác thực không đúng!']);
            }
        }

        Cart::destroy();


        //// Cần kiểm tra token lần nữa
        if (!$order) {
            return redirect()->route('home')->withErrors(['error' => 'Mã đơn hàng không đúng!']);
        }

        if ($order->paygate_code === 'Wallet') {

            ///Cho xếp hàng

            $response = Wallet::transferFund($order->id);

            if ($response && $response === 'PAY_SUCCESS') {

                $order->status = 'pending';
                $order->update();

                $output = $this->orderAction($order->id);


                ///Gửi email
                $seting_send_email = Setting::where('key', 'send_email_order')->first();
                if ($seting_send_email->value == 1) {

                    $seting_web = Setting::where('key', 'email')->first();
                    $admin_email = $seting_web->value;

                    $subject = 'Đơn hàng mới - Inv: ' . $order->order_code;
                    $content = 'Bạn vừa có khách hàng đặt đơn hàng mới.';
                    $mail = new \App\Modules\Sendmail\Controllers\SendmailController;
                    $mail->sendmail($subject, $content, $admin_email);
                }

                if (is_array($output) && isset($output['order_code'])) {

                    $orderid = $output['order_code'];

                    return redirect()->route($output['redirect'], compact('orderid'))->with('success', $output['message']);
                } else {

                    return redirect()->route('home')->withErrors(['error' => 'Lỗi xử lý kết quả!']);
                }

            } else {

                $err = error_code($response);
                return redirect()->route('home')->withErrors(['error' => $err]);
            }

        } else {

            $path = app_path('Modules//Paygate//Gateways');
            if (file_exists($path . '/' . $order->paygate_code . '/' . $order->paygate_code . '.php')) {
                $classPath = '\App\Modules\Paygate\Gateways\\' . $order->paygate_code . '\\' . $order->paygate_code;
                $PaygateService = new $classPath;

                return $PaygateService->postPayment($order);
            }
        }


    }

    public static function orderAction($order_id)
    {
        $order = Order::find($order_id);
        /// Thực thi lệnh sau khi thanh toán thành công. Hàm updateCheckout nằm tại các model của module
        $classPath = '\App\Modules\\' . $order->module . '\Models\\' . $order->module;
        $object = new $classPath;

        $output = $object->updateCheckout($order);

        return $output;
    }


    public function orderDetail($order_code){

        if(Auth::check()){
            $order = Order::where('order_code', $order_code)->where('payer_id', Auth::user()->id)->first();
            if($order){
                return theme_view('orders.maindetails', compact('order'));
            }else{
                return redirect()->route('home')->withErrors(['error' => 'Đơn hàng không tồn tại']);
            }
        }else{

            $ip = getIpClient();
            $order = Order::where('order_code', $order_code)->where('ip', $ip)->first();
            if($order){
                return theme_view('orders.maindetails', compact('order'));
            }else{
                return redirect()->route('home')->withErrors(['error' => 'Đơn hàng không tồn tại']);
            }
        }

    }

}
