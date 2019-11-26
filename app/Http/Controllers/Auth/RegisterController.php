<?php

namespace App\Http\Controllers\Auth;

use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\Wallet\Controllers\WalletController;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;


class RegisterController extends FrontendController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return redirect()->route('frontend.account.register');
        //return theme_view('account.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $setting = DB::table('settings')->where('key', 'require_username')->first();

        if( is_numeric($data['phoneOrEmail']) )
        {
            Validator::extend('number_phone', function($attribute, $value, $parameters, $validator) {
                if(!empty($value) && substr($value, 0, 1) == '0' ){
                    return true;
                }
                return false;
                });

            $array = [
                'username' => 'required|string|min:6|max:50|unique:users,username',
                'name' => 'required|string|max:255',
                'phoneOrEmail' => 'required|string|number_phone|max:11|unique:users,phone',
                'password' => 'required|string|min:6',
                'g-recaptcha-response'=>'required|recaptcha',
            ];

            if($setting->value == 0){
                unset($array['username']);
            }

                return Validator::make($data, $array);
        }else{


            $array = [
                'username' => 'required|string|min:6|max:50|unique:users,username',
                'name' => 'required|string|max:255',
                'phoneOrEmail' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6',
                'g-recaptcha-response'=>'required|recaptcha',
            ];

            if($setting->value == 0){
                unset($array['username']);
            }

            return Validator::make($data, $array);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $group_setting = \App\Modules\Setting\Models\Setting::where('key', 'default_user_group')->first();
        $group_id = null;
        if($group_setting->count()) {
            $group_id = $group_setting->value;
        }

        $approve = \App\Modules\Setting\Models\Setting::where('key', 'approve_user')->first();

        if( is_numeric($data['phoneOrEmail']) )
        {
            $userdata =  [
                'name' => $data['name'],
                'email' => null,
                'username' => (isset($data['username'])) ? str_slug($data['username']): null,
                'phone' => $data['phoneOrEmail'],
                'password' => Hash::make($data['password']),
                'group'=>$group_id,
                'status' => ($approve->value == 1) ? 0 : 1,
            ];
        }else{

            $userdata = [
            'name' => $data['name'],
            'email' => $data['phoneOrEmail'],
            'username' => (isset($data['username'])) ? str_slug($data['username']): null,
            'phone' => null,
            'password' => Hash::make($data['password']),
            'group'=>$group_id,
            'status' => ($approve->value == 1) ? 0 : 1,
        ];
        }


        DB::beginTransaction();
        try {
        $user = User::create($userdata);

        /// Tạo role USER
        DB::table('model_has_roles')->insert(
            ['role_id' => 5, 'model_type' => 'App\User', 'model_id'=>$user->id]
        );

        /// Tạo ví

        WalletController::makeWalletFromUserId($user->id);

        DB::commit();

            return $user;
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Đăng ký tài khoản thất bại. Vui lòng thử lại sau!']);
        }
    }
}
