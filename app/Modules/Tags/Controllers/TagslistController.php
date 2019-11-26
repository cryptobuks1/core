<?php

namespace App\Modules\Tags\Controllers;

use App\Modules\Slug\Models\Slug;
use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use App\Modules\Tags\Models\Tagslist;

class TagslistController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'Tags List';
        View::share('title', $title);
    }

    public function index(Request $request)
    {
        $tags = Tagslist::orderBy('id', 'DESC')->paginate(10);
        if ($request->input('keyword') != '') {
            $keyword = $request->input('keyword');
            $title = "Search: " . $keyword;
            $typeSearch = $request->input('type');
            $title = "Search: ";
            if ($typeSearch !== '') {
                switch ($typeSearch) {
                    case 'code':
                        $title .= 'Tag Code = ';
                        break;
                    case 'description':
                        $title .= 'Description = ';
                        break;
                    case 'author':
                        $title .= 'Author = ';
                        break;
                    case 'status':
                        $title .= 'Status = ';
                        break;
                    default:
                        $title .= 'Tag Label = ';
                        break;
                }
                if ($typeSearch == 'status')
                    $tags = Tagslist::where($typeSearch, $keyword)->orderBy('id', 'DESC')->paginate(10);
                else
                    $tags = Tagslist::where($typeSearch, 'LIKE', '%' . $keyword . '%')->orderBy('id', 'DESC')->paginate(10);
            } else {
                $tags = Tagslist::where('code', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('label', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('author', 'LIKE', '%' . $keyword . '%')
                    ->paginate(10);
            }
            $title .= $keyword;
        }
        return view("Tags::list_index", compact('title', 'tags'));
    }


    public function create()
    {
        if (auth()->user()->hasRole('SUPER_ADMIN|ADMIN')) {
            $author = auth()->user()->name;
            return view('Tags::list_create', compact('author'));
        } else {
            echo 'Not Access';
            return;
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'module' => 'required',
            'model' => 'required',
            'model_id' => 'required|numeric',
        ]);

        $input = $request->all();
        $input['code'] = Slug::makeSlug($request->label);
        $input['checksum'] = md5($request->label.$request->module.$request->model_id);
        Tagslist::create($input);
        return redirect()->route('tagslist.index')
            ->with('success', 'Tag created successfully');
    }

    public function edit($id)
    {
        if (auth()->user()->hasRole('SUPER_ADMIN|ADMIN')) {
            $tag = Tagslist::find($id);
            return view('Tags::list_edit', compact('tag'));
        } else {
            echo 'Not Access';
            return;
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'label' => 'required',
            'module' => 'required',
            'model' => 'required',
            'model_id' => 'required|numeric'
        ]);

        $tag = Tagslist::find($id);
        $tag->description = $request->description;
        $tag->module = $request->module;
        $tag->model = $request->model;
        $tag->model_id = $request->model_id;
        $tag->checksum = md5($tag->label.$request->module.$request->model_id);
        $tag->status = $request->status;
        $tag->save();
        return redirect()->route('tagslist.index')
            ->with('success', 'Tag updated successfully');
    }

    public function destroy($id)
    {
        if (auth()->user()->hasRole('SUPER_ADMIN|ADMIN')) {
            Tagslist::find($id)->delete();
            return redirect()->route('tagslist.index')
                ->with('success', 'Tag deleted successfully');
        } else {
            echo 'Not Access';
            return;
        }
    }

    public function actions(Request $request)
    {
        $val = $request->check;
        $action = $request->action;
        if (empty($val)) {
            return redirect()->route('tagslist.index')->withErrors(['message' => 'Không có mục nào được chọn.']);
        }

        foreach ($val as $value) {
            $tag = Tagslist::find($value);
            $this->_runAction($value, $action);
        }
        return redirect()->route('tagslist.index')->with('success', 'Tags ' . $action . ' successfully');
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

    public static function createNewTags($tag_name, $module, $model, $model_id)
    {

        $result = array();
        $tags = explode(',', $tag_name);
        if(is_array($tags)) {
            foreach ($tags as $tag) {
                if ($tag != '') {
                    $tag_slug = Slug::makeSlug($tag);

                    $newTag = new Tagslist;
                    $newTag->code = $tag_slug;
                    $newTag->label = trim($tag);
                    $newTag->description = trim($tag);
                    $newTag->author = auth()->user()->name;
                    $newTag->module = $module;
                    $newTag->model = $model;
                    $newTag->model_id = $model_id;
                    $newTag->checksum = md5($newTag->label.$newTag->module.$newTag->model_id);

                    $check = Tagslist::where(['checksum' => $newTag->checksum])->first();
                    if($check){
                        continue;
                    }else{
                        $newTag->save();
                        $result[] = $newTag->id;
                    }

                }
            }
            return $result;
        }else{
            return null;
        }

    }


    public static function deleteTagItems($tagId){
        Tagslist::where('id',$tagId)
            ->delete();
        return true;
    }

    public static function addTag($new_tags,$module,$model, $model_id){
        if(count($new_tags) > 0) {

            foreach ($new_tags as $tagId){

                $item = Tagslist::find($tagId);

                $newtag = new Tagslist;
                $newtag->code = $item->code;
                $newtag->label = $item->label;
                $newtag->description = $item->description;
                $newtag->author = auth()->user()->name;
                $newtag->module = $module;
                $newtag->model = $model;
                $newtag->model_id = $model_id;
                $newtag->checksum = md5($newtag->label.$module.$model_id);

                $check = Tagslist::where(['checksum' => $newtag->checksum])->first();
                if($check){

                    continue;

                }else{
                    $newtag->save();
                }
            }

        }

    }

    public static function deleteAllTagItems($model_id,$module, $model){
        Tagslist::where(['model_id' => $model_id, 'module' => $module, 'model' => $model])->delete();
        return true;
    }



}