<?php

namespace App\Modules\Slug\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'slugs';
    protected $fillable = [
        'slug',
        'module',
        'model',
        'model_id'
    ];


    public static function checkSlug($slug){

        $exist_slug = Slug::where('slug', $slug)->first();
        if(!$exist_slug){
            return true;
        }else{
            return false;
        }

    }


    public static function makeSlug($title){

        /// Kiểm tra xem có .html ở cuối chuỗi ko ?
        $check_html = substr($title, -5);
        if($check_html === '.html'){
            $new_title = substr($title, 0, -5);

            $slugobj = new \App\Helpers\SlugHelper;
            $slug = $slugobj->slug($new_title);

            return $slug.'.html';

        }else{

            $slugobj = new \App\Helpers\SlugHelper;
            $slug = $slugobj->slug($title);
            return $slug;
        }



    }


}