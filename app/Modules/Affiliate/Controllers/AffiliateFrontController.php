<?php

namespace App\Modules\Affiliate\Controllers;

use App\Modules\User\Models\User as UserModel;
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
use Cookie;
use GeoIp2\Database\Reader;
use Illuminate\Routing\Route;
use App\User;
use Carbon\Carbon;

class AffiliateFrontController extends FrontendController
{

    public $client_ip;

    public function __construct()
    {
        parent::__construct();

    }

    public function index(){
        $user = UserModel::find(Auth::user()->id);
        $max_level = config('site.max_level');
        if($user){
                if($user->ref){
                    $ref = $user->ref;
                }else{
                    $ref = uniqid();
                    $user->ref = $ref;
                    $user->update();
                }
                return theme_view('account.affiliate', compact('ref', 'user'));

        }
    }

    ///List user affiliate
    public function affusers(){

        $id = Auth::user()->id;
        $users = UserModel::withDepth()->descendantsOf($id);

        return theme_view('account.affiliate_user', compact('users'));
    }

    /// Lưu ref vào cookie trên máy client
    public static function createRef($ref){
        if($ref){
            Cookie::queue('ref', $ref, 525600);
        }
    }

    public function test(Request $request){

    }

}
