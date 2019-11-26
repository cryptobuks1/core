<?php
namespace App\Modules\Sms\Providers\Smsnhanh;
use App\Helpers\CurlHelper;
use App\Modules\Sms\Models\SmsProvider;

class Smsnhanh {

    public $config = [
        'url' => 'api.smsnhanh.com/v2/',
        'Accesskey' => 'Your ApiKey',
        'Type' => 'VIP'
    ];

    public function getBalance(){

        $obj = new CurlHelper;

        $provider = SmsProvider::where(['provider' => 'Smsnhanh', 'status' => 1])->first();

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
        $provider = SmsProvider::where(['provider' => 'Smsnhanh', 'status' => 1])->first();

        $config = json_decode($provider->configs);

        $url = $config->url;
        $Accesskey = $config->Accesskey;
        $Type = $config->Type;

        if($Type && $Type == 'VIP' ){

            $get_url = $url.'?Accesskey='.$Accesskey.'&PhoneNumber='.$target_phone.'&Text='.$SendContent.'&Type='.$Type;

        }else{

            $get_url = $url.'?Accesskey='.$Accesskey.'&PhoneNumber='.$target_phone.'&Text='.$SendContent;

        }

        $result = $obj::curl_get($get_url);
        $result = json_decode($result, true);

        return $result;
    }

}
