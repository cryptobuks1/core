<?php

namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\Api;
use App\Modules\Language\Models\Language;
use App\Modules\Menu\Controllers\MenuController;
use App\Modules\News\Models\News;
use App\Modules\Setting\Models\Setting;
use App\Modules\Sliders\Models\Sliders;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use Illuminate\Support\Facades\Mail;
use Log;
use File;
use Lang;
use Hash;
use Cache;
use GeoIp2\Database\Reader;
use Illuminate\Routing\Route;

class AppSiteController extends FrontendController
{

    public $client_ip;
    public $app_key;

    public function __construct()
    {
        parent::__construct();
        $this->app_key = config('app.MOB_KEY');
    }

    public function getdefault(Request $request){
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        $online = Setting::where('key', 'websitestatus')->first();
        if($online->value == 'OFFLINE'){
            return $this->set_output(633);
        }

        $default = array();
        $settings = Setting::where('tab', 'general')->pluck('value', 'key')->toArray();

        $langs = Language::get()->toArray();
        $currency = \App\Modules\Currency\Models\Currencies::where('status',1)->get()->toArray();;


        $default['url'] = url('/');
        $default['settings'] = $settings;
        $default['langs'] = $langs;
        $default['currency'] = $currency;

        return json_encode($default);

    }


    public function getmenu(Request $request){
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        $online = Setting::where('key', 'websitestatus')->first();
        if($online->value == 'OFFLINE'){
            return $this->set_output(633);
        }

        $menu = array();
        $menulist = new MenuController;
        $header_menu = $menulist->getMenuListBytype('header');
        $footer_menu = $menulist->getMenuListBytype('footer');

        $menu['header'] = $header_menu;
        $menu['footer'] = $footer_menu;

        return json_encode($menu);
    }


    public function getsliders(Request $request){
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        $online = Setting::where('key', 'websitestatus')->first();
        if($online->value == 'OFFLINE'){
            return $this->set_output(633);
        }

        $sliders = Sliders::where('status', 1)->get();
        return response()->json($sliders);
    }

    public function getblocknews(Request $request){
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        $online = Setting::where('key', 'websitestatus')->first();
        if($online->value == 'OFFLINE'){
            return $this->set_output(633);
        }

        $blocknews = News::where('status', 1)->orderBy('id', 'desc')->limit(5)->get();
        return response()->json($blocknews);
    }


    public function getlistnews(Request $request){
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        $online = Setting::where('key', 'websitestatus')->first();
        if($online->value == 'OFFLINE'){
            return $this->set_output(633);
        }

        $per_page = (isset($request->per_page) && $request->per_page > 0) ? $request->per_page : 10;
        $page = (isset($request->page) && $request->page > 1) ? $request->page : 1;
        $listnews = News::where('status', 1)->orderBy('id', 'desc')->paginate($per_page, ['*'], 'page', $page);
        return response()->json($listnews);
    }


}
