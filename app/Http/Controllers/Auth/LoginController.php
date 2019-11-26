<?php

namespace App\Http\Controllers\Auth;
use App\Modules\Frontend\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends FrontendController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function __construct()
    {   parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return redirect()->route('frontend.account.login');
        //return theme_view('account.login');
    }

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            $check = DB::table('users')->where('phone', $request->get('email'))->first();
            if($check){
                return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
            }else{
                return ['username'=>$request->get('email'),'password'=>$request->get('password')];
            }

        }else{

            if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
                return ['email'=>$request->get('email'),'password'=>$request->get('password')];
            }else{
                return ['username'=>$request->get('email'),'password'=>$request->get('password')];
            }
        }



        return $request->only($this->username(), 'password');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function authenticated()
    {
        $user = User::find(Auth::user()->id);
        $setting = DB::table('settings')->where('key', 'require_phone')->first();

        if($user->status == 0){
            Auth::logout();
            return redirect()->route('home')->withErrors(['error' =>'Tài khoản chưa được chúng tôi kích hoạt hoặc bị khóa!']);
        }else{

            /// Ghi log
            $input = array();
            $input['user_id'] = auth()->user()->id;
            $input['phone'] = (auth()->user()->phone) ? auth()->user()->phone : null;
            $input['email'] = (auth()->user()->email) ? auth()->user()->email : null;
            $input['ip'] = getIpClient();
            $input['twofactor'] = null;
            $input['user_agent'] = request()->server('HTTP_USER_AGENT');
            $input['created_at'] = now();
            $input['updated_at'] = now();
            DB::table('auth_logs')->insert($input);

            if(auth()->user()->hasRole('BACKEND'))
            {
                Auth::logout();
            }

            if($setting && $setting->value == 1 && !$user->phone){
                return redirect()->route('edit.profile')->withErrors(['error' => 'Vui lòng cập nhật số điện thoại!']);
            }else{
                return redirect()->route('home');
            }


        }

    }

}
