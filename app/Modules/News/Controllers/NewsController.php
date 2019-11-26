<?php

namespace App\Modules\News\Controllers;

use App\Helpers\SlugHelper;
use App\Modules\Language\Models\Language;
use App\Modules\Seo\Models\Seo;
use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use Image;
use DB;
use App\Modules\Slug\Models\Slug;
use App\Modules\News\Models\News;

class NewsController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'News Management';
        View::share ('title', $title );
    }

	public function index(Request $request)
	{
        $news = News::orderBy('id','DESC')->paginate(10);
        if($request->input('keyword')!='')
        {
            $keyword = $request->input('keyword');
            $typeSearch = $request->input('type');
            $title  = "Search: ";
            if($typeSearch!==''){
                switch ($typeSearch) {
                    case 'author':
                        $title .= 'Author = ';
                        break;
                    case 'language':
                        $title .= 'Language = ';
                        break;
                    case 'status':
                        $title .= 'Status = ';
                        break;
                    default:
                        $title .= 'Title = ';
                        break;
                }
                if($typeSearch=='status')
                    $news = News::where($typeSearch, $keyword)->orderBy('id','DESC')->paginate(10);
                else
                    $news = News::where($typeSearch, 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(10);
            }else{
                $news = News::where('title', 'LIKE', '%'.$keyword.'%')
                                ->orwhere('author', 'LIKE', '%'.$keyword.'%')
                                ->orwhere('language', 'LIKE', '%'.$keyword.'%')
                                // ->orwhere('status', $keyword)
                                ->orderBy('id','DESC')
                                ->paginate(10);
            }
            $title .= $keyword;
        }

        return view("News::index", compact('title','news'));
	}


	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
	        $author = auth()->user()->name;
	        $author_email = auth()->user()->email;
			$languages = Language::where('status', 1)->select('name','code')->orderBy('sort', 'ASC')->get()->toArray();

            $tags = app('App\Modules\Tags\Models\Tagslist')->get(array('id','code','label'));
            return view('News::create', compact('author','author_email','languages','tags'));
        }else{
            echo 'Not Access';
            return false;
        }
	}

    public function store(Request $request)
    {
//        $this->validate($request, [
//            'title' => 'required',
//            'news_slug' => 'required|unique:news|max:255',
//            'content' => 'required',
//             'author' => 'required',
//            'language' => 'required',
//            'status' => 'required'
//        ]);

        $input = $request->all();

        if($request->image){
            $imagelink = explode('storage',$request->image);
            $input['image'] = '/storage'.$imagelink[1];
        }

        $input['created_at'] = now();
        $input['updated_at'] = now();
        $input['news_slug'] = Slug::makeSlug($request->news_slug);
        if(! Slug::checkSlug($input['news_slug'])){
            return redirect()->back()->withErrors(['error' => 'Đường dẫn SEO đã tồn tại, vui lòng chỉnh sửa lại']);
        }
        DB::beginTransaction();

        try {
            ///Seo onpage
            $meta['link'] = $input['news_slug'];
            $meta['title'] = $input['title'];
            $meta['description'] = (isset($input['short_description'])) ? $input['short_description'] : $input['title'];
            $meta['avatar'] = $input['image'];
            $meta['language'] = $input['language'];
            $seo_id = Seo::createMeta($meta);

            $input['seo'] = $seo_id;

            $news = News::create($input);


            /// Tạo slug
            $slug['slug'] = $input['news_slug'];
            $slug['module'] = 'News';
            $slug['model'] = 'News';
            $slug['model_id'] = $news->id;
            Slug::create($slug);


            /** save news tags **/
            $new_tags = array();
            if (isset($request->tags))
                $new_tags = $request->tags;
            if ($request->new_tags && $request->new_tags != '') {
                $new_tags_ids = \App\Modules\Tags\Controllers\TagslistController::createNewTags($request->new_tags, 'News', 'News', $news->id);
                $new_tags = array_merge($new_tags, $new_tags_ids);

            }
            if (count($new_tags) > 0) {

                \App\Modules\Tags\Controllers\TagslistController::addTag($new_tags, 'News', 'News', $news->id);

            }
            /** end save news tags **/
            DB::commit();
            return redirect()->route('news.index')
                ->with('success', 'Đăng tin thành công');
        } catch (\Exception $e){

            DB::rollback();
            return redirect()->route('news.index')
                ->withErrors(['error' => $e->getMessage()]);
        }


    }

    public function edit($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|BACKEND') )
        {

        	$news  = News::find($id);
			$languages = Language::where('status', 1)->select('name','code')->orderBy('default')->get()->toArray();

            $tags = app('App\Modules\Tags\Models\Tagslist')->select('id','code','label')->limit(20)->get();
            $selected_tags = app('App\Modules\Tags\Models\Tagslist')->where('model_id',$id)
                                ->where('module','News')
                                ->groupBy('id')
                                ->pluck('id')
                                ->toArray();

            return view('News::edit',compact('news','languages','tags','selected_tags'));
        }else{
            return back()->withErrors(['error' => 'Bạn không có quyền sửa!']);
        }
    }

	public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'news_slug' => 'required|max:255',
        ]);

        $news = News::find($id);

        if($request->image){
        $imagelink = explode('storage',$request->image);
        $news->image = '/storage'.$imagelink[1];
    }

        $old_slug = Slug::where('slug', $news->news_slug)->where('model_id', $news->id)->first();
        $newSlug = Slug::makeSlug($request->news_slug);

        if($old_slug){
            if($old_slug->slug !== $newSlug){

                //Update đè slug cũ
                $old_slug->slug= $newSlug;
                $old_slug->update();

                $news->news_slug = $newSlug;
            }
        }else{

            $old_slug = new Slug;
            $old_slug->slug = $newSlug;
            $old_slug->module = 'News';
            $old_slug->model = 'News';
            $old_slug->model_id = $news->id;
            $old_slug->save();

            $news->news_slug = $newSlug;
        }

        //Update seo
        $seo_id = null;
        $seo = Seo::where('link', $old_slug->slug)->first();
        if(!$seo){
            $meta['link'] = $old_slug->slug;
            $meta['title'] = $request->title;
            $meta['description'] = $request->short_description;
            $meta['avatar'] = $news->image;
            $meta['language'] = $news->language;
            $seo_id = Seo::createMeta($meta);
        }


        $news->title = $request->title;
        $news->short_description = $request->short_description;
        $news->content = $request->input('content');
        $news->language = $request->language;
        $news->view_count = $request->view_count;
        $news->status = $request->status;
        $news->publish_date = $request->publish_date;

        if($seo_id){
            $news->seo = $seo_id;
        }

        $news->save();


        /** save news tags **/
        $new_tags = array();
        $delete_tags = array();
        $module_type = 'News';
        $selected_tags = \App\Modules\Tags\Models\Tagslist::where('model_id',$id)
                            ->where('module',$module_type)
                            ->groupBy('id')
                            ->pluck('id')
                            ->toArray();

        if(count($selected_tags)>0){
            if($request->tags && count($request->tags)>0){
                $delete_tags = array_diff($selected_tags, $request->tags);
                $new_tags = array_diff($request->tags,$selected_tags);
            }else{
                $delete_tags = $request->tags;
            }
        }else{
            if($request->tags){
                $new_tags = $request->tags;
            }

        }


        if($request->new_tags && $request->new_tags!=''){
            $new_tags_ids= \App\Modules\Tags\Controllers\TagslistController::createNewTags($request->new_tags, 'News', 'News', $id);
            $new_tags = array_merge($new_tags,$new_tags_ids);
        }

        if($delete_tags && count($delete_tags)>0){
            foreach ($delete_tags as $tag_id) {
                \App\Modules\Tags\Controllers\TagslistController::deleteTagItems($tag_id);
            }
        }

        //// Add tag vào bài viết
        if($new_tags && count($new_tags)>0){
                 \App\Modules\Tags\Controllers\TagslistController::addTag($new_tags,'News','News', $id);
        }


        return redirect()->route('news.index')
                        ->with('success','News updated successfully');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|BACKEND') )
        {

            $news = News::find($id);
            if(!$news){
                return back()->withErrors(['error' => 'Tin này không tồn tại!']);
            }

            DB::beginTransaction();
            try{

                //Xoa slug
                $slug = Slug::where('model_id', $id)->where('module', 'News')->where('model', 'News')->first();
                if($slug){
                    $slug->delete();
                }
                //Xóa tag
                \App\Modules\Tags\Controllers\TagslistController::deleteAllTagItems($id, 'News', 'News');
                /// Xóa Seo
                $seo = Seo::find($news->seo);
                if($seo){
                    $seo->delete();
                }
                /// Xóa News
                $news->delete();

                DB::commit();

                return redirect()->route('news.index')
                    ->with('success','Xóa tin thành công');

            }catch (\Exception $e){

                DB::rollback();
                return redirect()->route('news.index')
                    ->withErrors(['error' =>'Xóa tin thất bại']);

            }

        }else{
            return back()->withErrors(['error' => 'Bạn không có quyền xóa!']);
        }
    }

	public function actions(Request $request)
    {
        $val    = $request->check;
        $action = $request->action;
        if(empty($val)){
            return redirect()->route('news.index')->withErrors(['message' =>'Không có mục nào được chọn.']);
        }

        foreach ($val as $value) {
            $news = News::find($value);
            $this->_runAction($value, $action);
        }
        return redirect()->route('news.index')->with('success','News  '.$action.' successfully');
    }

    private function _runAction($id, $action)
    {
        switch ($action) {
            case 'delete':
                $this->destroy($id);
                break;

            default:
                break;
        }
        return null;
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
