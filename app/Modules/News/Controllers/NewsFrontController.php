<?php
namespace App\Modules\News\Controllers;

use App\Modules\Frontend\Controllers\FrontendController;
use Illuminate\Http\Request;
use Session;
use App;

use App\Modules\News\Models\News;

class NewsFrontController extends FrontendController{

    public function __construct(){
        parent::__construct();
	}

	public function index(){
		if(App::getLocale())
			$locale = App::getLocale();
		else
			$locale = 'vi';
		$news = News::where('language','=',$locale)
					->where('status',1)
					->orderBy('id','DESC')
					->paginate(10);
        $seo_advanced = render_seo('seo_advanced');
		return theme_view('pages.tintuc',compact('news', 'seo_advanced'));
	}

	public static function getListNews($locale='vi',$limit=10){
		$news = News::where('language','=',$locale)
					->where('status',1)
					->limit($limit)
					->orderBy('id','DESC')
					->get();
		return $news;
	}

	public static function renderViewPage(Request $request){

		if(App::getLocale())
			$locale = App::getLocale();
		else
			$locale = 'vi';
		$news = News::where('language','=',$locale)
					->where('news_slug','=',$request->news_slug)
					->where('status',1)
					->first();
		if($news){
			if(!Session::has('view_count')){
				$news->view_count = $news->view_count +1;
				$news->save();
				Session::put('view_count',true);
			}
			$tags = static::getNewsTags($news->id);
	        return theme_view('pages.chitiet',compact('news','tags'));
        }else{
        	return abort(404);
        }
	}

	public static function getNewsTags($newsId){
        $tags = app('App\Modules\Tags\Models\Tagslist')->where('model_id',$newsId)
	                        ->where('module','News')
	                        ->get();
	    return $tags;
	}
}
