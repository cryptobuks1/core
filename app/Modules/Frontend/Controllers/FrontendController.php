<?php

namespace App\Modules\Frontend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Lang;
use Validator;
use App;
use DB;
use View;
use Cart;
use Cache;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Modules\Menu\Controllers\MenuController;
use App\Modules\Setting\Models\Setting;
use Carbon\Carbon;
class FrontendController extends Controller
{

    public $route;
    public function __construct()
    {

        $settings = Cache::remember('settings', 120, function() {
            return Setting::all()->pluck('value', 'key');
        });

        if(!count($settings) > 0){
            print_r('Empty setting!');
            die();
        }

        View::share('settings', $settings);

        if ($settings['websitestatus'] == 'OFFLINE') {

            $as = config('backend.backendRoute');
            $route = request()->segments();

            if (!count($route) > 0 || $route[0] !== $as) {
                print_r($settings['offline_mes']);
                die();
            }

        }
        /// Thiết lập ngôn ngữ website
        if(cache()->get('language')){
            $current_lang = cache()->get('language');
        }else{
            $current_lang = $settings['language'];
            Cache::forever('language', $current_lang);
        }
        App::setLocale($current_lang);

        $list_lang = $this->listLanguage();
        View::share('languages', $list_lang);

        ///Cache ngôn ngữ
        if(!Cache::has('langcache_'.App::getLocale())){
            $lang = App\Modules\Language\Models\Translation::where('lang_code', App::getLocale())->pluck('content','lang_key');
            Cache::forever('langcache_'.App::getLocale(), $lang);
        }

        /// Thiết lập currency
        if (!session()->has('currency')) {
            $currency_default = App\Modules\Currency\Models\Currencies::where(['default' => 1, 'status' => 1, 'fiat' => 1])->first();
            if (!$currency_default) {
                exit('Vui lòng liên hệ để cập nhật một loại tiền tệ');

            }
            session()->put('currency', $currency_default);
        }

        $currencies = App\Modules\Currency\Models\Currencies::where(['status' => 1, 'fiat' => 1])->orderBy('default', 'DESC')->get();
        View::share('currencies', $currencies);

        //// Tạo biến menu gửi ra view
        $menulist = new MenuController;
        ///// header lấy trong file config/menu.php
        $menu = $menulist->getMenuListBytype('header');
        View::share('menu', $menu);

        $footer_menu = $menulist->getMenuListBytype('footer');
        View::share('footer_menu', $footer_menu);

        $list_news = App\Modules\News\Controllers\NewsFrontController::getListNews(App::getLocale(), 5);
        View::share('list_news', $list_news);

        $news = App\Modules\News\Models\News::where(['status' => 1])->orderBy('updated_at', 'ASC')->select('title', 'news_slug')->limit(3)->get()->toArray();
        View::share('news', $news);

        View::share('current_theme', (env('THEME'))? env('THEME') : 'default');
    }


    public function index()
    {
        $seo_advanced = render_seo('seo_advanced');
        $sliderlist = new App\Modules\Sliders\Controllers\SlidersFrontController();
        $sliders = $sliderlist->renderSlider();
        View::share(['sliders' => $sliders]);

        return theme_view('pages.home', compact('seo_advanced'));
    }

    public function password_reset()
    {
        return theme_view('auth.password_reset');
    }

    public function postSetSiteCurrency(Request $request)
    {
        $id = intval($request->id);
        if ($id) {
            $currency = App\Modules\Currency\Models\Currencies::where(['id' => $id, 'status' => 1, 'fiat' => 1])->first();
            if ($currency) {
                session()->put('currency', $currency);
                Cart::destroy();
                return back()->with('success', 'Tiền tệ đã được chuyển qua: ' . $currency->code);
            }
        }
        return back()->withErrors(['error' => 'Loại tiền tệ không đúng.']);
    }

    public function postSetSiteLang(Request $request)
    {
        $code = strip_tags($request->code);
        if ($code) {
            $lang = App\Modules\Language\Models\Language::where(['code' => $code, 'status' => 1])->first();
            if ($lang) {
                cache()->forever('language' , $code);
                return back()->with('success', 'Ngôn ngữ được chuyển qua: '.$lang->name);
            }
        }
        return back()->withErrors(['error' => 'Ngôn ngữ không tồn tại']);
    }


