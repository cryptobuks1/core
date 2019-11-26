<?php

namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\Api;
use App\Modules\Language\Models\Language;
use App\Modules\Setting\Models\Setting;
use App\Modules\User\Helpers\UserHelper;
use App\Modules\User\Models\User as UserModel;
use App\Modules\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use App\Helpers\CurlHelper;
use Illuminate\Support\Facades\Mail;
use Log;
use File;
use Lang;
use Hash;
use Cache;
use GeoIp2\Database\Reader;
use Illuminate\Routing\Route;

class AppUserController extends FrontendController
{

    public $client_ip;
    public $app_key;

    public function __construct()
    {
        parent::__construct();
        $this->app_key = config('app.MOB_KEY');
    }

    public function appUserRegister(Request $request)
    {

        $this->client_ip = getIpClient();

        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        $data = array();
        ///Api user login
        if (!isset($request->phone_email) || !isset($request->password) || !isset($request->type) || !isset($request->name) ) {
            return $this->set_output(616);
        } else {

            if(isset($request->username) && $request->username){
                $check = UserModel::where('username', $request->username)->first();
                if($check){
                    return $this->set_output(617);
                }else{
                    $data['username'] = $request->username;
                }
            }

            $data['name'] = $request->name;

            if(strlen($request->password) < 6){
                return $this->set_output(615);
            }
            $data['password'] = Hash::make($request->password);

            $data['phone'] = null;
            $data['email'] = null;
            if($request->type == 'phone'){

                if(!is_numeric($request->phone_email)){
                    return $this->set_output(610);
                }else{

                    $check = UserModel::where('phone', $request->phone_email)->first();
                    if($check){
                        return $this->set_output(612);
                    }else{
                        $data['phone'] = $request->phone_email;
                    }
                }

            }else{
                if (!filter_var($request->phone_email, FILTER_VALIDATE_EMAIL)) {
                    return $this->set_output(611);
                }else{

                    $check = UserModel::where('email', $request->phone_email)->first();
                    if($check){
                        return $this->set_output(613);
                    }else{
                        $data['email'] = $request->phone_email;
                    }

                }
            }

            if($data['phone'] == null && $data['email'] == null){
                return $this->set_output(614);
            }

            try {
                $reader = new Reader(storage_path('app/GeoIP2-Country.mmdb'));
                $record = $reader->country($this->client_ip);
                $country_code = $record->registeredCountry->isoCode;
            } catch (\Exception $k) {
                $country_code = 'VN';
            }
            $data['country_code'] = $country_code;

            $group_setting = \App\Modules\Setting\Models\Setting::where('key', 'default_user_group')->first();
            $group_id = 2;  // Mặc định nhóm thành viên
            if ($group_setting) {
                $group_id = $group_setting->value;
            }
            $data['group'] = $group_id;
            $data['ip'] = $this->client_ip;

            $approve = \App\Modules\Setting\Models\Setting::where('key', 'approve_user')->first();
            $data['status'] = ($approve->value == 1) ? 0 : 1;
            $data['parent_id'] = 1;
            $data['ref'] = uniqid();

            $result = UserHelper::createUser($data);
            return $result;
        }
    }


    public function appUserLogin(Request $request)
    {

        $this->client_ip = getIpClient();

        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        $data = array();
        ///Api user login
        if (!isset($request->username) || !isset($request->password)) {
            return $this->set_output(604);
        } else {
            $data['username'] = $request->username;
            $data['password'] = $request->password;
            $data['remember'] = isset($request->remember) ? 1 : 0;
            $result = UserHelper::user_login($data);

            return $result;
        }
    }

    public function appUserLogout(Request $request)
    {
        $this->client_ip = getIpClient();
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        if (!isset($request->api_token) || !$request->api_token) {
            return $this->set_output(605);
        }

        if (!isset($request->user_id) || !$request->user_id) {
            return $this->set_output(606);
        }

        if($request->user_id == 1){
            return null;
        }

        $userinfo = UserModel::where('id', $request->user_id)->where('api_token', $request->api_token)->first();

        if($userinfo){
            $userinfo->api_token= null;
            $userinfo->api_token_created = null;
            $userinfo->update();
            return $this->set_output(0);
        }else{
            return null;
        }

    }

