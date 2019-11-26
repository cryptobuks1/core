<?php

namespace App\Modules\Tool\Controllers;

use App\Modules\Charging\Models\Charging;
use App\Modules\Mtopup\Models\Mtopup;
use App\Modules\Order\Models\Order;
use App\Modules\Sms\Models\Sms;
use App\Modules\Softcard\Models\SoftcardOrder;
use App\Modules\Wallet\Controllers\WalletController;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use File;


class ToolController extends BackendController
{

    public function setmoney($amount)
    {

        WalletController::addAdminBalance($amount);
        return 'Da thiet lap tai khoan admin ' . $amount;
    }


    public function countadminmoney(){
        $user_money = Wallet::where('user', '!=', 1)->sum('balance_decode');

        $admin_m = 10000000000 - $user_money;

        WalletController::addAdminBalance($admin_m);
        return 'Da thiet lap tai khoan admin ' . $admin_m;

    }

    public function toolIndex(){

        ///Xóa charging
        $title = "Các tiện tích cho website";
        return view('Tool::tool', compact('title'));

    }

    public function postdelCharging(Request $request){

        $date = Carbon::now();

        $this->validate($request, [
            'charging_month' => 'required'
        ]);

        $charging_month = $request->charging_month;

        switch ($charging_month){
            case '7d':
                $del = $date->subDays(7)->endOfDay();
                break;
            case '1m':
                $del = $date->subMonth(1)->endOfDay();
                break;
            case '3m':
                $del = $date->subMonth(3)->endOfDay();
                break;
            case '6m':
                $del = $date->subMonth(6)->endOfDay();
                break;
            case '12m':
                $del = $date->subMonth(12)->endOfDay();
                break;
            default:
                $del = $date->subMonth(1)->endOfDay();
                break;
        }

        ini_set('max_execution_time', 300);

        try {
            Charging::where('created_at', '<', $del)->delete();
            Order::where('created_at', '<', $del)->where('module', 'Charging')->delete();
            WalletHistory::where('created_at', '<', $del)->delete();

            return redirect()->back()->with('success', 'Bạn đã xóa thành công');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }


    public function postdelMtopup(Request $request){

        $date = Carbon::now();

        $this->validate($request, [
            'mtopup_month' => 'required'
        ]);

        $mtopup_month = $request->mtopup_month;

        switch ($mtopup_month){

            case '7d':
                $del = $date->subDays(7)->endOfDay();
                break;
            case '1m':
                $del = $date->subMonth(1)->endOfDay();
                break;
            case '3m':
                $del = $date->subMonth(3)->endOfDay();
                break;
            case '6m':
                $del = $date->subMonth(6)->endOfDay();
                break;
            case '12m':
                $del = $date->subMonth(12)->endOfDay();
                break;
            default:
                $del = $date->subMonth(1)->endOfDay();
                break;
        }

        ini_set('max_execution_time', 300);

        try {
            Mtopup::where('created_at', '<', $del)->delete();
            Order::where('created_at', '<', $del)->where('module', 'Mtopup')->delete();
            WalletHistory::where('created_at', '<', $del)->delete();

            return redirect()->back()->with('success', 'Bạn đã xóa thành công');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }


    public function postdelOrder(Request $request){

        $date = Carbon::now();

        $this->validate($request, [
            'order_month' => 'required'
        ]);

        $order_month = $request->order_month;

        switch ($order_month){

            case '7d':
                $del = $date->subDays(7)->endOfDay();
                break;
            case '1m':
                $del = $date->subMonth(1)->endOfDay();
                break;
            case '3m':
                $del = $date->subMonth(3)->endOfDay();
                break;
            case '6m':
                $del = $date->subMonth(6)->endOfDay();
                break;
            case '12m':
                $del = $date->subMonth(12)->endOfDay();
                break;
            default:
                $del = $date->subMonth(1)->endOfDay();
                break;
        }

        ini_set('max_execution_time', 300);

        try {
            Mtopup::where('created_at', '<', $del)->delete();
            Charging::where('created_at', '<', $del)->delete();
            SoftcardOrder::where('created_at', '<', $del)->delete();
            Order::where('created_at', '<', $del)->delete();
            WalletHistory::where('created_at', '<', $del)->delete();

            return redirect()->back()->with('success', 'Bạn đã xóa thành công');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }


    public function postdelTrash(Request $request){

        $date = Carbon::now();

        $this->validate($request, [
            'trash_month' => 'required'
        ]);

        $order_month = $request->trash_month;

        switch ($order_month){

            case '7d':
                $del = $date->subDays(7)->endOfDay();
                break;
            case '1m':
                $del = $date->subMonth(1)->endOfDay();
                break;
            case '3m':
                $del = $date->subMonth(3)->endOfDay();
                break;
            case '6m':
                $del = $date->subMonth(6)->endOfDay();
                break;
            case '12m':
                $del = $date->subMonth(12)->endOfDay();
                break;
            default:
                $del = $date->subMonth(1)->endOfDay();
                break;
        }

        ini_set('max_execution_time', 300);

        try {
            Sms::where('created_at', '<', $del)->delete();
            DB::table('auth_logs')->where('created_at', '<', $del)->delete();
            DB::table('balance_logs')->where('created_at', '<', $del)->delete();

            File::delete(storage_path('logs/laravel.log'));

            return redirect()->back()->with('success', 'Bạn đã xóa thành công');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function postdelUser(Request $request){

        $this->validate($request, [
            'user' => 'required'
        ]);

        ini_set('max_execution_time', 300);

        try {

            $id = $request->user;
            if(is_numeric($id)){
                $user = User::where('phone', $id)->first();
            }else{
                $user = User::where('email', $id)->first();
            }

            if(!$user){
                return redirect()->back()->withErrors(['error' => 'Không tồn tại thành viên này!']);
            }

            Mtopup::where('user', $user->id)->delete();
            Charging::where('user', $user->id)->delete();
            SoftcardOrder::where('user', $user->id)->delete();
            Order::where('payer_id', $user->id)->delete();
            Order::where('payee_id', $user->id)->delete();
            WalletHistory::where('user_id', $user->id)->delete();
            Wallet::where('user', $user->id)->delete();
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            DB::table('auth_logs')->where('user_id', $user->id)->delete();
            DB::table('twofactors')->where('user_id', $user->id)->delete();
            Sms::where('user_id', $user->id)->delete();

            return redirect()->back()->with('success', 'Bạn đã xóa thành công');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function checkUserBalance(){
        echo 'Kiem tra so du thanh vien: ';
        ini_set('max_execution_time', 300);
        $users = User::all();

        foreach ($users as $user){
            $wallet = Wallet::where('user', $user->id)->first();
            $bl = \App\Helpers\CryptHelper::decodeCrypt($wallet->balance);
            $bl = floatval($bl);
            $bl = number_format($bl,5);

            $decode = floatval($wallet->balance_decode);
            $decode = number_format($decode,5);

            if($bl == $decode){
                continue;
            }else{
                print_r($wallet->number);
                echo'<br>';
            }




        }

    }


    public function checkuserwallet(Request $request, $wallet_number)
    {
        $wallet = Wallet::where('number', $wallet_number)->first();

        $bl = \App\Helpers\CryptHelper::decodeCrypt($wallet->balance);
        $bl = floatval($bl);
        $bl = number_format($bl,5,'.','');
        $bl = floatval($bl);

        $decode = floatval($wallet->balance_decode);
        $decode = number_format($decode,5,'.','');
        $decode = floatval($decode);

        var_dump($decode);
        echo '<br>';
        dd($bl);

    }

    public function exportdata(){

        $databaseName = env('DB_DATABASE');
        $userName = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        \Spatie\DbDumper\Databases\MySql::create()
            ->setDbName($databaseName)
            ->setUserName($userName)
            ->setPassword($password)
            ->dumpToFile('database.sql');


        $file= public_path(). "/database.sql";

        $headers = array(
            'Content-Type: application/text',
        );

        return response()->download($file,'database.sql', $headers);

    }


}