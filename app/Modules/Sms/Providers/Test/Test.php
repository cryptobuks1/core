<?php
namespace App\Modules\Sms\Providers\Test;
use App\Helpers\CurlHelper;
use App\Modules\Sms\Models\SmsProvider;

class Test {

    public $config = [
        'url' => 'http://test.com',
        'APIKey' => 'YourApiKey',
        'SecretKey' => 'Your SecretKey',
        'SmsType' => 2
    ];

    public function getBalance(){

        return 2;
    }

    ////////$dial_country = +84  nếu là VN

    public function send($dial_country = null, $phone, $content){


        return 1;
    }

}
