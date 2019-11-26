<?php

namespace App\Modules\Affiliate\Controllers;

use App\Modules\Affiliate\Models\Affiliate;
use App\Modules\Affiliate\Models\AffiliateConfig;
use App\Modules\Order\Models\Order;
use App\Modules\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use File;

class AffiliateController extends BackendController
{

    public function index(Request $request){

        $title = "Quản lý huê hồng";
        $affiliates = Affiliate::orderBy('id', 'DESC')->paginate(40);
        $type = $request->type;
        $keyword = $request->keyword;

        if ($type == 'affiliate_code' && $keyword) {
            $affiliates = Affiliate::where('affiliate_code', $keyword)->orderBy('id', 'DESC')->paginate(25);

        }
        if ($type == 'module' && $keyword) {
            $affiliates = Affiliate::where('module', $keyword)->orderBy('id', 'DESC')->paginate(25);
        }

        if ($type == 'user_id' && $keyword) {
            $affiliates = Affiliate::where('user_id', $keyword)->orderBy('id', 'DESC')->paginate(25);
        }

        if ($type == 'order_code' && $keyword) {
            $affiliates = Affiliate::where('order_code', $keyword)->orderBy('id', 'DESC')->paginate(25);
        }
        return view("Affiliate::index", compact('title', 'affiliates'));
    }

    public function setting(){

        $title = 'Cấu hình Affiliate';
        $path = app_path('Modules//Affiliate//Plugins');
        $listPlugin = array_map('basename', File::directories($path));
        $setting = AffiliateConfig::whereNotIn('key', $listPlugin)->pluck('value', 'key')->toArray();

        ///Các loại được hưởng huê hồng
        $types = ['new_purchase', 'webmaster', 'renewal'];
        $plugs = array();
        foreach ($listPlugin as $plugin){
            $conf = AffiliateConfig::where('key', $plugin)->first();
            $affvalue = json_decode($conf->value);

            foreach ($affvalue as $type => $val){
                $plugs[$plugin][$type] = $val;
            }
        }

        return view("Affiliate::setting", compact('title', 'setting', 'plugs', 'types'));
    }

    public function postsetting(Request $request){
        $path = app_path('Modules//Affiliate//Plugins');
        $listPlugin = array_map('basename', File::directories($path));

        $input = $request->all();
        foreach ($listPlugin as $plugin){
            $input[$plugin] = json_encode($request->$plugin);
        }
        unset($input['_token']);

        foreach ($input as $key => $value){

            ///Xóa cũ
            AffiliateConfig::where('key', $key)->delete();

            $conf = new AffiliateConfig;
            $conf->key = $key;
            $conf->value = $value;
            $conf->save();
        }

        return redirect()->back()->with('success', 'Cập nhật cấu hình thành công');
    }

}