<?php

namespace App\Modules\Frontend\Controllers;

use App\Modules\Api\Models\Api;
use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\Wallet\Controllers\WalletController;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use League\Flysystem\Exception;


class SocialiteController extends FrontendController
{


    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirectToprovider($provider)
    {
        if(!Auth::check()){
            return Socialite::driver($provider)->redirect();
        }else{

            return redirect()->route('home')->withErrors(['error' => 'Bạn vẫn đang đăng nhập!']);
        }

    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callbackFromprovider($provider)
    {

        $user = Socialite::driver($provider)->stateless()->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        if($authUser){

            $check = DB::table('model_has_roles')->where('model_id', $authUser->id)->pluck('role_id')->toArray();

            if(in_array(2,$check) || in_array(3,$check)){

                return redirect()->route('home')->withErrors(['error' => 'Thất bại.']);

            }else{
                
                Auth::login($authUser, true);
                return redirect()->route('home');
            }

        }else{
            return redirect()->route('home')->withErrors(['error' => 'Lỗi đăng nhập bằng Facebook Email.']);
        }


    }


    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }else{


            $group_setting = \App\Modules\Setting\Models\Setting::where('key', 'default_user_group')->first();
            $group_id = null;
            if($group_setting->count()) {
                $group_id = $group_setting->value;
            }

            $email_user = User::where('email', $user->email)->first();
            if(!$email_user){

                $userdata = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' =>'fb_'.$user->id,
                    'phone' => null,
                    'password' => Hash::make(md5($user->email.time())),
                    'group'=>$group_id,
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'status' => 1
                ];


                DB::beginTransaction();
                try {
                    $new_user = User::create($userdata);
                    /// Tạo role USER
                    DB::table('model_has_roles')->insert(
                        ['role_id' => 5, 'model_type' => 'App\User', 'model_id'=>$new_user->id]
                    );

                    /// Tạo ví
                    WalletController::makeWalletFromUserId($new_user->id);

                    DB::commit();

                    return $new_user;
                }catch (\Exception $e){

                    DB::rollback();
                    return false;
                }

            }else{
                return false;
            }


        }

    }


    //{"token":"EAAEsqd7nD4MBAIpgv9mWHEcXiglqYVDEZBySDl7xyX6drUZAv3YqzNRbj5tG8mKfDDZCEFSjqTnv2ZBhLNtjwv3cMmE6FxdFjIZApDLVbUfrWN0bo5kZBcsI8fCijpdfE78pQhD8sEzfzCbdry6hSMR6tHUy7N3ZAUEUiVOgtyA2G1cYCCGtZCKX",
//"refreshToken":null,
//"expiresIn":5183999,
//"id":"2752571748102156",
//"nickname":null,
//"name":"Neo Nguyen",
//"email":"hotronet@gmail.com",
//"avatar":"https:\/\/graph.facebook.com\/v3.0\/2752571748102156\/picture?type=normal",
//"user":{"
//name":"Neo Nguyen",
//"email":"hotronet@gmail.com",
//"id":"2752571748102156"},
//"avatar_original":"https:\/\/graph.facebook.com\/v3.0\/2752571748102156\/picture?width=1920",
//"profileUrl":null}
}


