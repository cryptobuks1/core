<?php

namespace App\Modules\Page\Controllers;

use App\Modules\Language\Models\Language;
use App\Modules\Seo\Models\Seo;
use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use DB;
use App\Modules\Slug\Models\Slug;
use App\Modules\Page\Models\Page;


class PageController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'Quản lý trang tĩnh';
        View::share ('title', $title );
    }

	public function index(Request $request)
	{
        $staticPage = Page::orderBy('id','DESC')->paginate(10);
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
                    $staticPage = Page::where($typeSearch, $keyword)->orderBy('id','DESC')->paginate(10);
                else
                    $staticPage = Page::where($typeSearch, 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(10);
            }else{
                $staticPage = Page::where('title', 'LIKE', '%'.$keyword.'%')
                                ->orwhere('author', 'LIKE', '%'.$keyword.'%')
                                ->orwhere('language', 'LIKE', '%'.$keyword.'%')
                                // ->orwhere('status', $keyword)
                                ->orderBy('id','DESC')
                                ->paginate(10);
            }
            $title .= $keyword;
        }

        return view("Page::index", compact('title','staticPage'));
	}


	public function create()
	{
		if(allow('create') === true)
        {
			$languages = Language::where('status', 1)->select('name','code')->orderBy('sort', 'ASC')->get()->toArray();

            return view('Page::create', compact('languages'));
        }else{
             return 'Not Access';
        }
	}

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'slug' => 'required|unique:pages|max:255',
            'language' => 'required',
            'description' => 'required'
        ]);

        $input = $request->all();

        $input['created_at'] = now();
        $input['updated_at'] = now();

        $input['slug'] = Slug::makeSlug($request->slug);

        if(! Slug::checkSlug($input['slug'])){
            return redirect()->back()->withErrors(['error' => 'Đường dẫn SEO đã tồn tại, vui lòng chỉnh sửa lại']);
        }


        DB::beginTransaction();
        try {

            ///Seo onpage
            $meta['link'] = $input['slug'];
            $meta['title'] = $input['title'];
            $meta['description'] = $input['title'];
            $meta['avatar'] = null;
            $meta['language'] = $input['language'];
            $seo_id = Seo::createMeta($meta);

            $input['seo'] = $seo_id;

            $page = Page::create($input);

            /// Tạo slug
            $slug['slug'] = $input['slug'];
            $slug['module'] = 'Page';
            $slug['model'] = 'Page';
            $slug['model_id'] = $page->id;
            Slug::create($slug);

            /** end save news tags **/
            DB::commit();
            return redirect()->route('pages.index')
                ->with('success', 'Đăng bài thành công');
        } catch (\Exception $e){

            DB::rollback();
            return redirect()->route('pages.index')
                ->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function edit($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|BACKEND') )
        {
        	$staticPage  = Page::find($id);
			$languages = Language::where('status', 1)->select('name','code')->orderBy('default')->get()->toArray();

            return view('Page::edit',compact('staticPage','languages'));
        }else{
            return 'Not Access';
        }
    }

	public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'title' => 'required',
            'slug' => 'required|max:255',
        ]);

        $page = Page::find($id);

        $old_slug = Slug::where('slug', $page->slug)->where('model_id', $page->id)->first();

        $newSlug = Slug::makeSlug($request->slug);

        if(!$old_slug){
            $old_slug = new Slug;
            $old_slug->slug= $newSlug;
            $old_slug->module= 'Page';
            $old_slug->model=  'Page';
            $old_slug->model_id= $id;
            $old_slug->save();

        }else{

            if($old_slug->slug !== $newSlug) {
                if (!Slug::checkSlug($newSlug)) {
                    return redirect()->back()->withErrors(['error' => 'Đường dẫn SEO đã tồn tại, vui lòng chỉnh sửa lại']);
                }
            }
        }
        $page->slug = $newSlug;
        $page->title = $request->title;
        $page->description = $request->input('description');
        $page->language = $request->language;
        $page->status = $request->status;


        DB::beginTransaction();
        $page->save();
        $old_slug->slug = $page->slug;
        $old_slug->update();
        DB::commit();

        /** save news tags **/
        return redirect()->route('pages.index')
                        ->with('success','Trang được cập nhật thành công');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|BACKEND') )
        {
            DB::beginTransaction();

        	Page::find($id)->delete();
            $result = \App\Modules\Tags\Controllers\TagslistController::deleteAllTagItems($id, 'Page', 'Page');

            if($result){
                DB::commit();

                return redirect()->route('pages.index')
                    ->with('success','Xóa tin thành công');
            }else{
                DB::rollback();
                return redirect()->route('pages.index')
                    ->withErrors(['error' =>'Xóa tin thất bại']);
            }
        }else{
            return 'Not Access';

        }
    }

	public function actions(Request $request)
    {
        $val    = $request->check;
        $action = $request->action;
        if(empty($val)){
            return redirect()->route('pages.index')->withErrors(['message' =>'Không có mục nào được chọn.']);
        }

        foreach ($val as $value) {
            Page::find($value);
            $this->_runAction($value, $action);
        }
        return redirect()->back()->with('success','Page  '.$action.' successfully');
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