    public function resetPasswordSms(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home')->withErrors(['error' => 'Bạn vẫn đang đăng nhập!']);
        }

        $this->validate($request, [
            'phone' => 'required|regex:/(0)[0-9]{9}/',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        $input = $request->all();

        if(strlen($input['phone']) > 10){
            return redirect()->back()->withErrors(['error' => 'Số điện thoại không chính xác']);
        }

        $user = App\User::where('phone', strip_tags($input['phone']))->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Số điện thoại không tồn tại trong hệ thống']);
        }

        try{
            $secret = rand(100000, 999999);
            $user->tmp = $secret;
            $user->tmp_token = sha1($input['phone'] . $secret . 'NC' . $user->id);
            $user->update();

            //// Gửi SMS
            $current_sms = DB::table('settings')->where('key', 'smsprovider')->first();
            $content = 'Ma xac thuc tai khoan cua ban la '.$secret;
            $sms = new \App\Modules\Sms\Controllers\SmsController;
            $sms->sendSms(null, $input['phone'], $secret, $content, $current_sms->value, 'Otp', 'User', $user->id, $user->id);

            $tmp_token = sha1($input['phone'] . $secret . 'NC' . $user->id);
            $phone = $input['phone'];
            return theme_view('account.passwords.smsconfirm', compact('phone', 'tmp_token'));

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => 'Lỗi xử lý']);
        }

    }


    public function resetPasswordSmsPost(Request $request)
    {

        $this->validate($request, [

            'verify' => 'required|numeric',
            'password' => 'required|string|min:6',
        ]);

        $tmp = trim($request->verify);
        $password = $request->password;
        $phone = $request->phone;
        $tmp_token = $request->tmp_token;

        $user = App\User::where(['phone' => $phone, 'tmp_token' => $tmp_token, 'tmp' => $tmp])->first();

        if (!$user) {

            return redirect()->route('home')->withErrors(['error' => 'Token bảo vệ không đúng. Vui lòng thử lại sau!']);
        } else {

            $check = DB::table('model_has_roles')->where('model_id', $user->id)->pluck('role_id')->toArray();

            if (in_array(2, $check) || in_array(3, $check)) {

                $user->tmp = null;
                $user->tmp_token = null;
                $user->update();
                return redirect()->route('home')->withErrors(['error' => 'Thất bại!']);

            } else {

                if ($tmp === $user->tmp) {

                    $user->password = Hash::make($password);
                    $user->tmp = null;
                    $user->tmp_token = null;
                    $user->update();

                    return redirect()->route('home')->with('success', 'Cập nhật mật khẩu thành công! Bạn có thể đăng nhập hệ thống bằng số điện thoại: ' . $phone);

                } else {

                    return redirect()->route('home')->withErrors(['error' => 'Sai mã xác thực. Vui lòng thử lại sau!']);
                }
            }

        }


    }


    public function userlogin(Request $request)
    {
        if (Auth::check() && auth()->user()->hasRole('SUPER_ADMIN|BACKEND')) {

            echo 'Bạn hãy copy link này vào trình duyệt ẩn để đăng nhập (Ctrl + Shift + N)<br>';
            $url = url('/userlogin') . '/' . $request->id . '/' . $request->token;
            echo $url;

        } else {

            $key = env('APP_KEY');

            $user = User::find($request->id);
            $ip = getIpClient();
            if (!$user || $user->hasRole('SUPER_ADMIN|BACKEND')) {
                return redirect()->route('home');
            }
            $mytoken = sha1($user->id . $user->email . $user->phone . $user->password . $user->mkc2 . $key . $ip);

            if ($request->token == $mytoken) {

                Auth::loginUsingId($request->id);


                if (Auth::user()->id != intval($request->id)) {

                    Auth::logout();
                }

                return redirect()->route('home')->with('Đăng nhập thành công');
            }
        }

    }

    public function listLanguage()
    {
        $lang = App\Modules\Language\Models\Language::where('status', 1)->pluck('name', 'code');
        return $lang;
    }


}
