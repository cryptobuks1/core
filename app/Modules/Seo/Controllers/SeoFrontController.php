<?php

namespace App\Modules\Seo\Controllers;

use App\Modules\Seo\Models\Seo;
use App\Modules\Setting\Models\Setting;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use App\User;


class SeoFrontController extends FrontendController
{

    public static function getseoMeta($blade){

        $seo = Seo::getMeta();

        if(!$seo){

            $allSetting = Setting::all();
            foreach ($allSetting as $setting) {
                $settings[$setting->key] = $setting->value;
            }

            $seo = new Seo;
            $seo->title = $settings['title'];
            $seo->description = $settings['description'];
            $seo->avatar = $settings['logo'];
            $seo->language = $settings['language'];
            $seo->h1 = isset($settings['h1']) ? $settings['h1'] : '';
            $seo->noindex = 1;
            $seo->link = url()->current();

        }

        return theme_view('widgets.'.$blade, compact('seo'))->render();

    }

}
