<?php

namespace App\Modules\Api\Controllers;

use App\Helpers\CurlHelper;
use App\Modules\Api\Models\Api;
use App\Modules\Api\Models\Purse;
use App\Modules\Charging\Models\Charging;
use App\Modules\Mtopup\Models\Mtopup;
use App\Modules\Order\Models\Order;
use App\Modules\Softcard\Models\SoftcardOrder;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletHistory;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use App\Modules\Charging\Models\ChargingProvider;
use \App\User;
use App\Modules\Wallet\Controllers\WalletController;
use App\Modules\Sms\Controllers\SmsController;


class ApiController extends BackendController
{


    public function testfuck()
    {

        $url = 'https://api.mincasoft.io:8817/viettelpaypro/auth/login';

        $data = array();
        $data['AgentCode'] = '6100550160';
        $data['Pin'] = '171288';


        $result = CurlHelper::post_json($url, $data);
        $result = json_decode($result, true);
        dd($result);

    }

    ///$days là số, ví dụ 90 thì là 90 ngày trở về trước
    public function delCharging($days)
    {

    }


    public function kiemtra()
    {

        ini_set('max_execution_time', 300);
        $orders = Order::all();

        foreach ($orders as $order) {

            $mau = 'seri:';

            $check = strpos($order->description, $mau);

            if ($check) {

                $item = Order::where('description', $order->description)->get();
                if (count($item) > 1) {
                    $data[] = $order->description;
                }

            } else {
                continue;
            }


        }

        dd($data);

    }


    public function convertuser()
    {

        ini_set('max_execution_time', 3000);

        $old_user = Api::get();

        $i = 0;
        foreach ($old_user as $user) {

            $purse = Purse::where(['user_id' => $user->id])->first();

            if ($purse) {
                $user->balance_decode = $purse->balance_decode;
                $user->update();

                $i++;
            } else {

                continue;
            }

        }

        echo 'xong ' . $i;


    }

    public function xoauserkhongtien()
    {
        ini_set('max_execution_time', 3000);
        $users = Api::where('balance_decode', '<', 10000)->get();

        foreach ($users as $user) {
            $user->delete();
        }


    }

    public function xoapurekhongtien()
    {
        ini_set('max_execution_time', 3000);
        $users = Purse::where('balance_decode', 0)->get();

        foreach ($users as $user) {
            $user->delete();
        }


    }


    public function createuser()
    {

        ini_set('max_execution_time', 3000);

        $old_user = Api::get();

        $i = 0;
        foreach ($old_user as $luser) {

            if($luser->blocked == 1){
                continue;
            }

            if (!filter_var($luser->email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            $exist_email = User::where('email', $luser->email)->first();
            if ($exist_email) {
                continue;
            }

            $exist_phone = User::where('phone', $luser->phone)->first();
            if ($exist_phone) {
                continue;
            }

            DB::beginTransaction();

            try {
                $userdata = [
                    'name' => $luser->name,
                    'email' => $luser->email,
                    'username' => $luser->username,
                    'phone' => (isset($luser->phone)) ? $luser->phone : null,
                    'password' => Hash::make($luser->email),
                    'group' => 2,
                    'status' => 1
                ];

                $user = User::create($userdata);

                WalletController::makeWalletFromUserIdwithBalance($user->id, (int)$luser->balance_decode);

                DB::table('model_has_roles')->insert(
                    ['role_id' => 5, 'model_type' => 'App\User', 'model_id' => $user->id]
                );
                DB::commit();

                $i++;
            } catch (\Exception $e) {

                DB::rollback();
                continue;
            }


        }

        echo 'them dc '.$i .' thanh vien';


    }


    public function convert_create_user_v2()
    {


        ini_set('max_execution_time', 3000);

        $old_user = Api::get();

        foreach ($old_user as $luser) {

            if (!filter_var($luser->email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            /// Kiểm tra user này tồn tại hay chưa
            $exist_email = User::where('email', $luser->email)->first();
            if ($exist_email) {
                continue;
            }

            $exist_phone = User::where('phone', $luser->phone)->first();
            if ($exist_phone) {
                continue;
            }

            DB::beginTransaction();

            try {
                $userdata = [
                    'name' => $luser->name,
                    'email' => $luser->email,
                    'username' => null,
                    'phone' => (isset($luser->phone)) ? $luser->phone : null,
                    'password' => Hash::make($luser->username),
                    'group' => 2,
                    'status' => 1
                ];

                $user = User::create($userdata);

                WalletController::makeWalletFromUserIdwithBalance($user->id, (int)$luser->balance_decode);

                DB::table('model_has_roles')->insert(
                    ['role_id' => 5, 'model_type' => 'App\User', 'model_id' => $user->id]
                );
                DB::commit();
            } catch (\Exception $e) {

                DB::rollback();
                continue;
            }


        }

        echo 'xong';


    }


    public function xoapurekhongtien_v2()
    {
        ini_set('max_execution_time', 3000);
        $users = Api::where('balance_decode', 0)->get();

        foreach ($users as $user) {
            $user->delete();
        }


    }


    public function updatematkhau()
    {

        ini_set('max_execution_time', 3000);
        $users = User::all();
        foreach ($users as $user) {

            if ($user->id == 1 || $user->id == 25) {
                continue;
            } else {
                $user->password = Hash::make($user->phone);
                $user->update();

            }

        }

        echo "Ngon roi";
    }


    public function updateusername()
    {
        ini_set('max_execution_time', 3000);
        $u_cu = Api::all();
        foreach ($u_cu as $cu) {

            $u_moi = User::where('phone', $cu->phone)->first();
            if ($u_moi) {
                if ($u_moi->username) {
                    continue;
                } else {
                    try {
                        $u_moi->username = $cu->username;
                        $u_moi->update();
                    } catch (\Exception $e) {
                        continue;
                    }

                }

            } else {
                continue;
            }
        }

        echo 'xong';

    }


    public function test()
    {


        $abc = new SmsController;

        $b = $abc->sendSms(null, '0943793984', 'Ma xac thuc OTP cua ban la: 878545', 'Esms', 'odp');


        return $b;


//        $request = new \stdClass();
//        $request->real = "100000";
//
//        dd($request->real);
//
//
//
//
//        $p_item = ChargingProvider::where('provider', 'Ncode')->first();
//
//        $p_config = json_decode($p_item->configs);
//
//        dd($p_config->post_url);
//
//
//	    $settingM = DB::table('settings_module')->where('key', 'chargingprovider')->first();
//
//        dd($settingM->value);

        //WalletController::addAdminBalance(10000000000);


    }

    public function submit()
    {

        return view('Api::submit');
    }

    public function postsubmit(Request $request)
    {


        $data = new Api;
        $data->name = $request->input('name');
        $data->url = $request->input('url');
        usleep(1000000);
        $data->save();

        return response()->json(['iput' => 'Thanh cong']);

    }


    public function updatecode()
    {
        ini_set('max_execution_time', 3000);
        $his = WalletHistory::all();

        foreach ($his as $h) {

            if ($h->order_code) {

                $code = substr($h->order_code, 0, 1);
                $h->code = $code;
                $h->update();

            } else {
                continue;
            }

        }
    }

    public function updatesc()
    {
        ini_set('max_execution_time', 3000);
        $his = SoftcardOrder::all();

        foreach ($his as $h) {

            if (!$h->sumvalue) {

                $h->sumvalue = $h->value * $h->qty;
                $h->update();

            } else {
                continue;
            }

        }
        echo 'xong';
    }


}