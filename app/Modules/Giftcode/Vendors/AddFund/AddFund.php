<?php

namespace App\Modules\Giftcode\Vendors\AddFund;

use App\Modules\Giftcode\Models\GiftcodeLog;
use App\Modules\Order\Models\Order;
use App\Modules\Wallet\Models\Wallet;
use DB;
use Log;

class AddFund
{
    public function deposit($gcode, $user_id){

        DB::beginTransaction();
        try{
            $gclog = GiftcodeLog::where('code', $gcode->code)->get();

            $log = new GiftcodeLog;
            $log->code = $gcode->code;
            $log->user_id = $user_id;
            $log->model = 'AddFund';
            $log->logs = null;
            $log->sku = $gcode->sku;
            $log->status = 'completed';
            $log->checksum = md5($log->code.count($gclog));
            $log->save();

            $wallet = Wallet::where('user', $user_id)->where('currency_id', $gcode->currency_id)->first();
            $minute = date('dmYHi', time());

            $order = new Order;
            $order->order_code= 'DG' . time() . mt_rand(1000, 9999);
            $order->order_type= 'Deposit';
            $order->module = 'Wallet';
            $order->currency_id= $wallet->currency_id;
            $order->currency_code= $wallet->currency_code;
            $order->payer_id= 1;
            $order->payer_wallet= Wallet::getUserWallet(1, $wallet->currency_id);
            $order->payer_info= '';
            $order->payee_id= $wallet->user;
            $order->payee_wallet= $wallet->number;
            $order->payee_info= '';
            $order->net_amount= abs($gcode->value);
            $order->fees= 0;
            $order->pay_amount= abs($order->net_amount) + abs($order->fees);
            $order->paygate_code= 'Wallet';
            $order->affiliate_code= '';
            $order->status= 'none';
            $order->payment= 'none';
            $order->shipment= 0;
            $order->shipment_info= null;
            $order->description= 'Nạp tiền từ mã Giftcode: '.$gcode->code;
            $order->admin_note= 'GiftcodeDeposit';
            $order->ipaddress= getIpClient();
            $order->creator= $user_id;
            $order->code = 'D' . strtoupper(md5($minute.$wallet->user.'giftcodedeposit'));
            $order->token = sha1($order->code. $order->id. $order->payee_id. round($order->pay_amount));
            $order->save();

            $response = Wallet::transferFund($order->id);

            if ($response === 'PAY_SUCCESS') {
                $order->status = 'completed';
                $order->update();

                if(($gcode->used_time - count($gclog)) == 1){
                    $gcode->status = 2;
                }
                $gcode->update();

                DB::commit();

                return ['status' => 'success', 'message'=> 'Nạp thành công '.number_format($gcode->value).' '. $gcode->currency_code];

            } else {
                DB::rollback();
                return false;
            }

        }catch (\Exception $e){

            $gcode->logs = $e->getMessage();
            $gcode->update();
            return false;
        }


    }

    public function discount($gcode, $user_id){
        return false;
    }

    public function renewal($gcode, $user_id){
        return false;
    }

    public function purchase($gcode, $user_id){
        return false;
    }
}