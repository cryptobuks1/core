<?php

namespace App\Modules\Order\Controllers;

use App\Modules\Localbank\Models\Localbank;
use App\Modules\Mtopup\Models\Mtopup;
use App\Modules\Paygate\Models\Paygate;
use App\Modules\Softcard\Models\Softcard;
use App\Modules\Softcard\Models\SoftcardOrder;
use App\Modules\Wallet\Models\WalletHistory;
use App\Modules\Wallet\Models\WalletQueue;
use Illuminate\Http\Request;
use App\User;
use App\Modules\Backend\Controllers\BackendController;
use App\Modules\Order\Models\Order;
use App\Modules\Wallet\Models\Wallet;
use DB;
use Auth;
use View;

class OrderController extends BackendController
{

    public function index(Request $request)
    {
        $title = "Quản lý đơn hàng tổng";
        $orders = Order::orderBy('id', 'DESC')->paginate(25);

        if (isset($request->order) && $request->order !== "") {
            $orders = Order::where('code', $request->order)->orWhere('order_code', $request->order)->orderBy('id', 'DESC')->paginate(25);
        }

        return view("Order::index", compact('title', 'orders'));
    }

    public function orderwithdraw(Request $request)
    {
        $title = "Quản lý đơn hàng rút tiền";
        $orders = Order::where(['order_type' => 'Withdraw', 'payment' => 'paid']);
        $type = $request->type;
        $keyword = $request->keyword;

        if ($type == 'order_code' && $keyword) {
            $orders = $orders->where('order_code',$keyword);
        }

        if ($type == 'email' && $keyword) {
            $user = User::where('email', $keyword)->first();
            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'Không có kết quả!']);
            }
            $orders = $orders->where('payer_id',$user->id);

        }

        if ($type == 'statuspending') {

            $orders = $orders->where('status', 'pending');
        }

        if ($type == 'phone' && $keyword) {
            $user = User::where('phone', $keyword)->first();
            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'Không có kết quả!']);
            }
            $orders = $orders->where('payer_id',$user->id);

        }
        $orders = $orders->orderBy('id', 'DESC')->paginate(25);
        foreach ($orders as $order) {
            $userwallet = Wallet::where('user', $order->payer_id)->where('currency_id', $order->currency_id)->first();

            $order->balance = $userwallet->balance_decode;
        }


        return view("Order::orderwithdraw", compact('title', 'orders'));
    }

    public function orderdeposit(Request $request)
    {
        $title = "Quản lý đơn hàng nạp tiền";

        $orders = Order::where('order_type', 'Deposit')->orderBy('id', 'DESC')->paginate(25);

        $type = $request->type;
        $keyword = $request->keyword;

        if ($type == 'order_code' && $keyword) {
            $orders = Order::where(['order_code' => $keyword, 'order_type' => 'Deposit'])->paginate(25);

            if (!$orders) {
                return redirect()->back()->withErrors(['error' => 'Không có kết quả!']);
            }
        }

        if ($type == 'email' && $keyword) {
            $user = User::where('email', $keyword)->first();
            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'Không có kết quả!']);
            }
            $orders = Order::where(['payee_id' => $user->id, 'order_type' => 'Deposit'])->paginate(25);

        }

        if ($type == 'phone' && $keyword) {
            $user = User::where('phone', $keyword)->first();
            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'Không có kết quả!']);
            }
            $orders = Order::where(['payee_id' => $user->id, 'order_type' => 'Deposit'])->paginate(25);

        }


        foreach ($orders as $order) {

            if ($order->paygate_code == 'Localbank') {
                $payment_info = Localbank::where('code', $order->bank_code)->first();

                if ($payment_info) {
                    $order->payment_acc = $payment_info->name . '<br>CTK: <b>' . $payment_info->acc_name . '</b><br>STK: ' . $payment_info->acc_num . '<br>CN: ' . $payment_info->branch;
                } else {
                    $order->payment_acc = '';

                }

            } else {
                $payment_info = Paygate::where('code', $order->paygate_code)->first();
                if ($payment_info) {
                    $order->payment_acc = $payment_info->name;
                } else {
                    $order->payment_acc = '';

                }
            }

        }

        return view("Order::orderdeposit", compact('title', 'orders'));
    }


    public function ajaxWithdrawContent($id)
    {
        $withdraw = Order::find($id);
        return view("Order::ajax.withdrawform", compact('withdraw'));

    }


    public function withdrawAjaxApprove(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $action = $request->input('submit');
            switch ($action) {
                case 'CANCEL':
                    $run = $this->cancelOrderWithdraw($request, $id);
                    DB::commit();
                    break;
                case 'CANCELREFUND':
                    $run = $this->cancelRefundOrderWithdraw($request, $id);
                    DB::commit();
                    break;
                case 'COMPLETE':
                    $run = $this->completeOrderWithdraw($request, $id);
                    DB::commit();
                    break;

                default:
                    $run = '';
                    break;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('orderwithdraw')->withErrors(['message' => $e->getMessage()]);
        }
        return $run;
    }


    public function cancelRefundOrderWithdraw($request, $id)
    {

        $withdraw = Order::findOrFail($id);

        if ($withdraw->status !== 'pending') {
            return redirect()->route('orderwithdraw')
                ->withErrors(['message' => 'Bạn không thể sửa đổi trạng thái của đơn hàng này!']);
        }

        if ($withdraw->payment == 'paid' && $withdraw->status == 'pending') {

            DB::beginTransaction();
            try {

                $withdraw->status = 'canceled';
                $withdraw->payment = 'refunded';
                $withdraw->update();

                $refund_amount = $withdraw->pay_amount;
                //// Thực hiện refund tiền
                $wallet = Wallet::where(['user' => $withdraw->payer_id, 'currency_code' => $withdraw->currency_code])->first();

                $order = new Order;
                $order->order_code = 'DR' . strtoupper(uniqid());
                $order->order_type = 'Deposit';
                $order->module = '';
                $order->currency_id = $wallet->currency_id;
                $order->currency_code = $wallet->currency_code;
                $order->payer_id = 1;
                $order->payer_wallet = Wallet::getUserWallet(1, $wallet->currency_id);
                $order->payer_info = '';
                $order->payee_id = $wallet->user;
                $order->payee_wallet = $wallet->number;
                $order->net_amount = abs($refund_amount);
                $order->fees = 0;
                $order->pay_amount = abs($order->net_amount) + abs($order->fees);
                $order->paygate_code = 'Wallet';
                $order->affiliate_code = '';
                $order->status = 'none';
                $order->payment = 'none';
                $order->shipment = 0;
                $order->shipment_info = null;
                $order->description = 'Admin: Hoàn tiền cho đơn hàng ' . $withdraw->order_code;
                $order->admin_note = 'AdminRefund';
                $order->ipaddress = getIpClient();
                $order->creator = Auth::user()->id;
                $order->code = 'D' . strtoupper(md5($id . $withdraw->payer_id));

                $order->save();

                ///Cho xếp hàng
                WalletQueue::create(['order_code' => $order->order_code, 'message' => $order->description]);
                $response = Wallet::transferFund($order->id);

                if ($response === 'PAY_SUCCESS') {
                    $order->payment = 'paid';
                    $order->status = 'completed';
                    $order->update();
                    DB::commit();
                    unset($order);
                    return redirect()->route('orderwithdraw')->with('success', 'Hùy đơn hàng và hoàn tiền thành công');
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }

        } else {
            return redirect()->route('orderwithdraw')
                ->withErrors(['message' => 'Hoàn tiền không thành công']);
        }
    }


    public function completeOrderWithdraw($request, $id)
    {

        $withdraw = Order::findOrFail($id);

        if ($withdraw->status !== 'pending') {
            return redirect()->route('orderwithdraw')
                ->withErrors(['message' => 'Bạn không thể sửa đổi trạng thái của đơn hàng này!']);
        }

        if ($withdraw->payment == 'paid' && $withdraw->status == 'pending') {

            $withdraw->status = 'completed';
            $withdraw->update();

            return redirect()->route('orderwithdraw')->with('success', 'Cập nhật đơn hàng thành công');
        }

    }


    public function cancelOrderWithdraw($request, $id)
    {
        $withdraw = Order::findOrFail($id);

        if ($withdraw->status !== 'pending') {
            return redirect()->route('orderwithdraw')
                ->withErrors(['message' => 'Bạn không thể sửa đổi trạng thái của đơn hàng này!']);
        }
        if ($withdraw->payment == 'paid' && $withdraw->status == 'pending') {
            $withdraw->status = 'canceled';
            $withdraw->update();
            return redirect()->route('orderwithdraw')->with('success', 'Hủy đơn hàng thành công');
        }
    }


    public function ajaxDepositContent($id)
    {
        $deposit = Order::find($id);
        return view("Order::ajax.depositform", compact('deposit'));
    }


    public function depositAjaxApprove(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $action = $request->input('submit');
            switch ($action) {
                case 'DELETE':
                    $run = $this->deleteOrderDeposit($request, $id);
                    DB::commit();
                    break;
                case 'COMPLETE':
                    $run = $this->completeOrderDeposit($request, $id);
                    DB::commit();
                    break;
                default:
                    $run = '';
                    break;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('orderdeposit')->withErrors(['message' => $e->getMessage()]);
        }
        return $run;
    }

    public function completeOrderDeposit($request, $id)
    {
        $deposit = Order::findOrFail($id);

        if ($deposit->status == 'completed') {
            return redirect()->route('orderdeposit')
                ->withErrors(['message' => 'Bạn không thể sửa đổi trạng thái của đơn hàng này!']);
        }

        if ($deposit->payment == 'paid' || $deposit->payment == 'none') {

            ///Cho xếp hàng
            WalletQueue::create(['order_code' => $deposit->order_code, 'message' => $deposit->description]);

            $response = Wallet::transferFund($deposit->id);

            if ($response === 'PAY_SUCCESS') {
                $deposit->status = 'completed';
                $deposit->update();

                return redirect()->route('orderdeposit')->with('success', 'Bạn đã hoàn thành đơn hàng và cộng tiền cho khách');
            }
        } else {
            return redirect()->route('orderdeposit')
                ->withErrors(['message' => 'Nạp tiền không thành công']);
        }
    }

    public function deleteOrderDeposit($request, $id)
    {
        $deposit = Order::findOrFail($id);
        $deposit->delete();
        return redirect()->route('orderdeposit')->with('success', 'Xóa thành công');
    }

    public function deleteOrder(Request $request)
    {
        $id = $request->id;
        $order = Order::find($id);
        if ($order) {
            switch ($order->module) {
                case 'Softcard':
                    DB::beginTransaction();
                    $softcard = new SoftcardOrder;
                    $softcard->where('order_code', $order->order_code)->delete();
                    break;
                case
                'Mtopup' :
                    DB::beginTransaction();
                    $mtopup = new Mtopup;
                    $mtopup->where('order_code', $order->order_code)->delete();
                    break;
                default :
            }
            $order->delete();
            DB::commit();
            return redirect()->route('orders.backend.total')->with('success', 'Xóa đơn hàng thành công');
        }
    }

    public function userWalletHistory($id)
    {
        $list = WalletHistory::where('user_id', $id)->orderBy('id', 'DESC')->limit(10)->get();
        return view('Order::ajax.table', compact('list'));
    }
}
