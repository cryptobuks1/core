<?php
namespace App\Modules\Sms\Providers\Fptsms;
require_once app_path('Modules/Sms/Providers/Fptsms/TechAPI/bootstrap.php');

use App\Modules\Sms\Models\SmsProvider;
use TechAPI\Api\SendBrandnameOtp;
use TechAPI\Exception as TechException;
use TechAPI\Auth\AccessToken;

class Fptsms {

    public $config = [
        'url' => 'http://app.sms.fpt.net',
        'CLIENT_ID' => 'Your ID',
        'CLIENT_SECRET' => 'Your Secret',
        'SmsType' => 'send_brandname_otp',
        'note' => 'send_brandname_otp hoặc gửi nhiều dùng: send_brandname'
    ];

    public function getBalance(){

        return null;
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

        $provider = SmsProvider::where(['provider' => 'Fptsms', 'status' => 1])->first();
        $config = json_decode($provider->configs);

        $arrMessage = array(
            'Phone'      => $target_phone,
            'BrandName'  => $provider->brandname,
            'Message'    => $content
        );

        // Khởi tạo đối tượng API với các tham số phía trên.
        $apiSendBrandname = new SendBrandnameOtp($arrMessage);

        try
        {
            // Lấy đối tượng Authorization để thực thi API
            $oGrantType      = getTechAuthorization($config->CLIENT_ID, $config->CLIENT_SECRET, $config->SmsType);

            // Thực thi API
            $arrResponse     = $oGrantType->execute($apiSendBrandname);

            // kiểm tra kết quả trả về có lỗi hay không
            if (! empty($arrResponse['error']))
            {
                // Xóa cache access token khi có lỗi xảy ra từ phía server
                AccessToken::getInstance()->clear();

                // quăng lỗi ra, và ghi log
                throw new TechException($arrResponse['error_description'], $arrResponse['error']);
            }

            return $arrResponse;
        }
        catch (\Exception $ex)
        {
            return ['error' => $ex->getMessage()];
        }

    }

}
