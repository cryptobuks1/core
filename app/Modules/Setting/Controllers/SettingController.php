<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Group\Models\Group;
use App\Modules\Language\Models\Language;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use File;
use Cache;
use App\Modules\Setting\Models\Setting;

class SettingController extends BackendController
{
	public $general_arr =  ['favicon', 'logo', 'backendlogo', 'name','title', 'description','language',
        'phone', 'hotline','email','backendname','backendlang','copyright', 'timezone','websitestatus','address',
        'offline_mes','globalpopup', 'globalpopup_mes'];

    public $security_arr =  ['twofactor', 'smsprovider'];

    public $user_arr =  ['default_user_group', 'require_phone', 'approve_user', 'allow_register', 'require_username', 'allow_transfer'];

    public $design_arr =  ['fronttemplate', 'top_bg' ,'slide_bg','footer_bg', 'header_js', 'footer_js', 'home_tab_active', 'top_color', 'type_slider'];

    public $connection_arr =  ['social_login', 'google_analytic_id', 'facebook','googleplus','twitter', 'youtube'];

    public function general()
	{
		$title     = "Cấu hình chung";
		$timezone  = $this->arrayTimezone();

        $languages = Language::where('status', 1)->select('name','code')->orderBy('default')->get()->toArray();
		$groups = Group::get();

        //// Các loại hình xác thực.
		$twofactors = ['Mkc2', 'Odp', 'Otp', 'GoogleAuth', 'Email', 'Cardcode'];

		$path_sms = app_path('Modules//Sms//Providers');
        $smsproviders = array_map('basename', File::directories($path_sms) );

        $path_template = resource_path('views//frontend');
        $fronttemplates = array_map('basename', File::directories($path_template) );

		$setting = Setting::pluck('value', 'key')->toArray();

		return view('Setting::index', compact('title','setting', 'timezone', 'languages', 'groups', 'twofactors', 'smsproviders', 'fronttemplates'));
	}

	public function update_general(Request $request)
	{
		$input = $request->all();


		if($request->favicon){
            $favicon = explode('storage',$request->favicon);
            $input['favicon'] = '/storage'.$favicon[1];
        }

        if($request->logo){
            $logo = explode('storage',$request->logo);
            $input['logo'] = '/storage'.$logo[1];
        }
        if($request->backendlogo){
            $backendlogo = explode('storage',$request->backendlogo);
            $input['backendlogo'] = '/storage'.$backendlogo[1];
        }

		foreach($this->general_arr as $key)
		{

			if(isset($input[$key]))
			{
				$set = Setting::where('key',$key);
				if($set->count()){
					$set->update(['value'=>$input[$key], 'tab' => 'general']);
				}else{
					$set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'general']);
				}
			}else{
                $input[$key] = 'N/A';
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'general']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'general']);
                }
            }
		}

        Cache::forget('settings');

		return redirect(url(config('backend.backendRoute').'/settings/general'))->with('success','Setting general Updated')->withInput();
	}


    public function update_security(Request $request)
    {
        $input = $request->all();

        foreach($this->security_arr as $key)
        {
            if(isset($input[$key]))
            {
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'security']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'security']);
                }
            }else{
                $input[$key] = 'N/A';
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'security']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'security']);
                }
            }
        }

        Cache::forget('settings');

        return redirect(url(config('backend.backendRoute').'/settings/general'))->with('success','Setting general Updated')->withInput();
    }


    public function update_user(Request $request)
    {
        $input = $request->all();
        foreach($this->user_arr as $key)
        {
            if(isset($input[$key]))
            {
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'user']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'user']);
                }
            }else{
                $input[$key] = 'N/A';
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'user']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'user']);
                }
            }
        }

        Cache::forget('settings');

        return redirect(url(config('backend.backendRoute').'/settings/general'))->with('success','Setting general Updated')->withInput();
    }

    public function update_connection(Request $request)
    {
        $input = $request->all();
        foreach($this->connection_arr as $key)
        {
            if(isset($input[$key]))
            {
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'connection']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'connection']);
                }
            }else{
                $input[$key] = 'N/A';
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'connection']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'connection']);
                }
            }
        }

        Cache::forget('settings');

        return redirect(url(config('backend.backendRoute').'/settings/general'))->with('success','Setting general Updated')->withInput();
    }


    public function update_design(Request $request)
    {
        $input = $request->all();
        foreach($this->design_arr as $key)
        {
            if(isset($input[$key]))
            {
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'design']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'design']);
                }
            }else{
                $input[$key] = 'N/A';
                $set = Setting::where('key',$key);
                if($set->count()){
                    $set->update(['value'=>$input[$key], 'tab' => 'design']);
                }else{
                    $set->create(['key'=>$key,'value'=>$input[$key], 'tab' => 'design']);
                }
            }
        }

        Cache::forget('settings');

        return redirect(url(config('backend.backendRoute').'/settings/general'))->with('success','Setting general Updated')->withInput();
    }


    public function arrayTimezone()
	{
		$timezone = view('Setting::timezone')->render();
		return json_decode($timezone);
	}

	public function listLanguage()
	{
		$langpath = resource_path('lang');
		$langlist =   glob($langpath . '/*' , GLOB_ONLYDIR);
		$lang = array();
		foreach ($langlist as $value) {
			$temp = str_replace($langpath.'/', '', $value);
			$lang[$temp] = $temp;
		}
		return $lang;
	}

}