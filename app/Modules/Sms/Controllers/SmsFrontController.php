<?php

namespace App\Modules\Sms\Controllers;

use App\Modules\Sms\Models\Sms;
use App\Modules\Wallet\Controllers\WalletController;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Log;
use Illuminate\Routing\Route;
use App\User;
use Carbon\Carbon;


class SmsFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function dangkysms(Request $request){

        $result = "1";
        try{
            //lấy mo
            $mo = $this->get_mo();
            Log::info(['Request' => $mo]);

            $setting_sms = DB::table('settings')->where('key', 'sms_command_code')->first();
            if(isset($mo['Command_Code']) && strtolower($mo['Command_Code']) == strtolower($setting_sms->value)){

                $mes = explode(" ", $mo['Message']);  ///Tsr ODP

                /// Lấy lại odp
                if(count($mes) > 0 && strtolower(trim($mes[1])) == 'odp'){

                    $user_phone = '0'.substr($mo['User_ID'], 2);

                        $sms = Sms::where('phone', $user_phone)->where('type', 'Odp')->where('created_at','<=', Carbon::now())->where('expired_at','>=', Carbon::now())->first();

                        if($sms){
                            $mt_message = "Ma ODP cua ban la: ". $sms->secret;

                            /// Gọi lệnh gửi sms
                            $this->send_mt($mo['User_ID'], $mt_message, $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                        }else{
                            $this->send_mt($mo['User_ID'], 'ODP chua ton tai trong he thong', $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                        }



                }elseif(count($mes) > 0 && strtolower(trim($mes[1])) == 'mk'){
                    $user_phone = '0'.substr($mo['User_ID'], 2);
                    $user = User::where('phone', $user_phone)->first();

                    if($user){

                        $new_pass = uniqid();
                        $mt_message = "Mat khau moi cua ban la: ". $new_pass;

                        $user->password = Hash::make($new_pass);
                        $user->update();

                        /// Gọi lệnh gửi sms
                        $this->send_mt($mo['User_ID'], $mt_message, $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                    }else{
                        $this->send_mt($mo['User_ID'], 'Khong tao duoc mat khau moi', $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                    }


                }elseif(count($mes) > 0 && strtolower(trim($mes[1])) == 'mkc2'){
                    $user_phone = '0'.substr($mo['User_ID'], 2);
                    $user = User::where('phone', $user_phone)->first();

                    if($user){

                        $new_pass = rand(100000,999999);
                        $mt_message = "Mat khau cap 2 moi cua ban la: ". $new_pass;

                        $user->mkc2 = md5($new_pass);
                        $user->update();

                        /// Gọi lệnh gửi sms
                        $this->send_mt($mo['User_ID'], $mt_message, $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                    }else{
                        $this->send_mt($mo['User_ID'], 'Khong tao duoc MCK2', $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                    }

                }elseif(count($mes) > 0 && strtolower(trim($mes[1])) == 'dk'){
                    $user_phone = '0'.substr($mo['User_ID'], 2);
                    $user = User::where('phone', $user_phone)->first();

                    if(!$user){

                        $check_u = User::where('username', $mes[2])->first();
                        if(!$check_u){

                            $new_pass = uniqid();
                            $mt_message = "Dang ky thanh cong ten dang nhap: ". $mes[2] ." va mat khau: ". $new_pass;


                            $group_setting = \App\Modules\Setting\Models\Setting::where('key', 'default_user_group')->first();
                            $group_id = null;
                            if($group_setting->count()) {
                                $group_id = $group_setting->value;
                            }

                            $approve = \App\Modules\Setting\Models\Setting::where('key', 'approve_user')->first();

                            $userdata =  [
                                'name' => $mes[2],
                                'email' => null,
                                'username' => $mes[2],
                                'phone' => $user_phone,
                                'password' => Hash::make($new_pass),
                                'group'=>$group_id,
                                'status' => ($approve->value == 1) ? 0 : 1,
                            ];

                            DB::beginTransaction();
                            try {
                                $user_s = User::create($userdata);

                                /// Tạo role USER
                                DB::table('model_has_roles')->insert(
                                    ['role_id' => 5, 'model_type' => 'App\User', 'model_id'=>$user_s->id]
                                );

                                WalletController::makeWalletFromUserId($user_s->id);

                                DB::commit();

                                $this->send_mt($mo['User_ID'], $mt_message, $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);


                            }catch (\Exception $e) {

                                $this->send_mt($mo['User_ID'], 'Loi tao tai khoan, vui long thu lai sau', $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);

                                DB::rollback();
                            }


                        }else{
                            $this->send_mt($mo['User_ID'], 'Ten tai khoan da ton tai trong he thong', $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                        }

                    }else{
                        $this->send_mt($mo['User_ID'], 'So dien thoai da ton tai trong he thong', $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                    }


                }else{

                    $this->send_mt($mo['User_ID'], 'Sai cu phap, vui long kiem tra lai', $mo['Service_ID'], $mo['Command_Code'], '1', $mo['Request_ID']);
                }

            }

        }catch(\Exception $e){
            Log::info(['LOISMSGATEWAY' => $e->getMessage()]);
        }

        //Trả về chuỗi XML, theo mẫu
        header('Content-Type: application/xml; charset=utf-8');
        echo "<SOAP-ENV:Envelope SOAP-ENV:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\" xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:SOAP-ENC=\"http://schemas.xmlsoap.org/soap/encoding/\"><SOAP-ENV:Body><ns1:messageReceiverResponse xmlns:ns1=\"urn:MOReceiver\"><return xsi:type=\"xsd:string\">" . $result . "</return></ns1:messageReceiverResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>";
        exit();
    }

    public function get_mo(){
        $myXMLData = file_get_contents("php://input");
        //debug("Received xml: " . $myXMLData);
        if (empty($myXMLData)) throw new \Exception('INVALID MO XML', -1);
        $xml = simplexml_load_string($myXMLData);
        if ($xml === false) throw new \Exception('INVALID MO XML', -1);
        else{
            if ($xml->soapenvBody && $xml->soapenvBody->messageReceiver) {
                $xml_mo = $xml->soapenvBody->messageReceiver;
                $mo = array(
                    'User_ID' 		=> ''. $xml_mo->User_ID,
                    'Service_ID' 	=> ''. $xml_mo->Service_ID,
                    'Command_Code' 	=> ''. $xml_mo->Command_Code,
                    'Message' 		=> ''. $xml_mo->Message,
                    'Request_ID' 	=> ''. $xml_mo->Request_ID,
                );

                return $mo;

            }else throw new \Exception('INVALID MO XML', -1);
        }
    }


    public function send_mt($userID,$message,$serviceID,$commandCode,$messageType,$requestID,$totalMessage='1',$messageIndex='1',$isMore='0',$contentType='0'){
        $xml =
            '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:mt="http://mt.webservice.ems.vmg.com">'.
            '<soapenv:Header/>'.
            '<soapenv:Body>'.
            '<mt:sendMT soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">'.
            '<userID xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$userID.'</userID>'.
            '<message xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$message.'</message>'.
            '<serviceID xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$serviceID.'</serviceID>'.
            '<commandCode xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$commandCode.'</commandCode>'.
            '<messageType xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$messageType.'</messageType>'.
            '<requestID xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$requestID.'</requestID>'.
            '<totalMessage xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$totalMessage.'</totalMessage>'.
            '<messageIndex xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$messageIndex.'</messageIndex>'.
            '<isMore xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$isMore.'</isMore>'.
            '<contentType xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">'.$contentType.'</contentType>'.
            '</mt:sendMT>'.
            '</soapenv:Body>'.
            '</soapenv:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://sendmt.vmgmedia.vn/api/services/sendMT');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml; charset=utf-8', 'SOAPAction: ""'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $output = curl_exec($ch);
        curl_close($ch);

        if ($output && strpos($output, "multiRef") !== false)
            return true;
        else
            return false;
    }


}
