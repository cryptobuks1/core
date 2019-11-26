<?php
namespace App\Modules\Tags\Controllers;

use App\Modules\Frontend\Controllers\FrontendController;
use View;
use App\Modules\Tags\Models\Tagslist;

class TaglistFrontController extends FrontendController {

	public function tags($code){

        $tags = Tagslist::where('code', $code)->paginate(25);

	    foreach ($tags as $tag){

	        $class = 'App\Modules\\'.$tag->module.'\\Models\\'.$tag->model;
	        $object = new $class;

	        /// Hàm getbyTag viết tại mỗi Model của module cần lấy thông tin
	        $info = $object->getbyTag($tag->model_id);

	        if($info){
                /// gán thêm biến
                $tag->info = $info;
            }
        }


	    return theme_view('pages.taglist', compact('tags', 'code'));

	}

}