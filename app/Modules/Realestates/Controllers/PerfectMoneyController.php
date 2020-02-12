<?php

namespace App\Modules\Realestates\Controllers;
use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\Order\Helpers\OrderHelper;
use App\Modules\Order\Models\Order;
use App\Modules\Paygate\Controllers\PaygateFrontController;
use App\Modules\Realestates\Models\BuyVip;
use App\Modules\Realestates\Models\Cities;
use App\Modules\Realestates\Models\GroupProject;
use App\Modules\Realestates\Models\Orders;
use App\Modules\Realestates\Models\Provinces;
use App\Modules\Realestates\Models\Wallets;
use App\Modules\Ztest\Models\Votes;
use App\User;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\RealestatesType;
use App\Modules\Realestates\Models\Realestates;
use App\Modules\Realestates\Models\RealestatesImg;
use App\Modules\Realestates\Models\Project;
use App\Modules\Realestates\Models\Search;
use App\Modules\Realestates\Models\RealestatesOrderItems;
use App\Modules\Realestates\Models\Broker;
use Auth;
use Cookie;
use Carbon\Carbon;

class PerfectMoneyController extends FrontendController
{


    public function SetExpressCheckout($order_code)
    {
        $order = Orders::where('order_code',$order_code)->first();
        $result = $this->createUrl($order_code);
        if($result && is_array($result)){
            if($result['error_code'] == '00'){
                return redirect($result['checkout_url']);
            }
        }
        else{
            return back();
        }
    }

    public function createUrl($order_code){
        $order = Orders::where('order_code',$order_code)->first();
        $inputs = [
            'merchant_id' => '23594',
            'merchant_password' => md5('NLDskIs302KHDs23KkYA'),
            'version' => '3.2',
            'function' => 'setExpressCheckout',
            'receiver_email' => 'nguyennghia@nencer.net',
            'order_code' => $order->order_code,
            'total_amount' => 10000,
            'payment_method' => 'IB_ONLINE',
            'payment_type' => '1',
            'order_description' => $order->description,
            'tax_amount' => 0,
            'discount_amount' => $order->discount,
            'fee_shipping' => 0,
            'bank_code' => 'BIDV',
            'return_url' => route('tin.order', $order->order_code),
            'cancel_url' => route('tin.order', $order->order_code),
            'notify_url' => route('tin.order', $order->order_code),
            'time_limit' => 0,
            'buyer_fullname' => 'Dinh Hoang',
            'buyer_email' => 'huyhoangepu997@gmail.com',
            'buyer_mobile' => '0339732297',
            'buyer_address' => 'Ha Noi',
            'cur_code' => 'vnd',
            'lang_code' => 'vi',
            'affiliate_code' => '',
            'card_number' => '',
            'card_fullname' => 'Dinh Huy Hoang',
            'card_month' => 10,
            'card_year' => 2015,
        ];
        $result = static::checkoutCall($inputs);
        return $result;
    }
    public static function authenTransaction($params)
    {
        $inputs = array(
            'merchant_id' => '23594',
            'merchant_password' => md5('NLDskIs302KHDs23KkYA'),
            'version' => '3.2',
            'function' => 'AuthenTransaction',
            'token' => $params['token'],
            'otp' => $params['otp'],
            'auth_url' => route('tin.rao'),
        );
        $result = static::checkoutCall($inputs);
        return $result;
    }
    public static function getRequestField($params)
    {
        $inputs = array(
            'merchant_id' => '23594',
            'merchant_password' => md5('NLDskIs302KHDs23KkYA'),
            'version' => '3.2',
            'function' => 'GetRequestField',
            'receiver_email' => 'nguyennghia@nencer.net',
            'payment_method' => $params['payment_method'],
            'bank_code' => $params['bank_code']
        );
        $result = static::checkoutCall($inputs);
        return $result;
    }
    private static function checkoutCall($params) {
        $paramsStr = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.nganluong.vn/checkout.api.nganluong.post.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paramsStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $result = curl_exec($ch);
        if (!empty($result)) {
            $str_result = str_replace('&', '&amp;', (string) $result);
            $xml = simplexml_load_string($str_result);
            $json_result = json_encode($xml);
            $result = json_decode($json_result, true);
        }
        return $result;
    }
    public static function returnURL($order_code){
        $order = Orders::where('order_code',$order_code)->first();
        return theme_view('realestates.nganluong',compact('order'));
    }

}
