<?php
namespace App\Modules\Localbank\Controllers;

use App\Modules\Order\Models\Order;
use App\Modules\Setting\Models\Setting;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\Localbank\Models\LocalbankUser;
use DB;
use Auth;

class LocalbankFrontController extends FrontendController
{

    public function localbank() {

        if(!Auth::check()){
            return redirect()->route('login');
        }

        $listbanks = DB::table('localbanks_user')
            ->leftJoin('localbanks', 'localbanks_user.code', '=', 'localbanks.code')
            ->select('localbanks.name', 'localbanks_user.*')
            ->where('localbanks_user.user_id', Auth::user()->id)
            ->orderBy('id', 'decs')
            ->paginate(10);

        $listbanknames = DB::table('localbanks')->select('code','name')->get();
        return theme_view('account.localbank', compact('listbanks', 'listbanknames'));
    }



    public function postlocalbank(Request $request){
        $this->validate($request, [
            'code' => 'required',
            'acc_name' => 'required',
            'acc_num' => 'required'
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['approved'] = 0;
        $input['paygate_code'] = 'Localbank_'.$request->code;

        $kq = LocalbankUser::create($input);
        $id = $kq->id;
        $hash = sha1($id.$kq->acc_num.$kq->user_id.$kq->approved);

        $setting = Setting::where('key', 'twofactor')->first();

        if($setting->value == 'none'){
         return redirect()->route('user.localbank')
              ->with('success','Thêm ngân hàng thành công, chúng tôi sẽ phê duyệt sau ít phút. Xin cảm ơn!');
        }else{
            return redirect()->route('user.localbank.verify', compact('id','hash'));
        }

    }

    public function localbankverify(Request $request){

        if(!Auth::check()){
            return redirect()->route('login');
        }

        $hash = $request->hash;
        $id = $request->id;

        $bank = LocalbankUser::find($id);
        if(!$bank){
        return redirect()->route('home')->withErrors(['error' => 'Xác thực thất bại do không tồn tại thông tin ngân hàng trên']);
        }

        if($bank->approved !==0){
            return redirect()->route('home')->withErrors(['error' => 'Tài khoản ngân hàng không cần xác thực nữa.']);
        }

        $checkhash = sha1($bank->id.$bank->acc_num.$bank->user_id.$bank->approved);

        if($checkhash !== $hash){
            return redirect()->back()->withErrors(['error' => 'Xác thực thất bại do người dùng thay đổi thông tin!']);
        }

        $setting = Setting::where('key', 'twofactor')->first();
        $twofactor = null;
        if($setting->value !== 'none'){

            $twofactor = \App\Modules\Twofactor\Controllers\TwofactorController::challenge('LocalbankUser', $id);

        }

        return theme_view('account.localbankverify', compact('bank', 'twofactor' ,'hash'));

    }


    public function postlocalbankverify(Request $request){

        $setting = Setting::where('key', 'twofactor')->first();

        if ($setting->value !== 'none') {

            $this->validate($request, [
                'check2fa' => 'required',
                'id' => 'required',
                'hash' => 'required',
            ]);

            //// Kiểm tra 2fa
            $valid = \App\Modules\Twofactor\Controllers\TwofactorController::validate_challenge($request->check2fa, 'LocalbankUser', $request->id);

            if ($valid === false) {
                return redirect()->back()->withErrors(['error' => 'Mã xác thực không đúng!']);
            }
        }

        $bank = LocalbankUser::where('id', $request->id)->where('approved', 0)->first();

        if(!$bank){
            return redirect()->route('home')->withErrors(['error' => 'Xác thực thất bại do không tồn tại thông tin ngân hàng trên']);
        }

        $checkhash = sha1($bank->id.$bank->acc_num.$bank->user_id.$bank->approved);

        if($checkhash !== $request->hash){
            return redirect()->back()->withErrors(['error' => 'Xác thực thất bại do người dùng thay đổi thông tin!']);
        }

        $bank->approved = 1;
        $bank->update();

        return redirect()->route('user.localbank')->with('success', 'Xác thực thêm ngân hàng thành công, xin cảm ơn!');

    }


    public function delmybank($id){


        $localbankuser = LocalbankUser::find($id);

        if($localbankuser){
            $localbankuser->delete();
            return redirect()->route('user.localbank')->with('success', 'Xóa ngân hàng thành công');
        }else {

            return redirect()->route('user.localbank')->withErrors(['error' => 'Lỗi: Không thể xóa ngân hàng']);
        }


    }


}