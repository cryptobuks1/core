<?php

namespace App\Modules;
use File;
use Config;
use Blade;

class ServiceProvider extends  \Illuminate\Support\ServiceProvider{

    public function boot(){

        $listModule = array_map('basename', File::directories(__DIR__));
        foreach ($listModule as $module) {
            if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                include __DIR__.'/'.$module.'/routes.php';
            }
            if(file_exists(__DIR__.'/'.$module.'/breadcrumbs.php')) {
                include __DIR__.'/'.$module.'/breadcrumbs.php';
            }

            if(is_dir(__DIR__.'/'.$module.'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
            }
        }

        if(file_exists(__DIR__.'/Helpers.php')) {
            include __DIR__.'/Helpers.php';
        }

        Blade::directive('theme_include', function ($string_params){
            $html = '{!! theme_include('.$string_params.') !!}';
            return $html;
        });

        $theme = (env('THEME'))? env('THEME') : 'default';
        $breadcrumbs_template = 'frontend.'.$theme.'.widgets.breadcrumbs';

        Config::set([
            'breadcrumbs.view' => $breadcrumbs_template
        ]);

        Blade::directive('getlang', function ($expression) {

            return getlang($expression);
        });

//        $whoops = new \Whoops\Run;
//        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
//        $whoops->register();
    }

    public function register(){

    }
}