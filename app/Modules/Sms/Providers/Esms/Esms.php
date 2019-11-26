<?php
namespace App\Modules\Sms\Providers\Esms;
use App\Helpers\CurlHelper;
use App\Modules\Sms\Models\SmsProvider;

class Esms {

    public $config = [
        'url' => 'http://rest.esms.vn/MainService.svc/json',
        'APIKey' => 'Your ApiKey',
        'SecretKey' => 'Your SecretKey',
        'SmsType' => 2
    ];

    public function getBalance(){

        $obj = new CurlHelper;

        $provider = SmsProvider::where(['provider' => 'Esms', 'status' => 1])->first();

        $config = json_decode($provider->configs);

        $url = $config->url;
        $APIKey = $config->APIKey;
        $SecretKey = $config->SecretKey;

        $get_url = $url.'/GetBalance/'.$APIKey.'/'.$SecretKey;

        $result = $obj::curl_get($get_url);

        $result = json_decode($result, true);

        return $result['Balance'];
    }

    ////////$dial_country = +84  nếu là VN

    public function send($dial_country = null, $phone, $content){

        $validP = substr($phone, 0, 1);

        if((int)$validP !== 0){
            return false;
        }


        $phone_ok = substr($phone,1);

        if($dial_country){
            $target_phone = $dial_country.$phone_ok;

        }else {
            $target_phone = $phone;
        }

        $SendContent = urlencode($content);


        $obj = new CurlHelper;
        $provider = SmsProvider::where(['provider' => 'Esms', 'status' => 1])->first();

        $config = json_decode($provider->configs);

        $url = $config->url;
        $APIKey = $config->APIKey;
        $SecretKey = $config->SecretKey;
        $SmsType = $config->SmsType;

        if($provider->brandname){

            $get_url = $url.'/SendMultipleMessage_V4_get?Phone='.$target_phone.'&Content='.$SendContent.'&ApiKey='.$APIKey.'&SecretKey='.$SecretKey.'&Brandname='.$provider->brandname.'&SmsType='.$SmsType;

        }else{

            $get_url = $url.'/SendMultipleMessage_V4_get?Phone='.$target_phone.'&Content='.$SendContent.'&ApiKey='.$APIKey.'&SecretKey='.$SecretKey.'&SmsType='.$SmsType;

        }

        $result = $obj::curl_get($get_url);
        $result = json_decode($result, true);

        return $result;
    }

}
