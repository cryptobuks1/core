<?php
namespace App\Modules\Order\Helpers;

use App\Modules\Order\Models\Order;
use App\Modules\Paygate\Models\Paygate;
use App\Modules\Wallet\Models\WalletFee;
use Carbon\Carbon;
use DB;
use Log;
use App\User;

class OrderHelper
{

    ///Kiểm tra đơn hàng có đủ điều kiện thanh toán hay ko?
    public static function validateOrder($amount, $paygate, $code, $user_id, $type = 'p' ){
        $user = User::find($user_id);
        $group = $user->group;
        $type_daily_limit = $type.'_daily_limit';
        $type_min = $type.'_min';
        $type_max = $type.'_max';
        $amount = floatval($amount);

        $daily = Order::where('payment', 'paid')
            ->where('payment_type', $type)
            ->whereDate('created_at', Carbon::today())->sum('net_amount');

        if($paygate == 'Wallet'){
            $wlfee = WalletFee::where('paygate', $paygate)->where('code', $code)->first();

            if($wlfee){

                if(isset($wlfee->$type_min[$group]) && floatval($wlfee->$type_min[$group]) > $amount ){
                    return 'Số tiền bạn '.static::convertType($type). ' đang nhỏ hơn mức cho phép';
                }

                if(isset($wlfee->$type_max[$group]) && floatval($wlfee->$type_max[$group]) < $amount ){
                    return 'Số tiền bạn '.static::convertType($type). ' đang lớn hơn mức cho phép';
                }

                $now = floatval($daily) + $amount;
                $max_daily = floatval($wlfee->$type_daily_limit[$group]) - floatval($daily);
                if(isset($wlfee->$type_daily_limit[$group]) &&  $now > floatval($wlfee->$type_daily_limit[$group])){
                    return 'Tổng số tiền bạn đã '.static::convertType($type). ' vượt quá giới hạn ngày. Còn lại: '. number_format($max_daily).' '.$wlfee->currency_code;
                }

                return 'validated';

            }else{
                return 'Cổng thanh toán không tồn tại!';
            }

        }else{

            $pg = Paygate::where('paygate', $paygate)->where('code', $code)->first();

            if($pg){

                if(isset($pg->$type_min[$group]) && floatval($pg->$type_min[$group]) > $amount ){
                    return 'Số tiền bạn '.static::convertType($type). ' đang nhỏ hơn mức cho phép';
                }

                if(isset($pg->$type_max[$group]) && floatval($pg->$type_max[$group]) < $amount ){
                    return 'Số tiền bạn '.static::convertType($type). ' đang lớn hơn mức cho phép';
                }

                $now = floatval($daily) + $amount;
                $max_daily = floatval($pg->$type_daily_limit[$group]) - floatval($daily);
                if(isset($pg->$type_daily_limit[$group]) && $now > floatval($pg->$type_daily_limit[$group])){
                    return 'Tổng số tiền bạn đã '.static::convertType($type). ' vượt quá giới hạn ngày. Còn lại: '. number_format($max_daily).' '.$pg->currency_code;
                }

                return 'validated';
            }else{
                return 'Cổng thanh toán không tồn tại!';
            }
        }


    }

    public static function convertType($type = 'p'){
        switch ($type){
            case 't':
                $let = 'chuyển';
                break;
            case 'd':
                $let = 'nạp';
                break;
            case 'w':
                $let = 'rút';
                break;
            default :
                $let = 'thanh toán';
                break;
        }
        return $let;
    }

    ///Tính các loại phí thanh toán của đơn hàng, type = payment (p), deposit (d), withdraw (w), transfer (t)
    /// paygate: Wallet, Localbank, Vietcombank....
    public static function paygateFees($amount, $paygate, $code, $user_id, $type = 'p'){

        $user = User::find($user_id);
        $group = $user->group;
        $type_fixed_fee = $type.'_fixed_fees';
        $type_percent_fee = $type.'_percent_fees';
        $type_nofees = $type.'_nofees';
        $amount = floatval($amount);

        if($paygate == 'Wallet'){
            $wlfee = WalletFee::where('paygate', $paygate)->where('code', $code)->first();

            if($wlfee){
                $fixed_fee = floatval($wlfee->$type_fixed_fee[$group]);
                $percent_fee = floatval($wlfee->$type_percent_fee[$group]);

                if(!isset($wlfee->$type_fixed_fee[$group]) || $wlfee->$type_fixed_fee[$group] == null){
                    $fixed_fee = 0;
                }

                if(!isset($wlfee->$type_percent_fee[$group]) || $wlfee->$type_percent_fee[$group] == null){
                    $percent_fee = 0;
                }

                if(isset($wlfee->$type_nofees[$group]) && $amount >= floatval($wlfee->$type_nofees[$group])){
                    $percent_fee = 0;
                    $fixed_fee = 0;
                }

                $fee = $amount*$percent_fee*0.01 + $fixed_fee;
                return $fee;
            }else{
                return 0;
            }

        }else{

            $pg = Paygate::where('paygate', $paygate)->where('code', $code)->first();
            if($pg){
                $fixed_fee = $pg->$type_fixed_fee[$group];
                $percent_fee = $pg->$type_percent_fee[$group];
                if(!isset($pg->$type_fixed_fee[$group]) || $pg->$type_fixed_fee[$group] == null){
                    $fixed_fee = 0;
                }

                if(!isset($pg->$type_percent_fee[$group]) || $pg->$type_percent_fee[$group] == null){
                    $percent_fee = 0;
                }
                if(isset($pg->$type_nofees[$group]) && $amount >= floatval($pg->$type_nofees[$group])){
                    $percent_fee = 0;
                    $fixed_fee = 0;
                }

                $fee = $amount*$percent_fee*0.01 + $fixed_fee;
                return $fee;
            }else{
                return 0;
            }
        }

    }

}
