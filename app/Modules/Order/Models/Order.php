<?php
namespace App\Modules\Order\Models;

use App\Modules\Mtopup\Models\Mtopup;
use App\Modules\Softcard\Models\SoftcardOrder;
use App\Modules\Wallet\Models\Wallet;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Currency\Models\Currencies;


class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'id','order_code','order_type','module','currency_id','currency_code','payer_id','payer_wallet','payer_info','payee_info',
        'payee_id','payee_wallet','net_amount', 'discount', 'fees','pay_amount','paygate_code','bank_code','affiliate_code','status',
        'payment','shipment','shipment_info','description','admin_note','ipaddress', 'instant', 'creator','checksum', 'request_id', 'payment_type', 'receive_bank_id', 'paygate_trans'
    ];



    public static function createOrder(array $data){


        if(!isset($data['payer_id']) || !isset($data['payee_id']) || !isset($data['order_type']) || !isset($data['net_amount']) || $data['net_amount'] <= 0 ||
            !isset($data['paygate_code']) || !isset($data['status']) || !isset($data['payment']) || !isset($data['code'])|| !isset($data['currency_id']) || !isset($data['module']) || !isset($data['creator'])){

            return 328;
        }

        $currency = Currencies::find($data['currency_id']);
        if(!$currency){
            return false;
        }

        try{
            $ipAddress = getIpClient();
        }catch (\Exception $e){
            $ipAddress = '1.1.1.1';
        }

        try{
            $order = new Order;
            $order->order_code = $data['order_code'];
            $order->order_type = $data['order_type'];
            $order->module = $data['module'];
            $order->currency_id = $data['currency_id'];
            $order->currency_code = $currency->code;
            $order->payer_id = $data['payer_id'];
            $order->payer_wallet = Wallet::getUserWallet($data['payer_id'], $order->currency_id);
            $order->payer_info = (isset($data['payer_info'])) ? $data['payer_info'] : static::getUserInfo($data['payer_id']);
            $order->payee_id = $data['payee_id'];
            $order->payee_wallet = Wallet::getUserWallet($data['payee_id'], $order->currency_id);
            $order->net_amount = $data['net_amount'];
            $order->fees = (isset($data['fees'])) ? $data['fees'] : 0;
            $order->pay_amount = abs($order->net_amount) + abs($order->fees);
            $order->paygate_code = $data['paygate_code'];
            $order->bank_code = (isset($data['bank_code'])) ? $data['bank_code'] : '';
            $order->affiliate_code = (isset($data['affiliate_code'])) ? $data['affiliate_code'] : '';
            $order->status = $data['status'];
            $order->payment = $data['payment'];
            $order->shipment = (isset($data['shipment'])) ? $data['shipment'] : 0;
            $order->request_id = (isset($data['request_id'])) ? $data['request_id'] : null;
            $order->payment_type = (isset($data['payment_type'])) ? $data['payment_type'] : null;
            $order->receive_bank_id = (isset($data['receive_bank_id'])) ? $data['receive_bank_id'] : null;
            $order->shipment_info = (isset($data['shipment_info'])) ? $data['shipment_info'] : null;
            $order->realestates_id = (isset($data['realestates_id'])) ? $data['realestates_id'] : null;
            $order->instant = (isset($data['instant'])) ? $data['instant'] : null;
            $order->description = (isset($data['description'])) ? $data['description'] : '';
            $order->admin_note = (isset($data['admin_note'])) ? $data['admin_note'] : '';
            $order->ipaddress = (isset($data['ipaddress'])) ? $data['ipaddress'] : $ipAddress;
            $order->creator = $data['creator'];
            $order->code = $data['code'];
            $order->token = sha1($data['code'].$order->ipaddress);
            $order->save();
            return $order;
        }catch (\Exception $e){
            return false;
        }
    }


    public static function getUserInfo($user_id){

        $user_info = null;
        $user = User::find($user_id);

        if($user){
            $user_info = (isset($user->email)) ? $user->email : $user->phone;
        }
        return $user_info;
    }


    /// Lấy thông tin vắn tắt, chỉ có tên và username
    public static function getUserInfo_short($user_id){

        $user_info = null;
        $user = User::find($user_id);

        if($user){
            $user_info = $user->name.'<br><b>'.$user->username.'</b>';
        }
        return $user_info;
    }



    public function softcard(){

        return $this->hasMany('App\Modules\Softcard\Models\SoftcardOrder', 'order_code', 'order_code');

    }

    public function mtopup(){

        return $this->hasMany('App\Modules\Mtopup\Models\Mtopup', 'order_code', 'order_code');

    }


    public static function getlistproduct($order){
        $list = '';

        switch ($order->module){
            case 'Softcard':

                $order_s = SoftcardOrder::where('order_code', $order->order_code)->get();

                if(count($order_s) > 0) {
                    foreach ($order_s as $softcard){
                        $list .= '<b>'.$softcard->qty.'</b> '.$softcard->product.'<br>';
                    }

                }

                break;
            case 'Mtopup':

                $order_m = Mtopup::where('order_code', $order->order_code)->get();

                if(count($order_m) > 0) {
                    foreach ($order_m as $mtop){

                        $list .= 'Nạp cước '.$mtop->telco.' '.number_format($mtop->declared_value).'đ'.'<br>';
                    }

                }
                break;


            default:
                $list = '';
                break;
        }

        return $list;
    }


}
