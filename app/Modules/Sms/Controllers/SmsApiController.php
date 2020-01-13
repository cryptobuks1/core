<?php

namespace App\Modules\Sms\Controllers;

use App\Modules\Merchant\Models\Merchant;
use App\Modules\Order\Models\Order;
use App\Modules\Sms\Models\Sms;
use App\Modules\Sms\Models\SmsTelco;
use App\Modules\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use Log;
use Illuminate\Routing\Route;
use App\User;
use Carbon\Carbon;


class SmsApiController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function httpSend(Request $request)
    {
        $requires = ['partner_id', 'phone', 'text', 'sign', 'wallet'];
        $check = Sms::checkRequire($request, $requires);
        if ($check === 'validated') {

            if (substr($request->phone, 0, 1) !== "0") {
                return Sms::set_output(109);
            }

            ///Kiểm tra partner_id
            $merchant = Merchant::where('partner_id', $request->partner_id)->where('status', 1)->first();
            if (!$merchant) {
                return Sms::set_output(106);
            }

            ///Kiểm tra user
            $user = \App\Modules\User\Models\User::where('id', $merchant->user)->where('status', 1)->first();
            if (!$user) {
                return Sms::set_output(107);
            }

            ///Kiểm tra chữ ký
            $sign = md5($merchant->partner_id . $request->phone . $request->text . $merchant->partner_key);
            if ($sign !== $request->sign) {
                return Sms::set_output(108);
            }

            ///Trừ tiền ở quỹ
            $wallet = Wallet::where('user', $merchant->user)->where('number', $request->wallet)->where('status', 1)->first();
            if (!$wallet) {
                return Sms::set_output(110);
            }

            ///Lấy giá bán sms tạm tính

            $telco = 3;
            $time = date('dmYHis');
            $order = new Order;
            $order->order_code = 'B' . strtoupper(uniqid());
            $order->order_type = 'Buy';
            $order->module = 'Sms';
            $order->currency_id = $wallet->currency_id;
            $order->currency_code = $wallet->currency_code;
            $order->payer_id = $wallet->user;
            $order->payer_wallet = $wallet->number;
            $order->payer_info = '';
            $order->payee_id = 1;
            $order->payee_wallet = Wallet::getUserWallet(1, $wallet->currency_id);
            $order->payee_info = '';
            $order->net_amount = SmsTelco::getPrice($user->id,$telco,$wallet->currency_code); /*abs(600);*/
            $order->fees = 0;
            $order->pay_amount = abs($order->net_amount) + abs($order->fees);
            $order->paygate_code = 'Wallet';
            $order->bank_code = '';
            $order->affiliate_code = '';
            $order->status = 'pending';
            $order->payment = 'none';
            $order->shipment = 0;
            $order->shipment_info = null;
            $order->description = 'Buy Sms Service';
            $order->ipaddress = getIpClient();
            $order->creator = $merchant->user;
            $order->code = 'B' . strtoupper(md5($wallet->user . $request->phone . $request->text . $time));
            $order->token = sha1($order->code . $order->id . $order->payer_id . round($order->pay_amount));
            $result = $order->save();
            if($result == true){
                /// Thực hiện gửi sms
                $current_sms = DB::table('settings')->where('key', 'smsprovider')->first();
                $content = $request->text;
                $sms = new \App\Modules\Sms\Controllers\SmsController;
                $sms->sendSms(null, $request->phone, $order->id, $content, $current_sms->value, 'Otp', 'Sms', $order->order_code, $user->id);
                return Sms::set_output(1);
            }else{
                return Sms::set_output(2);
            }

        } else {
            return $check;
        }
    }

}