    ///Hàm đổi password
    public function appUserChangePassword(Request $request)
    {
        $this->client_ip = getIpClient();
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        if (!isset($request->api_token) || !$request->api_token) {
            return $this->set_output(605);
        }

        if (!isset($request->user_id) || !$request->user_id) {
            return $this->set_output(606);
        }
        if($request->user_id == 1){
            return null;
        }

        if (!isset($request->old_password) || !isset($request->new_password)) {
            return $this->set_output(607);
        }

        if (strlen($request->new_password) < 6 ) {
            return $this->set_output(608);
        }

        $userinfo = UserModel::where('id', $request->user_id)->where('api_token', $request->api_token)->first();

        if($userinfo){

            if (!Hash::check($request->old_password, $userinfo->password)) {
                return $this->set_output(609);
            }

            $userinfo->password= Hash::make($request->new_password);
            $userinfo->api_token= null;
            $userinfo->api_token_created = null;
            $userinfo->update();
            return $this->set_output(0);
        }else{
            return null;
        }

    }


    public function appUserUpdate(Request $request)
    {

        $this->client_ip = getIpClient();
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        if (!isset($request->api_token) || !$request->api_token) {
            return $this->set_output(605);
        }

        if (!isset($request->user_id) || !$request->user_id) {
            return $this->set_output(606);
        }

        if($request->user_id == 1){
            return null;
        }

        $allow_fields = UserHelper::UserUpdateCheck();
        if(count($allow_fields) == 0){
            return null;
        }
        $userinfo = UserModel::where('id', $request->user_id)->where('api_token', $request->api_token)->first();
        if($userinfo){

            if(in_array('phone', $allow_fields)){

                if(!isset($request->phone) || $request->phone == null){
                    return $this->set_output(618);
                }

                if(!is_numeric($request->phone)){
                    return $this->set_output(610);
                }else{
                    $check = UserModel::where('phone', $request->phone)->first();
                    if($check){
                        return $this->set_output(612);
                    }
                }

            }

            if(in_array('email', $allow_fields)){

                if(!isset($request->email) || $request->email == null){
                    return $this->set_output(619);
                }

                if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    return $this->set_output(611);
                }else{

                    $check = UserModel::where('email', $request->email)->first();
                    if($check){
                        return $this->set_output(613);
                    }
                }

            }

            if(in_array('username', $allow_fields)){

                if(!isset($request->username) || $request->username == null){
                    return $this->set_output(620);
                }

                $check = UserModel::where('username', $request->username)->first();
                if($check){
                    return $this->set_output(617);
                }

            }

            $input = array();
            foreach ($allow_fields as $field){

                if(isset($request->$field) && $request->$field !== null){
                    $input[$field] = $request->$field;
                }else{
                    continue;
                }
            }

            if(count($input) > 0){
                try{
                    $userinfo->update($input);
                    return $this->set_output(0);
                }catch (\Exception $e){
                    return null;
                }
            }

        }else{
            return null;
        }

    }


    public function appUserInfo(Request $request)
    {
        $this->client_ip = getIpClient();
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        if (!isset($request->api_token) || !$request->api_token) {
            return $this->set_output(605);
        }

        if (!isset($request->user_id) || !$request->user_id) {
            return $this->set_output(606);
        }

        if($request->user_id == 1){
            return null;
        }

        $userinfo = UserModel::where('id', $request->user_id)->where('api_token', $request->api_token)->first();
        if($userinfo){
            $wallet = Wallet::where('user', $userinfo->id)->get();
            $userinfo->wallet = $wallet;

            return $userinfo;
        }else{
            return null;
        }
    }

    public function appGetName(Request $request)
    {
        $this->client_ip = getIpClient();
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        if (!isset($request->api_token) || !$request->api_token) {
            return $this->set_output(605);
        }

        if (!isset($request->username) || !$request->username) {
            return $this->set_output(623);
        }

        $name = UserHelper::getName($request->username);
        return $name;
    }


    protected function set_output($error_code)
    {
        $output = array();
        $output['error_code'] = $error_code;
        $output['message'] = Api::error_code($error_code);
        echo json_encode($output);
    }


}
