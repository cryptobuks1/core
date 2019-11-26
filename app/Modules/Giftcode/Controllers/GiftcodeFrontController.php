<?php

namespace App\Modules\Giftcode\Controllers;

use App\Modules\Giftcode\Helpers\GcHelper;
use App\Modules\Giftcode\Models\Giftcode;
use App\Modules\Giftcode\Models\GiftcodeLog;
use App\Modules\Order\Models\Order;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use Illuminate\Routing\Route;
use App\User;
use Carbon\Carbon;


class GiftcodeFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index(){

        $gcform = static::rendergiftcode();
        return theme_view('pages.giftcode', compact('gcform'));
    }

    public static function rendergiftcode(){

        return theme_view('widgets.giftcode-render', compact('gcform'))->render();
    }

    public function redeem(Request $request){
        $this->validate($request,[
           'giftcode' => 'required'
        ]);

        if(!Auth::check()){
            return redirect()->route('frontend.account.login')->withErrors(['error' => 'Bạn cần đăng nhập']);
        }

        if(Auth::user()->id == 1){
            return redirect()->back()->withErrors(['error' => 'Tài khoản này không thể nạp mã quà tặng']);
        }

        $giftcode = Giftcode::where('code', trim($request->giftcode))->where('status', 1)->first();
        if($giftcode){

            $gclog = GiftcodeLog::where('code', $giftcode->code)->get();
            if(count($gclog) >= $giftcode->used_time){
                return redirect()->back()->withErrors(['error' => 'Thẻ đã được nạp quá số lần cho phép']);
            }

            $classPath = '\App\Modules\Giftcode\Vendors\\' . $giftcode->model . '\\' . $giftcode->model;
            $Provider = new $classPath;
            $action = $giftcode->type;
            $result = $Provider->$action($giftcode, Auth::user()->id);

            if($result && $result['status'] === 'success'){
                return redirect()->back()->with('success', $result['message']);
            }else{
                return redirect()->back()->withErrors(['error' => 'Nạp thẻ không thành công. Hãy đợi 1 phút sau rồi thử lại.']);
            }
        }else{
            return redirect()->back()->withErrors(['error' => 'Thẻ không tồn tại hoặc đã được sử dụng']);
        }

    }
}
