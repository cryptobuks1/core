<?php
namespace App\Modules\User\Controllers;

use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\User\Models\User as UserModel;
use App\Modules\User\Models\User;
use App\Modules\User\Helpers\FlightHelper;
use App\Modules\User\Models\UserImage;
use App\Modules\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use GeoIp2\Database\Reader;
use Auth;
use Carbon\Carbon;
use Session;
use Cookie;
use DB;




class UserFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();
    }

    //Phần admin đăng nhập
    public function getLoginAdmin(Request $request)
    {

        if(!Auth::check()){
            session()->forget('stoken');
            session()->forget('temp_userid');
            return theme_view('account.admin.login');
        }else{
            return redirect()->route('home');
        }

    }


    //// Phan danh cho admin
    public function postLoginAdmin(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $user_temp = UserModel::where('email', $request->email)->first();

        if(!$user_temp){
            return redirect()->back()->withErrors(['error' => 'Email không tồn tại. Lưu ý: Nhập quá 5 lần sẽ bị khóa IP!']);
        }


        $remember = ($request->has('remember')) ? 1 : 0;

        if (Hash::check($request->password, $user_temp->password)) {
            $current_2fa = DB::table('settings')->where('key', 'twofactor')->first();
            $twofactor = null;

            if ($current_2fa->value == 'none') {

                $credentials = array('email' => $request->email, 'password' => $request->password, 'status' => 1);
                if (Auth::attempt($credentials, $request->has('remember'))) {

                    if (Auth::user()->hasRole('SUPER_ADMIN|BACKEND')) {

                        if(!isset($_SESSION))
                        {
                            session_start();
                        }
                        $_SESSION['ckfinder_enabled'] = 'enabled';

                        /// Ghi log
                        $input = array();
                        $input['user_id'] = Auth::user()->id;
                        $input['phone'] = (Auth::user()->phone) ? Auth::user()->phone : null;
                        $input['email'] = (Auth::user()->email) ? Auth::user()->email : null;
                        $input['ip'] = getIpClient();
                        $input['twofactor'] = null;
                        $input['user_agent'] = $request->server('HTTP_USER_AGENT');
                        $input['created_at'] = now();
                        $input['updated_at'] = now();
                        DB::table('auth_logs')->insert($input);

                        $backenUrl = config('backend.backendRoute');
                        return redirect('/' . $backenUrl);

                    } else {
                        Auth::logout();
                        return redirect()->route('home');
                    }

                } else {
                    return redirect()->back()->withErrors(['error' => 'Đăng nhập thất bại!']);
                }


            } else {
                $ip = getIpClient();
                $stoken = sha1($user_temp . '@system@' . $ip);

                session()->put('stoken', $stoken);
                session()->put('temp_userid', $user_temp->id);

                $twofactor = \App\Modules\Twofactor\Controllers\TwofactorController::challenge('2factor_nologin', 'AdminLogin_' . $user_temp->id);

                return theme_view('account.admin.confirm', compact('twofactor', 'remember', 'stoken'));

            }


        } else {
            unset($user_temp);
            return redirect()->back()->withErrors(['flash-message' => 'Sai thông tin đăng nhập!']);
        }


    }


    public function postConfirmAdmin(Request $request)
    {
        $temp_userid = session()->get('temp_userid');
        $stoken = session()->get('stoken');

        if (isset($stoken) && isset($temp_userid)) {

            $this->validate($request, [
                'check2fa' => 'required',
                'stoken' => 'required'
            ]);


            // Kiểm tra 2fa
            $valid = \App\Modules\Twofactor\Controllers\TwofactorController::validate_challenge($request->check2fa, '2factor_nologin', 'AdminLogin_' . $temp_userid);

            if($valid === true){

                $ip = getIpClient();

                $user = UserModel::find($temp_userid);
                $stoken_validate = sha1($user . '@system@' . $ip);

                if ($request->input('stoken') === session()->get('stoken') && session()->get('stoken') === $stoken_validate) {

                    if($request->remember == 1){
                        Auth::loginUsingId($temp_userid, true);
                    }else{
                        Auth::loginUsingId($temp_userid);
                    }

                    if (Auth::user()->hasRole('SUPER_ADMIN|BACKEND')) {

                        /// Ghi log
                        $input = array();
                        $input['user_id'] = Auth::user()->id;
                        $input['phone'] = (Auth::user()->phone) ? Auth::user()->phone : null;
                        $input['email'] = (Auth::user()->email) ? Auth::user()->email : null;
                        $input['ip'] = $ip;
                        $input['twofactor'] = $request->check2fa;
                        $input['user_agent'] = $request->server('HTTP_USER_AGENT');
                        $input['created_at'] = now();
                        $input['updated_at'] = now();
                        DB::table('auth_logs')->insert($input);

                        $backenUrl = config('backend.backendRoute');
                        return redirect('/' . $backenUrl);

                    } else {
                        Auth::logout();
                        return redirect()->route('home');
                    }


                } else {

                    return redirect()->back()->withErrors(['error' => 'Sai mã token!']);
                }


            }else{
                return redirect()->back()->withErrors(['error' => 'Mã bảo mật không đúng!']);
            }


        } else {

            return redirect()->back();
        }


    }


    ///Phần user
    public function create(Request $request)
    {


        if (auth()->check()) {
            return redirect()->route('home');
        }
        $ref = (isset($request->ref)) ? strip_tags($request->ref) : Cookie::get('ref');
        return theme_view('account.user.register', compact('ref'));
    }

    public function store(Request $request)
    {
        try {
            $reader = new Reader(storage_path('app/GeoIP2-Country.mmdb'));
            $record = $reader->country(getIpClient());
            $country_code = $record->registeredCountry->isoCode;
        } catch (\Exception $k) {
            $country_code = 'VN';
        }

        $setting = DB::table('settings')->where('key', 'require_username')->first();

        if (!isset($request->phoneOrEmail)) {
            return redirect()->back();
        }

        if (is_numeric($request->phoneOrEmail)) {
            $array = [
                'username' => 'required|string|min:6|max:50|unique:users,username',
                'name' => 'required|string|max:255',
                'phoneOrEmail' => 'required|string|max:11|unique:users,phone|unique:users,username',
                'password' => 'required|string|min:6',
//                'g-recaptcha-response' => 'required|recaptcha',
            ];

        } else {

            $array = [
                'username' => 'required|string|min:6|max:50|unique:users,username',
                'name' => 'required|string|max:255',
                'phoneOrEmail' => 'required|string|email|max:255|unique:users,email|unique:users,username',
                'password' => 'required|string|min:6',
//                'g-recaptcha-response' => 'required|recaptcha',
            ];
        }
        if ($setting->value == 0) {
            unset($array['username']);
        }

        $this->validate($request, $array);

        $parent = null;
        if($request->has('ref') && $request->ref != null){
            $ref = $request->ref;
        }
        else{
            $ref = Cookie::get('ref');
        }

        if (isset($ref)) {
            $parent_obj = UserModel::where('ref', $ref)->first();
            if ($parent_obj) {
                $parent = UserModel::find($parent_obj->id);
            } else {
                $parent = null;
            }
        }
        $group_setting = \App\Modules\Setting\Models\Setting::where('key', 'default_user_group')->first();
        $group_id = 2;  // Mặc định nhóm thành viên
        if ($group_setting) {
            $group_id = $group_setting->value;
        }

        $approve = \App\Modules\Setting\Models\Setting::where('key', 'approve_user')->first();

        if (is_numeric($request->phoneOrEmail)) {
            $userdata = [
                'name' => $request->name,
                'email' => null,
                'username' => (isset($request->username)) ? str_slug($request->username) : null,
                'phone' => $request->phoneOrEmail,
                'password' => Hash::make($request->password),
                'group' => $group_id,
                'country_code' => $country_code,
//                'parent_id' => $parent,
                'ref' => uniqid(),
                'ip' => getIpClient(),
                'status' => ($approve->value == 1) ? 0 : 1,
            ];
        } else {

            $userdata = [
                'name' => strip_tags($request->name),
                'email' => $request->phoneOrEmail,
                'username' => (isset($request->username)) ? str_slug(strip_tags($request->username)) : null,
                'phone' => null,
                'password' => Hash::make($request->password),
                'group' => $group_id,
                'country_code' => $country_code,
                'parent_id' => $parent,
                'ref' => uniqid(),
                'ip' => getIpClient(),
                'status' => ($approve->value == 1) ? 0 : 1,
            ];
        }

        $user =  FlightHelper::createUser($userdata,$parent);

        if ($user && isset($user->id)) {

            if ($user->status == 1) {
                auth()->login($user);
                return redirect()->route('home')->with('success', 'Đăng ký thành công!');
            } else {

                return redirect()->route('home')->with('success', 'Đăng ký thành công! Tài khoản của bạn sẽ được kích hoạt sau ít phút nữa!');
            }


        } else {
            return redirect()->back()->withErrors(['error' => 'Đăng ký tài khoản thất bại!']);
        }


    }


    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return theme_view('account.user.login');
    }

    public function postLogin(Request $request)
    {

        if (!isset($request->phoneOrEmail) || !isset($request->password)) {
        return redirect()->back();
    }

        if (filter_var($request->phoneOrEmail, FILTER_VALIDATE_EMAIL)) {

            $array = [
                'phoneOrEmail' => 'required|email|max:255',
                'password' => 'required|string|min:6',
            ];
            $login = 'email';
            $temp_user = UserModel::where('email', $request->phoneOrEmail)->where('status', 1)->first();

        } else {
            $temp_user = UserModel::where('phone', $request->phoneOrEmail)->where('status', 1)->first();
            if (is_numeric($request->phoneOrEmail) && $temp_user) {

                $array = [
                    'phoneOrEmail' => 'required|numeric|digits:10',
                    'password' => 'required|string|min:6',
                ];
                $login = 'phone';

            } else {

                $temp_user = UserModel::where('username', $request->phoneOrEmail)->where('status', 1)->first();

                $array = [
                    'phoneOrEmail' => 'required|string|max:255',
                    'password' => 'required|string|min:6',
                ];
                $login = 'username';
            }
        }

        $this->validate($request, $array);
        if (!$temp_user) {
            return redirect()->back()->withErrors(['error' => 'Thông tin tài khoản không đúng hoặc bị khóa!']);
        }

        if ($temp_user->failed > 5) {

            $temp_user->status = 0;
            $temp_user->failed_reason = 'Đăng nhập sai quá 5 lần';
            $temp_user->update();
            return redirect()->back()->withErrors(['error' => 'Thông tin tài khoản không đúng!']);
        }

        $remember = ($request->has('remember')) ? true : false;
        ///Thông tin gửi lên
        $user_login[$login] = $request->phoneOrEmail;
        $user_login['password'] = $request->password;

        if (Auth::attempt($user_login, $remember)) {

            /// Ghi log
            $input = array();
            $input['user_id'] = auth()->user()->id;
            $input['phone'] = (auth()->user()->phone) ? auth()->user()->phone : null;
            $input['email'] = (auth()->user()->email) ? auth()->user()->email : null;
            $input['ip'] = getIpClient();
            $input['twofactor'] = null;
            $input['user_agent'] = $request->server('HTTP_USER_AGENT');
            $input['created_at'] = now();
            $input['updated_at'] = now();
            DB::table('auth_logs')->insert($input);


            if(Auth::user()->hasRole('BACKEND'))
            {
                Auth::logout();
            }
            if(Auth::check()){
                Cookie::queue('user_secure', md5(Auth::user()->email.Auth::user()->phone.Auth::user()->username), 1200);
            }
            return redirect()->route('home');
        } else {


            $temp_user->failed++;
            return redirect()->back()->withErrors(['error' => 'Đăng nhập thất bại! Lưu ý nếu quá 5 lần tài khoản của bạn sẽ bị tạm khóa!']);
        }


    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home')->with('success','Tài khoản đã được thoát thành công!');
    }


    public function changePassword()
    {
        return theme_view('account.change-password');
    }

    public function postPassword(Request $request)
    {
        $validator = $this->validate($request, [
            'old-pwd' => 'required|min:6|max:15',
            'new-pwd' => 'required|min:6|max:15',
            'new-pwd-confirmation' => 'same:new-pwd',
        ], [
            'old-pwd.required' => 'Mật khẩu không được để trống.',
            'new-pwd.required' => 'Mật khẩu mới không được để trống.',
            'min' => 'Mật khẩu phải nhiều hơn :min kí tự.',
            'max' => 'Mật khẩu không được nhiều hơn :max kí tự.',
            'same' => 'Xác nhận mật khẩu mới không trùng khớp.'
        ]);
        if (Auth::check()) {
            $current_password = Auth::User()->password;
            if (Hash::check($request['old-pwd'], $current_password)) {
                $user_id = Auth::User()->id;
                $obj_user = UserModel::find($user_id);
                $obj_user->password = Hash::make($request['new-pwd']);
                $obj_user->save();
                return redirect()->route('user.profile')
                    ->with('success', 'Mật khẩu của bạn đã được thay đổi thành công.');
            } else {
                return back()->withErrors(['message' => 'Mật khẩu hiện tại không chính xác.']);
            }
        } else {
            return abort(404);
        }
    }

    public function profile()
    {

        if (Auth::check()) {
            $user = UserModel::find(Auth::user()->id);

            $userGroup = DB::table('groups')->where('id', $user->group)->select('name')->first();
            $walletlists = Wallet::where('user', Auth::user()->id)->get();
            foreach ($walletlists as $key => $wallet) {
                $wallets[$key]['number'] = $wallet->number;
                $wallets[$key]['balance'] = number_format($wallet->balance_decode);
                $wallets[$key]['currency_code'] = $wallet->currency_code;
            }

            $logs = \App\Modules\Backend\Models\LoginLog::where('user_id', $user->id)->limit(5)->orderBy('id','DESC')->get();

            return theme_view('account.profile', compact('user', 'wallets', 'userGroup', 'logs'));
        } else {
            return redirect()->route('frontend.account.login');
        }
    }

    public function editprofile()
    {

        if (Auth::check()) {

            $info = UserModel::find(Auth::user()->id);

            return theme_view('account.editprofile', compact('info'));

        } else {
            return redirect()->route('frontend.account.login');
        }


    }


    public function posteditprofile(Request $request)
    {

        if (Auth::check()) {
            $info = UserModel::find(Auth::user()->id);

            $validateItems = [];

            if (!$info->username) {
                $validateItems['username'] = 'required';
            }

            $validateItems['name'] = 'required';
            $validateItems['gender'] = 'required';
            if (!$info->mkc2) {
                $validateItems['mkc2'] = 'required';
            }

            if (!$info->email) {
                $validateItems['email'] = 'required|unique:users|email';
            }

            if (!$info->phone) {
                $validateItems['phone'] = 'required|unique:users|regex:/(0)[0-9]{9}/';
            }

            $this->validate($request, $validateItems);

            if (!$info->username) {
                $info->username = $request->input('username');
            }

            $info->name = $request->input('name');
            $info->gender = $request->input('gender');

            if (!$info->email) {
                $info->email = $request->input('email');
            }
            if (!$info->phone) {
                $info->phone = $request->input('phone');
            }

            if (!$info->mkc2) {
                $info->mkc2 = sha1($request->input('mkc2'));
            }

            $info->update();

            return redirect()->route('user.profile')->with('success', 'Bạn đã cập nhật thành công!');

        } else {
            return redirect()->route('frontend.account.login');
        }


    }

    public static function requireUpdateProfile()
    {

        if (Auth::check()) {

            $user_id = Auth::user()->id;
            $user = UserModel::find($user_id);
            if ($user->phone && $user->email) {
                return true;
            }

        }
    }


    public function resetpassword(){

        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return theme_view('account.passwords.email');
        }
    }

    public function postresetpassword(Request $request){

        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $post_email = strip_tags($request->email);

        $user = UserModel::where('email', $post_email)->first();

        if (!$user) {

            return redirect()->back()->withErrors(['error' => 'Email không tồn tại trong hệ thống']);
        }
        $tmp = md5($user->email.$user->password.$user->id);
        $today = Carbon::today()->format('d-m-Y');

        $token = sha1($tmp.$today);

        $user->tmp = $tmp;
        $user->tmp_token = $token;
        $user->update();

        $link = url('account/password/verify').'?user='.$user->email.'&token='.$token;

        $subject = 'Quên mật khẩu';
        $content = "Để khôi phục lại mật khẩu vui lòng nhấn vào đường dẫn bên dưới:<br>";
        $content .= "<a href='$link'>$link</a>";

        $mail = new \App\Modules\Sendmail\Controllers\SendmailController;
        $mail->sendmail($subject, $content, $post_email);

        return redirect()->back()->with('success', 'Một email khôi phục mật khẩu đã được gửi đến bạn, vui lòng kiểm tra mail và kích hoạt!');
    }

    public function verifyResetPassword(Request $request){

        $email = $request->user;
        if(!$email || $email ==""){
            return redirect()->route('frontend.account.login')->withErrors(['error' =>'Đường dẫn không hợp lệ!']);
        }
        $token = $request->token;
        if(!$token || $token ==""){
            return redirect()->route('frontend.account.login')->withErrors(['error' =>'Đường dẫn không hợp lệ!']);
        }

        $user = UserModel::where('email', $email)->where('tmp_token', $token)->first();

        if(!$user){
            return redirect()->route('home')->withErrors(['error' =>'Đường dẫn không tồn tại!']);
        }

        $today = Carbon::today()->format('d-m-Y');
        $check_token = sha1($user->tmp.$today);

        if($check_token == $token){

            $password = uniqid();

            $user->password = Hash::make($password);
            $user->tmp = null;
            $user->tmp_token = null;
            $user->update();

            $subject = 'Mật khẩu đăng nhập mới';
            $content = "Mật khẩu mới của bạn: ". $password;

            $mail = new \App\Modules\Sendmail\Controllers\SendmailController;
            $mail->sendmail($subject, $content, $email);

            return redirect()->route('frontend.account.login')->with('success','Mật khẩu mới đã được gửi đến Email của bạn!');

        }else{
            return redirect()->route('home')->withErrors(['error' =>'Đường dẫn khôi phục mật khẩu đã hết hạn!']);
        }

    }

    public function verifyphone(){

        if(!Auth::check()){
            return redirect()->route('login');
        }

        $user = UserModel::find(Auth::user()->id);
        if($user->verify_phone == 1){
            return redirect()->back()->withErrors(['error'=> 'Tài khoản này đã được xác thực số điện thoại trước đó']);
        }else{

            if(!$user->phone){
                return redirect()->back()->withErrors(['error' => 'Bạn cần cập nhật số điện thoại trước']);
            }

            if($user->tmp && $user->tmp_token){
                return redirect()->back()->withErrors(['error' => 'Yêu cầu đang bận']);
            }

            $phone = $user->phone;
            $secret = rand(100000, 999999);
            $tmp_token = sha1($phone . $secret . 'verifyphone' . $user->id);
            $user_id = $user->id;

            $user->tmp = $secret;
            $user->tmp_token = $tmp_token;
            $user->update();

            $current_sms = DB::table('settings')->where('key', 'smsprovider')->first();
            $content = 'Ma xac thuc la '.$secret;
            $sms = new \App\Modules\Sms\Controllers\SmsController;
            $sms->sendSms(null, $phone, $secret, $content, $current_sms->value, 'Otp', 'Verifyphone', $user->id, $user->id);

            return theme_view('account.user.verifyphone', compact('tmp_token', 'user_id'));
        }


    }

    public function postverifyphone(Request $request){

        if(!Auth::check()){
            return redirect()->route('login');
        }

        $this->validate($request, [
           'veriphone' => 'required'
        ]);

        if(!$request->tmp_token || !$request->user_id){
            return redirect()->route('user.profile')->withErrors(['error' => 'Xác thực thất bại']);
        }

        $user = UserModel::find(Auth::user()->id);

        if(!$user->tmp){
            return redirect()->route('user.profile')->withErrors(['error' => 'Xác thực thất bại do không tạo được yêu cầu lúc này']);
        }

        if($user->id !== intval($request->user_id)){
            return redirect()->route('user.profile')->withErrors(['error' => 'Thông tin người dùng bị thay đổi']);
        }

        if($user->tmp_token !== $request->tmp_token){
            return redirect()->route('user.profile')->withErrors(['error' => 'Thông tin token bị thay đổi']);
        }

        if($user->tmp == $request->veriphone){
            $user->verify_phone = 1;
            $user->tmp = null;
            $user->tmp_token = null;
            $user->update();
            return redirect()->route('user.profile')->with('success', 'Xác thực số điện thoại thành công');
        }else{

            $user->tmp = null;
            $user->tmp_token = null;
            $user->update();
            return redirect()->route('user.profile')->withErrors(['error' => 'Mã xác thực không đúng']);
        }

    }


    public function verifydocument(){

        if(!Auth::check()){
            return redirect()->route('login');
        }

        $user = UserModel::find(Auth::user()->id);
        if($user->verify_document == 1){
            return redirect()->back()->withErrors(['error'=> 'Tài khoản này đã được xác thực giấy tờ']);
        }else{

            return theme_view('account.user.verifydocument', compact('user'));
        }
    }

    public function postverifydocument(Request $request){

        if(!Auth::check()){
            return redirect()->route('login');
        }

        $user = UserModel::find(Auth::user()->id);
        if($user->verify_document == 1){
            return redirect()->back()->withErrors(['error'=> 'Tài khoản này đã được xác thực giấy tờ']);
        }else{
            $this->validate($request, [
                'image1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'image2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'image3' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
            ]);

            try{

                if($request->image1){
                    $image1 = $request->image1;
                    $image_name1 = '1'.uniqid().'_'.$image1->getClientOriginalName();
                    $image1->move(storage_path('app/public/verify'), $image_name1);

                    /// Lưu vào database
                    $userimage1 = new UserImage;
                    $userimage1->title = 'Mặt trước';
                    $userimage1->token = md5(uniqid().$image_name1);
                    $userimage1->user_id = Auth::user()->id;
                    $userimage1->image = '/storage/verify/'.$image_name1;
                    $userimage1->cat = 'verify';
                    $userimage1->type = 'private';
                    $userimage1->admin = 1;
                    $userimage1->save();
                }

                if($request->image2){
                    $image2 = $request->image2;
                    $image_name2 = '2'.uniqid().'_'.$image2->getClientOriginalName();
                    $image2->move(storage_path('app/public/verify'), $image_name2);

                    /// Lưu vào database
                    $userimage2 = new UserImage;
                    $userimage2->title = 'Mặt sau';
                    $userimage2->token = md5(uniqid().$image_name2);
                    $userimage2->user_id = Auth::user()->id;
                    $userimage2->image = '/storage/verify/'.$image_name2;
                    $userimage2->cat = 'verify';
                    $userimage2->type = 'private';
                    $userimage2->admin = 1;
                    $userimage2->save();
                }

                if($request->image3){
                    $image3 = $request->image3;
                    $image_name3 = '3'.uniqid().'_'.$image3->getClientOriginalName();
                    $image3->move(storage_path('app/public/verify'), $image_name3);

                    /// Lưu vào database
                    $userimage3 = new UserImage;
                    $userimage3->title = 'Chân dung';
                    $userimage3->token = md5(uniqid().$image_name3);
                    $userimage3->user_id = Auth::user()->id;
                    $userimage3->image = '/storage/verify/'.$image_name3;
                    $userimage3->cat = 'verify';
                    $userimage3->type = 'private';
                    $userimage3->admin = 1;
                    $userimage3->save();
                }

                $user = UserModel::find(Auth::user()->id);
                $user->verify_document = 2;
                $user->update();

                unset($userimage1);
                unset($userimage2);
                unset($userimage3);

                return redirect()->back()->with('success','Yêu cầu xác mình thành công, vui lòng đợi trong ít phút!');
            }catch (\Exception $e){
                return redirect()->back()->withErrors(['error'=> 'Có lỗi trong quá trình tải dữ liệu']);
            }


        }
    }

}