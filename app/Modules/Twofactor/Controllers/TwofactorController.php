<?php

namespace App\Modules\Twofactor\Controllers;

use App\Modules\Sendmail\Controllers\SendmailController;
use App\Modules\Sms\Models\Sms;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use DB;
use App\Modules\Twofactor\Models\Twofactor;

class TwofactorController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'Two Factor';
        View::share ('title', $title );
    }

	public function index(Request $request)
	{
        $title    = "Quản lý xác thực";
        $verify = Twofactor::orderBy('id','DESC')->paginate(40);

		return view("Twofactor::index", compact('title', 'verify'));
	}


    public function delete2fa(Request $request)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') && $request->input('_method')== 'delete' )
        {
            Twofactor::find($request->input('id'))->delete();
            return redirect()->route('twofactor.index')
                ->with('success','Bạn đã xóa thành công!');
        }else{
            return redirect()->route('twofactor.index')
                ->withErrors(['message' =>'Not access.']);
        }
    }

    public static function challenge($modulename = null, $model_id = null){
        $current_2fa = DB::table('settings')->where('key', 'twofactor')->first();

        //// Dành cho các trường hợp thành viên chưa Login vẫn có thể nhận sms ( thay đổi mật khẩu, admin login....)
        if($modulename && $modulename == '2factor_nologin'){
            $u_id = session()->get('temp_userid');
        }else{

            $u_id = Auth::user()->id;
        }

        $user = User::find($u_id);

        $date = Carbon::now();
        $today = $date->format('d-m-Y');

        switch ($current_2fa->value){

            case 'Mkc2':

                $mkc2 = $user->mkc2;

                if(!$mkc2){


                    if($modulename && $modulename == '2factor_nologin'){

                        return 'Bạn chưa có mật khẩu cấp 2';

                    }else{

                        return redirect()->route('edit.profile')->withErrors(['error' => 'Bạn cần phải cập nhật mật khẩu cấp 2 trước khi giao dịch!']);

                    }


                }else{

                    static::sendchallenge($modulename, $model_id);
                    $render2fa = theme_view('widgets.twofactor.Mkc2', compact('twofa'))->render();
                }


                break;
            case 'Odp':


                $phone = $user->phone;
                if(!$phone){

                    if($modulename && $modulename == '2factor_nologin'){

                        return 'Bạn chưa có số điện thoại';

                    }else{

                        return redirect()->route('edit.profile')->withErrors(['error' => 'Bạn cần phải cập nhật số điện thoại trước khi giao dịch!']);
                    }


                }else{

                    static::sendchallenge($modulename, $model_id);
                    $render2fa = theme_view('widgets.twofactor.Odp', compact('twofa', 'today'))->render();

                }

                break;
            case 'Otp':

                $phone = $user->phone;
                if(!$phone){

                    if($modulename && $modulename == '2factor_nologin'){

                        return 'Bạn chưa có số điện thoại';

                    }else{

                        return redirect()->route('edit.profile')->withErrors(['error' => 'Bạn cần phải cập nhật số điện thoại trước khi giao dịch!']);
                    }

                }else{

                    static::sendchallenge($modulename, $model_id);
                    $render2fa = theme_view('widgets.twofactor.Otp', compact('twofa'))->render();

                }
                break;
            case 'GoogleAuth':
                $render2fa = theme_view('widgets.twofactor.GoogleAuth', compact('twofa'))->render();
                break;
            case 'Email':

                $email = $user->email;
                if(!$email){

                    if($modulename && $modulename == '2factor_nologin'){

                        return 'Bạn chưa có email';

                    }else{

                        return redirect()->route('edit.profile')->withErrors(['error' => 'Bạn cần phải cập nhật email trước khi giao dịch!']);
                    }


                }else{

                    static::sendchallenge($modulename, $model_id);
                    $render2fa = theme_view('widgets.twofactor.Email', compact('twofa'))->render();

                }


                break;
            case 'Cardcode':
                $render2fa = theme_view('widgets.twofactor.Cardcode', compact('twofa'))->render();
                break;

            case 'none':
                $render2fa = null;
                break;
            default:
                $render2fa = null;
        }


        return $render2fa;
    }

    public static function sendchallenge($modulename, $model_id){


        $current_2fa = DB::table('settings')->where('key', 'twofactor')->first();
        $current_sms = DB::table('settings')->where('key', 'smsprovider')->first();

        if($current_2fa->value == 'Odp'){

            if($modulename && $modulename == '2factor_nologin'){
                $u_id = session()->get('temp_userid');
            }else{

                $u_id = Auth::user()->id;
            }

            $user = User::find($u_id);

            $phone = $user->phone;
            if($phone){

                $exist_odp = Sms::where('user_id', $u_id)->where('expired_at', Carbon::tomorrow())->get();

                if(count($exist_odp) == 0 ){

                    /// Gửi sms
                    $date = Carbon::now();
                    $secret = rand(100000,999999);
                    //$content = $secret.' - La ma xac thuc ODP ngay '. $date->format('d-m-Y');
                    $content = 'Ma xac thuc tai khoan cua ban la '. $secret;
                    $sms = new \App\Modules\Sms\Controllers\SmsController;
                    $sms->sendSms(null, $phone, $secret, $content, $current_sms->value, 'Odp', $modulename, $model_id, $u_id);

                }

            }

        }



        if($current_2fa->value == 'Otp'){

            if($modulename && $modulename == '2factor_nologin'){
                $u_id = session()->get('temp_userid');
            }else{

                $u_id = Auth::user()->id;
            }

            $user = User::find($u_id);

            $phone = $user->phone;
            if($phone){

                $exist_otp = Sms::where('user_id', $u_id)->where('model_id', $model_id)->where('modulename', $modulename)->where('verified', 0)->get();
               // dd($exist_otp);

                /// chỉ cho gửi tối đa 1 lần / 1 giao dịch
                if(count($exist_otp) == 0 ){

                    /// Gửi sms
                    $secret = rand(100000,999999);
                    $content = 'Ma OTP cua ban la: '.$secret;
                    $sms = new \App\Modules\Sms\Controllers\SmsController;
                    $sms->sendSms(null, $phone, $secret, $content, $current_sms->value, 'Otp', $modulename, $model_id, $u_id);

                }

            }
        }


        if($current_2fa->value == 'Email'){


            if($modulename && $modulename == '2factor_nologin'){
                $u_id = session()->get('temp_userid');
            }else{

                $u_id = Auth::user()->id;
            }

            $user = User::find($u_id);

            $email = $user->email;
            if($email){


                $exist_odp = Twofactor::where('user_id', $u_id)->where('expired_at', Carbon::tomorrow())->get();

                if(count($exist_odp) == 0 ){

                    /// Thực hiện gửi mail
                    $mail = new SendmailController;
                    $secret = rand(100000,999999);
                    $date = Carbon::now();
                    $subject = 'Xác thực giao dịch';
                    $content = $content = $secret.' - Là mã xác thực ODP ngày '. $date->format('d-m-Y');

                    /// Lưu log
                    $twofa = new Twofactor;
                    $twofa->object = $email;
                    $twofa->driver = 'Email';
                    $twofa->user_id = $u_id;
                    $twofa->secret = $secret;
                    $twofa->text = $content;
                    $twofa->modulename = $modulename;
                    $twofa->model_id = $model_id;
                    $twofa->expired_at = Carbon::tomorrow();
                    $twofa->save();
                    $mail->sendmail($subject, $content, $email);
                }


            }
        }


    }



    public static function validate_challenge($secret, $modulename, $model_id){
        $current_2fa = DB::table('settings')->where('key', 'twofactor')->first();

        if($modulename && $modulename == '2factor_nologin'){
            $u_id = session()->get('temp_userid');
        }else{

            $u_id = Auth::user()->id;
        }

        $user = User::find($u_id);


        switch ($current_2fa->value){

            case 'none' :
                return true;
                break;

            case 'Mkc2':


                if($user->mkc2 == sha1($secret)){
                    return true;
                }else {
                    return false;
                }

                break;
            case 'Odp':

                $odp = Sms::where('user_id', $u_id)->where('expired_at', Carbon::tomorrow())->where('secret', $secret)->first();

                if($odp && isset($odp->id)){
                    $odp->verified = 1;
                    $odp->update();

                    ///Update luôn trạng thái xác thực cho sđt
                    if(!$user->verify_phone){
                        $user->verify_phone = 1;
                        $user->update();
                    }

                    return true;
                }else{
                    return false;
                }

                break;
            case 'Otp':

                $otp = Sms::where('user_id', $u_id)->where('model_id', $model_id)->where('modulename', $modulename)->where('secret', $secret)->where('verified', 0)->first();

                if($otp && isset($otp->id)){

                    $otp->verified = 1;
                    $otp->update();

                    ///Update luôn trạng thái xác thực cho sđt
                    if(!$user->verify_phone){
                        $user->verify_phone = 1;
                        $user->update();
                    }

                    return true;
                }else{
                    return false;
                }

                break;
            case 'GoogleAuth':
                return false;
                break;
            case 'Email':
                $odp = Twofactor::where('user_id', $u_id)->where('expired_at', Carbon::tomorrow())->where('secret', $secret)->first();

                if($odp && isset($odp->id)){

                    ///Update luôn trạng thái xác thực cho sđt
                    if(!$user->verify_email){
                        $user->verify_email = 1;
                        $user->update();
                    }
                    return true;
                }else{
                    return false;
                }

                break;
            case 'Cardcode':
                return false;
                break;
            default:
                return false;
        }


    }


}