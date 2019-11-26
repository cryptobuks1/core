<?php

namespace App\Modules\Softcard\Controllers;

use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\Softcard\Models\SoftcardItem;
use App\Modules\Softcard\Models\SoftcardOrder;
use App\Modules\Paygate\Controllers\PaygateFrontController;
use App\Modules\Softcard\Models\Softcard;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Order\Models\Order;
use App\Modules\Categories\Models\Categories;
use App\Modules\Categories\Models\CategoriesProduct;
use App\Modules\Softcard\Models\SoftcardGallery;
use App\Modules\Softcard\Models\SoftcardPrice;
use App\Modules\Softcard\Models\SoftcardDiscount;
use App\Modules\Order\Helpers\OrderHelper;
use App\Modules\Softcard\Helpers\SoftcardHelper;
use Auth;
use Illuminate\Http\Request;
use View;
use Cart;
use DB;
use Log;
use Carbon\Carbon;
use Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Excel;
use App;

class SoftcardFrontController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
    }

    /// Trang chủ mua mã thẻ
    public function muamathe(Request $request)
    {
        $seo_advanced = render_seo('seo_advanced');
        $softcard_box = $this->renderContent();
        $orders_softcard = '';
        if (Auth::check()) {
            $orders_softcard = Order::where(['order_type' => 'Buy', 'module' => 'Softcard', 'payer_id' => Auth::user()->id])->orderBy('id', 'DESC')->paginate(10);
        }

        return theme_view('pages.muamathe', compact('softcard_box', 'orders_softcard', 'seo_advanced'));

    }


    public function history(Request $request)
    {
        $action = $request->submit;
        $user_id = Auth::user()->id;
        $status = $request->status;
        $fdate = preg_replace("/[^0-9-]/", "", $request->fromdate);
        $tdate = preg_replace("/[^0-9-]/", "", $request->todate);

        if (Auth::check()) {
            $orders_softcard = Order::where(['order_type' => 'Buy', 'module' => 'Softcard', 'payer_id' => Auth::user()->id])->orderBy('id', 'DESC')->paginate(25);

            if (isset($request->status) || isset($request->fromdate) || isset($request->todate) && $action) {


                if ($action == 'filter') {

                    $orders_softcard = new Order;

                    if ($request->has('status') && $request->status == 'completed') {
                        $orders_softcard = $orders_softcard->where(['order_type' => 'Buy', 'module' => 'Softcard'])->where('status', 'completed')->where('payer_id', $user_id);
                    }

                    if ($request->has('status') && $request->status == 'canceled') {
                        $orders_softcard = $orders_softcard->where(['order_type' => 'Buy', 'module' => 'Softcard'])->where('status', 'canceled')->where('payer_id', $user_id);
                    }

                    if ($request->has('status') && $request->status == 'pending') {
                        $orders_softcard = $orders_softcard->where(['order_type' => 'Buy', 'module' => 'Softcard'])->where('status', 'pending')->where('payer_id', $user_id);
                    }

                    if ($request->has('status') && $request->status == 'none') {
                        $orders_softcard = $orders_softcard->where(['order_type' => 'Buy', 'module' => 'Softcard'])->where('status', 'none')->where('payer_id', $user_id);
                    }

                    if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {

                        try {
                            Carbon::parse($fdate);
                        } catch (\Exception $e) {
                            $fdate = date('d-m-Y', time());
                        }

                        try {
                            Carbon::parse($tdate);
                        } catch (\Exception $e) {
                            $tdate = date('d-m-Y', time());
                        }

                        $fromdate = Carbon::parse($fdate)->startOfDay();
                        $todate = Carbon::parse($tdate)->endOfDay();
                        $orders_softcard = $orders_softcard->where(['order_type' => 'Buy', 'module' => 'Softcard'])->whereBetween('created_at', [$fromdate, $todate])->where('payer_id', $user_id);

                    }

                    $total = $orders_softcard;

                    $orders_softcard = $orders_softcard->orderBy('id', 'DESC')->where('payer_id', $user_id)->paginate(25)->appends([
                        'status' => $status,
                        'fromdate' => $fdate,
                        'todate' => $tdate
                    ]);

                    return theme_view('softcard.history-softcard', compact('orders_softcard', 'total'));

                } elseif ($action == 'excel') {

                    $orders_softcard2 = new SoftcardOrder;

                    if ($request->has('status') && $request->status == 'completed') {
                        $orders_softcard2 = $orders_softcard2->where('status', 'completed')->where('user', $user_id);
                    }

                    if ($request->has('status') && $request->status == 'canceled') {
                        $orders_softcard2 = $orders_softcard2->where('status', 'canceled')->where('user', $user_id);
                    }

                    if ($request->has('status') && $request->status == 'pending') {
                        $orders_softcard2 = $orders_softcard2->where('status', 'pending')->where('user', $user_id);
                    }

                    if ($request->has('status') && $request->status == 'none') {
                        $orders_softcard2 = $orders_softcard2->where('status', 'none')->where('user', $user_id);
                    }


                    if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {

                        try {
                            Carbon::parse($fdate);
                        } catch (\Exception $e) {
                            $fdate = date('d-m-Y', time());
                        }

                        try {
                            Carbon::parse($tdate);
                        } catch (\Exception $e) {
                            $tdate = date('d-m-Y', time());
                        }

                        $fromdate = Carbon::parse($fdate)->startOfDay();
                        $todate = Carbon::parse($tdate)->endOfDay();
                        $orders_softcard2 = $orders_softcard2->whereBetween('created_at', [$fromdate, $todate])->where('user', $user_id);

                    }

                    $data = $orders_softcard2->orderBy('id', 'DESC')->get()->toArray();

                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setTitle('THECAO');

                    $sheet->setCellValue('A1', 'Mã đơn');
                    $sheet->setCellValue('B1', 'Sản phẩm');
                    $sheet->setCellValue('C1', 'Mã dịch vụ');
                    $sheet->setCellValue('D1', 'Mệnh giá');
                    $sheet->setCellValue('E1', 'Số lượng');
                    $sheet->setCellValue('F1', 'Tổng mệnh giá');
                    $sheet->setCellValue('G1', 'Số tiền');
                    $sheet->setCellValue('H1', 'Trạng thái');
                    $sheet->setCellValue('I1', 'Ngày');


                    $numRow = 2;
                    foreach ($data as $row) {
                        $sheet->setCellValue('A' . $numRow, $row['order_code']);
                        $sheet->setCellValue('B' . $numRow, $row['product']);
                        $sheet->setCellValue('C' . $numRow, $row['service_code']);
                        $sheet->setCellValue('D' . $numRow, $row['value']);
                        $sheet->setCellValue('E' . $numRow, $row['qty']);
                        $sheet->setCellValue('F' . $numRow, $row['value'] * $row['qty']);
                        $sheet->setCellValue('G' . $numRow, $row['subtotal']);
                        $sheet->setCellValue('H' . $numRow, $row['status']);
                        $sheet->setCellValue('I' . $numRow, Carbon::parse($row['created_at'])->format('d-m-Y'));
                        $numRow++;
                    }

                    $writer = new Xlsx($spreadsheet);
                    $filename = 'muathe_' . time();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');

                    $writer->save("php://output");

                } else {
                    return redirect()->route('home')->withErrors(['error' => 'Lỗi: Không tìm thấy yêu cầu']);
                }


            } else {
                return theme_view('softcard.history-softcard', compact('orders_softcard'));
            }
        } else {

            return redirect()->route('login');
        }

    }

    public function renderContent()
    {
        $allow_obj = DB::table('settings_module')->where('key', 'stopsell')->where('module', 'Softcard')->first();

        if ($allow_obj->value == 0) {

            $categories = static::getSubCategories(0);
            $products = array();
            $thumb = array();
            $options = array();
            if (count($categories)) {
                foreach ($categories as $cate) {
                    $products[$cate->id] = static::getCategoryProduct($cate->id);
                    if (count($products[$cate->id])) {
                        foreach ($products[$cate->id] as $pro) {
                            // echo 'img: '.$pro->value
                            //$thumb[$pro->id] = static::getProductThumb($pro->id);
                            // echo '<pre>';
                            $items = static::getProductOptions($pro->id);
                            $options[$pro->id] = array();
                            foreach ($items as $item) {
                                $options[$pro->id][$item->id] = $item->toArray();
                                if (count($item->price))
                                    $options[$pro->id][$item->id]['price'] = $item->price->first()->toArray();
                                if (count($item->discount))
                                    $options[$pro->id][$item->id]['discount'] = $item->discount->first()->toArray();
                            }
                        }
                    }
                }
            }

            $added_items = array();
            if (Cart::instance('Softcard')->count()) {
                foreach (Cart::instance('Softcard')->content() as $row) {
                    $added_items[$row->id] = $row->rowId;
                }
            }

            $shopping_cart = static::renderShoppingCart();
            $servicedesc = DB::table('settings_meta')->where('module', 'Softcard')->where('language', 'vi')->first();

            return theme_view('widgets.muamathe-content', compact('servicedesc', 'categories', 'products', 'thumb', 'options', 'shopping_cart', 'added_items'))->render();

        } else {
            return '<span class="text-danger">CHÚNG TÔI ĐANG TẠM DỪNG BÁN ĐỂ BẢO TRÌ!</span>';
        }

    }


    public function getPageSuccess(Request $request, $order_code)
    {
        if (Auth::check()) {
            $order = Order::where('payer_id', Auth::user()->id)->where('module', 'Softcard')->where('order_code', $order_code)->first();
            if (!$order) {
                return redirect()->back()->withErrors(['error', 'Đơn hàng không tồn tại']);
            }


            if (isset($request->export) && $request->export == 'excel') {

                $user_id = Auth::user()->id;
                $filename = $order_code . '.xls';
                return Excel::download(new App\Modules\Softcard\Models\SoftcardExport($user_id, $order_code), $filename);
            } else {

                $listcard = App\Modules\Softcard\Models\SoftcardPurchased::where('order_code', $order_code)->where('user_id', Auth::user()->id)->get();

                if (count($listcard) > 0) {

                    $cardinfo = theme_view('softcard.cardinfo', compact('listcard'))->render();
                } else {
                    $cardinfo = false;
                }

                return theme_view('pages.softcardsuccess', compact('cardinfo', 'order'));

            }

        } else {
            return redirect()->route('login');
        }
    }

    public function getPagePrint($order_code)
    {
        if (Auth::check()) {

            $order = Order::where('payer_id', Auth::user()->id)->where('module', 'Softcard')->where('order_code', $order_code)->first();
            if (!$order) {
                return redirect()->back()->withErrors(['error', 'Đơn hàng không tồn tại']);
            }
            $listcard = App\Modules\Softcard\Models\SoftcardPurchased::where('order_code', $order_code)->where('user_id', Auth::user()->id)->get();

            return theme_view('softcard.softcard_print', compact('listcard', 'order'));

        } else {
            return redirect()->route('login');
        }
    }


    public function getOrderSoftcard(Request $request)
    {

        if (Auth::check()) {

            $this->validate($request, [
                'paygate_code' => 'required'
            ]);

            $paygate_code = $request->input('paygate_code');

            if ($paygate_code == 'Wallet') {
                $wallet = Wallet::where(['user' => Auth::user()->id, 'currency_id' => session()->get('currency')->id])->first();
                $balance = number_format($wallet->balance_decode, session()->get('currency')->decimal);
            }

            $total = Cart::instance('Softcard')->total();
            // Balance

            $actionUrl = route('softcard.postcheckout');
            return theme_view('account.checkout', compact('total', 'balance', 'paygate_code', 'actionUrl'));
        } else {
            return redirect()->route('login');
        }
    }

    public function postCheckoutSoftcard(Request $request)
    {
        if (!Auth::check()) {

            Cart::instance('Softcard')->destroy();
            return redirect()->route('login');
        }

        if (Auth::user()->id == 1) {
            return redirect()->back()->withErrors(['error' => "Tài khoản Admin này không được mua thẻ"]);
        }

        $this->validate($request, [
            'paygate_code' => 'required'
        ]);

        $user = \App\Modules\User\Models\User::find(Auth::user()->id);
        if (!$user) {
            return redirect()->back()->withErrors(['error' => "Tài khoản thành viên không tồn tại"]);
        }
        $currency_id = session()->get('currency')->id;
        $currency_code = session()->get('currency')->code;

        $paygate_code = explode('.', $request->input('paygate_code'));

        if ($paygate_code[0] === 'Wallet') {

            $wallet = Wallet::where(['user' => Auth::user()->id, 'currency_code' => $currency_code])->first();

            if (!$wallet) {
                Cart::instance('Softcard')->destroy();
                return redirect()->route('home')->withErrors(['message' => 'Ví không tồn tại!']);
            } else {
                if ($wallet->balance_decode < Cart::instance('Softcard')->total(0, '', '')) {
                    Cart::instance('Softcard')->destroy();
                    return redirect()->route('home')->withErrors(['message' => 'Ví của bạn không đủ tiền! Vui lòng nạp tiền vào ví trước.']);
                }
            }

        }

        $minute = date('dmYHi', time());
        $order_code = 'S' . time() . mt_rand(10000, 99999);

        $order_fees = OrderHelper::paygateFees(Cart::instance('Softcard')->total(0, '', ''), $paygate_code[0], $paygate_code[1], Auth::user()->id, 'p');

        /// Tạo nháp order
        $data = array();
        $data['order_code'] = $order_code;
        $data['currency_id'] = $currency_id;
        $data['payer_id'] = Auth::user()->id;
        $data['payee_id'] = 1;
        $data['order_type'] = 'Buy';
        $data['module'] = 'Softcard';
        $data['net_amount'] = Cart::instance('Softcard')->total(0, '', '');
        $data['fees'] = $order_fees;
        $data['paygate_code'] = $paygate_code[0];
        $data['bank_code'] = $paygate_code[1];
        $data['payment_type'] = 'p';
        $data['status'] = 'none';
        $data['payment'] = 'none';
        $data['admin_note'] = '';
        $data['description'] = 'Mua mã thẻ';
        $data['creator'] = Auth::user()->id;
        $data['code'] = 'S' . strtoupper(md5($minute . Auth::user()->id . json_encode(Cart::instance('Softcard')->content()->toArray())));

        $validate = OrderHelper::validateOrder(Cart::instance('Softcard')->total(0, '', ''), $paygate_code[0], $paygate_code[1], Auth::user()->id, 'p');
        if ($validate !== 'validated') {
            return redirect()->back()->withErrors(['message' => $validate]);
        }

        $order = Order::createOrder($data);

        if (!$order) {
            return redirect()->back()->withErrors(['message' => 'Đơn hàng hiện giống đơn hàng trước đó, vui lòng đợi 1 phút rồi thực hiện lại.']);
        }

        if ($order && isset($order->id)) {

        foreach (json_decode(Cart::instance('Softcard')->content()) as $key => $row) {

            // Kiểm tra keyconnect
            if ($row->options->provider !== 'Stock' AND $row->options->provider !== 'Preorder') {
                $kc = App\Modules\Stockcard\Models\StockcardKeyConnect::where('product_sku', $row->id)->where('stock_provider', $row->options->provider)->first();
                if (!$kc) {
                    return redirect()->route('page.softcard')->withErrors(['error' => 'Sản phẩm này chưa được kích hoạt để bán']);
                }
            }

            ///Update lại giá bán
            $item = SoftcardItem::where('sku', $row->id)->first();
            if (!$item) {
                Cart::remove($row->rowId);
                continue;
            } else {

                ///Chống hack số lượng
                $qty = ($row->qty >= 1) ? intval($row->qty) : 1;
                $buy_cost = SoftcardHelper::getPricebyUser($item->service_code, $item->value, Auth::user()->id, $currency_id);

                if (!$buy_cost) {
                    Cart::remove($row->rowId);
                    continue;
                } else {
                    $net_amount = $buy_cost['price'] * $qty;

                    if (env('SMARTSTOCK') == 1) {
                        $check_stock = SoftcardOrder::checkAvailable($qty, 'Stock', $row->id, $row->options->value);
                        if ($check_stock && $check_stock == 'INSTOCK') {
                            // Tạo softcard_order
                            $scOrder = new SoftcardOrder;
                            $scOrder->order_code = $order_code;
                            $scOrder->user = Auth::user()->id;
                            $scOrder->user_info = Auth::user()->username;
                            $scOrder->product = $row->name;
                            $scOrder->product_sku = $row->id;
                            $scOrder->service_code = $item->service_code;
                            $scOrder->value = $item->value;
                            $scOrder->order_id = $order->id;
                            $scOrder->currency_id = $currency_id;
                            $scOrder->currency_code = $currency_code;
                            $scOrder->price = $buy_cost['price'];
                            $scOrder->qty = $qty;
                            $scOrder->sumvalue = $item->value * $qty;
                            $scOrder->discount = $buy_cost['discount'];
                            $scOrder->subtotal = $net_amount;
                            $scOrder->status = 'none';
                            $scOrder->payment = 'none';
                            $scOrder->cart_content = json_encode($row);
                            $scOrder->provider = 'Stock';
                            $scOrder->method = 'WEB';
                            $scOrder->save();
                        } else {
                            $check_available = SoftcardOrder::checkAvailable($qty, $row->options->provider, $row->id, $row->options->value);
                            if ($check_available !== 'INSTOCK') {
                                Cart::remove($row->rowId);
                                continue;
                            }else{
                                // Tạo softcard_order
                                $scOrder = new SoftcardOrder;
                                $scOrder->order_code = $order_code;
                                $scOrder->user = Auth::user()->id;
                                $scOrder->user_info = Auth::user()->username;
                                $scOrder->product = $row->name;
                                $scOrder->product_sku = $row->id;
                                $scOrder->service_code = $item->service_code;
                                $scOrder->value = $item->value;
                                $scOrder->order_id = $order->id;
                                $scOrder->currency_id = $currency_id;
                                $scOrder->currency_code = $currency_code;
                                $scOrder->price = $buy_cost['price'];
                                $scOrder->qty = $qty;
                                $scOrder->sumvalue = $item->value * $qty;
                                $scOrder->discount = $buy_cost['discount'];
                                $scOrder->subtotal = $net_amount;
                                $scOrder->status = 'none';
                                $scOrder->payment = 'none';
                                $scOrder->cart_content = json_encode($row);
                                $scOrder->provider = $row->options->provider;
                                $scOrder->method = 'WEB';
                                $scOrder->save();
                            }
                        }

                    } else {

                        $check_available = SoftcardOrder::checkAvailable($qty, $row->options->provider, $row->id, $row->options->value);
                        if ($check_available !== 'INSTOCK') {
                            Cart::remove($row->rowId);
                            continue;
                        }else{
                            // Tạo softcard_order
                            $scOrder = new SoftcardOrder;
                            $scOrder->order_code = $order_code;
                            $scOrder->user = Auth::user()->id;
                            $scOrder->user_info = Auth::user()->username;
                            $scOrder->product = $row->name;
                            $scOrder->product_sku = $row->id;
                            $scOrder->service_code = $item->service_code;
                            $scOrder->value = $item->value;
                            $scOrder->order_id = $order->id;
                            $scOrder->currency_id = $currency_id;
                            $scOrder->currency_code = $currency_code;
                            $scOrder->price = $buy_cost['price'];
                            $scOrder->qty = $qty;
                            $scOrder->sumvalue = $item->value * $qty;
                            $scOrder->discount = $buy_cost['discount'];
                            $scOrder->subtotal = $net_amount;
                            $scOrder->status = 'none';
                            $scOrder->payment = 'none';
                            $scOrder->cart_content = json_encode($row);
                            $scOrder->provider = $row->options->provider;
                            $scOrder->method = 'WEB';
                            $scOrder->save();
                        }
                    }
                }
            }
        }

        ///Kiểm tra có tạo đc softcard_order ko
        $softcard_orders = SoftcardOrder::where('order_code', $order_code)->get();

        if (count($softcard_orders) == 0) {
            $order->delete();
            return redirect()->route('home')->withErrors(['message' => 'Xin lỗi vì hết hàng hoặc có lỗi tạo đơn hàng']);
        }

        $sum = floatval($softcard_orders->sum('subtotal'));

        if(floatval(Cart::instance('Softcard')->total(0, '', '')) !== $sum){
            $user->status = 0;
            $user->update();
            Auth::logout();
            return redirect()->route('home')->withErrors(['message' => 'Số tiền không chính xác, tài khoản bị khóa tạm thời.']);
        }

        $order_fees_recount = OrderHelper::paygateFees($sum, $paygate_code[0], $paygate_code[1], Auth::user()->id, 'p');

        /// Update lại tổng số tiền
        $order->net_amount = $sum;
        $order->fees = $order_fees_recount;
        $order->pay_amount = $sum + $order_fees_recount;
        $order->update();
        $token = $order->token;
        $orderid = $order->order_code;

        Cart::instance('Softcard')->destroy();

        return redirect()->route('frontend.order.checkout', compact('orderid', 'token'));

    } else {
        return redirect()->route('home')->withErrors(['message' => 'Đơn hàng không được tạo thành công!']);
    }


    }

    public static function getUserGroup()
    {
        if (Auth::check()) {
            $group = Auth::user()->group;
        } else {
            $group = 1;  /// Nhóm Guest
        }
        return $group;
    }

    public static function getCurrency()
    {

        $currency = session()->get('currency');

        return $currency->id;
    }

    public static function getCurrency_code()
    {

        $currency = session()->get('currency');
        return $currency->code;
    }

    public static function getSubCategories($cate_id)
    {
        return Categories::where('parent_id', $cate_id)
            ->where('status', 1)
            ->get();
    }

    public static function getCategoryProduct($cate_id)
    {
        $product_ids = CategoriesProduct::where('category_id', $cate_id)
            ->get(array('product_id'))
            ->toArray();
        $products = Softcard::whereIn('softcard.id', $product_ids)
            ->where('softcard.status', 1)
            // ->leftJoin('product_gallery', 'softcard.id', '=', 'product_gallery.product_id')
            // ->groupBy('softcard.id')
            ->get();
        return $products;
    }

    public static function getProductThumb($pid)
    {
        $thumb = array();
        $image = SoftcardGallery::where('product_id', $pid)
            ->where('status', 1)
            ->orderBy('is_thumb', 'DESC')
            ->get(array('value', 'label'))
            ->first();
        if ($image) {
            $thumb['url'] = $image->value;
            $thumb['alt'] = $image->label;
        }
        return $thumb;
    }

    public static function getProductOptions($pid)
    {
        $result = array();
        $items = SoftcardItem::where('softcard_id', $pid)
            ->with(['price' => function ($query) {
                $query->where('currency_id', static::getCurrency());
            },
                'discount' => function ($query) {
                    $query->where('group_id', static::getUserGroup());
                }])
            ->where('status', 1)
            ->get();
        return $items;
    }

    public static function renderShoppingCart()
    {

        $paygates = PaygateFrontController::showpaygate('listPaygatePayFullwidth', 'payment');

        $shopping_cart = theme_view('pages.giohang', compact('paygates'))->render();
        return $shopping_cart;
    }

    public function calculateItemPrice($id, $qty = 1)
    {
        $result = array();
        $itemPrice = SoftcardPrice::where('item_id', $id)
            ->where('currency_id', static::getCurrency())
            ->pluck('price')->first();
        if ($itemPrice != null) {
            $itemDiscount = SoftcardDiscount::where('item_id', $id)
                ->where('group_id', static::getUserGroup())
                ->pluck('value')->first();
            if ($itemDiscount) {
                $result['value'] = $itemPrice - ($itemPrice * $itemDiscount) / 100;
                $result['discount'] = number_format($itemDiscount, 1);
            } else {
                $result['value'] = $itemPrice;
                $result['discount'] = 0;
            }
        }
        return $result;
    }

    public function ajaxPost(Request $request)
    {
        $input = $request->all();
        if ($input['type'] == 'add' && isset($input['id'])) {
            $item = SoftcardItem::find($input['id']);
            $price = $this->calculateItemPrice($item->id);

            $provider = static::getProviderName($item->provider_id);

            if (isset($price['value'])) {
                $cartItem = Cart::instance('Softcard')->add([
                    'id' => $item->sku,
                    'name' => $item->name,
                    'qty' => 1,
                    'price' => $price['value'],
                    'options' => [
                        'discount' => $price['discount'],
                        'currency_id' => static::getCurrency(),
                        'currency_code' => static::getCurrency_code(),
                        'provider' => $provider,
                        'card_key_connect' => static::getCardKeyConnect($item->sku, $provider),
                        'value' => $item->value,

                    ]
                ]);
                $result['row'] = $cartItem->rowId;
            }
        } elseif ($input['type'] == 'remove') {
            if (isset($input['row'])) {
                Cart::instance('Softcard')->remove($input['row']);
            }
        }
        if ($input['type'] == 'update') {
            if (isset($input['qty']) && isset($input['row'])) {
                Cart::instance('Softcard')->update($input['row'], intval($input['qty']));
            }
        } elseif ($input['type'] == 'delete') {
            Cart::instance('Softcard')->destroy();
        }
        $shopping_cart = static::renderShoppingCart();

        $result['shopping_cart'] = $shopping_cart;
        echo json_encode($result);
    }

    public static function getProviderName($provider_id)
    {
        $provider_name = \App\Modules\Stockcard\Models\Stockcardsetting::where('id', $provider_id)->pluck('provider')->first();
        return $provider_name;
    }

    public static function getCardKeyConnect($itemSku, $provider)
    {
        $key_connect = \App\Modules\Stockcard\Models\StockcardKeyConnect::where('product_sku', $itemSku)
            ->where('stock_provider', $provider)
            ->pluck('key')
            ->first();
        return $key_connect;
    }


}
