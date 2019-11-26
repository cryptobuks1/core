<?php

namespace App\Modules\News\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'news';
    protected $fillable = [
        'title',
        'news_slug',
        'short_description',
        'content',
        'author',
        'seo',
        'image',
        'author_email',
        'language',
        'custom_layout',
        'view_count',
        'status',
        'publish_date'
    ];


    public function getbyTag($id){
        $news = News::find($id);
        $tag_info = array();
        if($news){
            $tag_info['title'] = $news->title;
            $tag_info['url'] = url('/'.$news->news_slug);
            $tag_info['desc'] = $news->short_description;
            $tag_info['image'] = url($news->image);

        }else{

            $tag_info = null;
        }

        return $tag_info;
    }

}