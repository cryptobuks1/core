<?php

namespace App\Modules\Frontend\Controllers;

use App\Modules\Frontend\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use Hash;
use App;
use DB;
use App\Modules\Twofactor\Controllers\TwofactorController;
use \App\User;
use Gloudemans\Shoppingcart\Facades\Cart as Cart;
use App\Modules\Wallet\Models\Wallet;


class AccountController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }


    public function changePassword()
    {
        return theme_view('account.change-password');
    }

    public function postPassword(Request $request){
        $validator = $this->validate($request, [
            'old-pwd' => 'required|min:6|max:15',
            'new-pwd' => 'required|min:6|max:15',
            'new-pwd-confirmation' => 'same:new-pwd',
        ],[
            'old-pwd.required' => 'Mật khẩu không được để trống.',
            'new-pwd.required' => 'Mật khẩu mới không được để trống.',
            'min' => 'Mật khẩu phải nhiều hơn :min kí tự.',
            'max' => 'Mật khẩu không được nhiều hơn :max kí tự.',
            'same' => 'Xác nhận mật khẩu mới không trùng khớp.'
        ]);
        if(Auth::check()){
            $current_password = Auth::User()->password;
            if(Hash::check($request['old-pwd'], $current_password)){
                $user_id = Auth::User()->id;
                $obj_user = User::find($user_id);
                $obj_user->password = Hash::make($request['new-pwd']);;
                $obj_user->save();
                return redirect()->route('user.profile')
                        ->with('success','Mật khẩu của bạn đã được thay đổi thành công.');
            }else{
                return back()->withErrors(['message' =>'Mật khẩu hiện tại không chính xác.']);
            }
        }else{
            return abort(404);
        }
    }

    public function profile()
    {
        if(Auth::check()) {
            $user = User::find(Auth::user()->id);
            $userGroup = DB::table('groups')->where('id', $user->group)->select('name')->first();
            $walletlists = Wallet::where('user', Auth::user()->id )->get();
            foreach ($walletlists as $key => $wallet) {
                $wallets[$key]['number'] = $wallet->number;
                $wallets[$key]['balance'] = number_format($wallet->balance_decode);
                $wallets[$key]['currency_code'] = $wallet->currency_code;
            }
            return theme_view('account.profile', compact('user', 'wallets', 'userGroup'));
        }else {
            return redirect()->route('login');
        }




    }

    public function editprofile() {

        if(Auth::check()){

            $info = User::find(Auth::user()->id);

            return theme_view('account.editprofile', compact('info'));

        }else {
            return redirect()->route('login');
        }


    }


    public function posteditprofile(Request $request) {

        if(Auth::check()){
            $info = User::find(Auth::user()->id);

            $validateItems =[];
            $validateItems['name'] = 'required';
            $validateItems['gender'] = 'required';
            if(!$info->mkc2) {
                $validateItems['mkc2'] = 'required|numeric|digits:6';
            }

            if(!$info->email) {
                $validateItems['email'] = 'required|unique:users|email';
            }

            if(!$info->phone) {
                $validateItems['phone'] = 'required|unique:users|regex:/(0)[0-9]{9}/';
            }

            $this->validate($request, $validateItems);


            $info->name = $request->input('name');
            $info->gender = $request->input('gender');

            if(!$info->email) {
                $info->email = $request->input('email');
            }
            if(!$info->phone) {
                $info->phone = $request->input('phone');
            }

            if(!$info->mkc2){
                $info->mkc2 = sha1($request->input('mkc2'));
            }

            $info->update();

            return redirect()->route('user.profile')->with('success', 'Bạn đã cập nhật thành công!');

        }else {
            return redirect()->route('login');
        }


    }

    public static function requireUpdateProfile(){

        if(Auth::check()){

            $user_id = Auth::user()->id;

            $user = User::find($user_id);

            if($user->phone && $user->email){

            return true;

            }

        }
    }


}
