<?php

namespace App\Modules\Seo\Models;

use App\Modules\Setting\Models\Setting;
use Hamcrest\Core\Set;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasRoles;


    protected $table = 'seo';
    protected $fillable = [
       'link','title', 'description', 'h1', 'checksum', 'avatar', 'language', 'noindex'
    ];

    public static function getMeta($id=null){

        $seo = Seo::find($id);
        if($seo){
            return $seo;
        }else{
            $c_url = url()->current();
            $url = url('/');
            if($url != $c_url){
                $uri = str_replace($url, '', $c_url);
                $md5 = md5($uri);

                $seo2 = Seo::where('checksum', $md5)->first();
            }else{
                /// Trang chủ
                $seo2 = Seo::find(1);
            }
            if($seo2){
                return $seo2;

            }else{
                return false;
            }
        }

    }


    public static function createMeta($data){

        if(!isset($data['link']) || !isset($data['title']) || !isset($data['description'])) {
            return null;
        }else {

            $seo = new Seo;
            $seo->link = (isset($data['link'])) ? $data['link'] : '';
            $seo->checksum = md5($data['link']);
            $seo->title = $data['title'];
            $seo->description = $data['description'];
            $seo->avatar = (isset($data['avatar'])) ? $data['avatar'] : '';
            $seo->language = (isset($data['language'])) ? $data['language'] : '';
            $seo->h1 = (isset($data['h1'])) ? $data['h1'] : '';


            $result = $seo->save();
            if($result){
                return $seo->id;
            }else{
                return null;
            }
        }
    }


}