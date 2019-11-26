<?php

namespace App\Modules\Categories\Controllers;

use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use Validator;
use App\Modules\Categories\Models\Categories;
use App\Modules\Categories\Models\CategoriesProduct;

class CategoriesController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'Categories Management';
        View::share ('title', $title );
    }

	public function index(Request $request)
	{
        $form_title = 'Create New Category';
        $tree_html = $this->getTreeHtml(0);
        $form_html = $this->getFormHtml();
		return view("Categories::index",compact('tree_html','form_html','form_title'));
	}

	public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url_key' => 'required'
        ]);

        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        if($input['parent_id']){
            $parent_cate = Categories::find($input['parent_id']);
            $parent_cate->children_count = $parent_cate->children_count + 1;
            $parent_cate->save();
            $level = $parent_cate->level + 1;
        }else{
            $level = 1;
        }
        $input['level'] = $level;
        $input['status'] = empty($input['status']) ? 1 : $input['status'];
        $cate = Categories::create($input);
        return redirect()->route('categories.index')
                        ->with('success','Category created successfully');
    }

    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $name = Categories::where('id',$id)->pluck('name')->first();
            $form_title = 'Edit Category: '.$name;
            $tree_html = $this->getTreeHtml(0,$id);
            $form_html = $this->getFormHtml($id);
            return view("Categories::index",compact('tree_html','form_html','form_title'));
        }else{
            echo 'Not Access';
            return ;
        }
	}

	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'url_key' => 'required'
        ]);

        $cate = Categories::find($id);
        $cate_status = empty($request->status) ? 1 : $request->status;
        $parent_id = empty($request->parent_id) ? 0 : $request->parent_id;
        $level = 1;

        if($cate->parent_id!=$parent_id){
            if(!$cate->parent_id){
                $new_parent =  Categories::find($parent_id);
                $new_parent->children_count = $new_parent->children_count + 1;
                $level = $new_parent->level + 1;
                $new_parent->save();
            }else{
                $parent_cate = Categories::find($cate->parent_id);
                $parent_cate->children_count = $parent_cate->children_count - 1;
                $parent_cate->save();
                if($parent_id){
                    $new_parent =  Categories::find($parent_id);
                    $new_parent->children_count = $new_parent->children_count + 1;
                    $level = $new_parent->level + 1;
                    $new_parent->save();
                }
            }
            $this->updateChildrenLevel($id,$parent_id);
        }
        $cate->name = $request->name;
        $cate->url_key  = $request->url_key;
        $cate->parent_id = $parent_id;
        $cate->description  = $request->description;
        /*$cate->custom_layout = $request->custom_layout;*/
        $cate->level = $level;
        $cate->sort_order = $request->sort_order;
        $cate->status = $cate_status;
        $cate->save();
        return redirect()->route('categories.index')
                        ->with('success','Category updated successfully');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $this->deleteCateAndSub($id);
            return redirect()->route('categories.index')
                        ->with('success','Category deleted successfully');
        }else{
            return redirect()->route('categories.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

    public function deleteCateAndSub($id,$current=true){
        $cate = Categories::find($id);
        if($cate->parent_id && $current){
            $parent_cate =  Categories::find($cate->parent_id);
            $parent_cate->children_count = $parent_cate->children_count - 1;
            $parent_cate->save();
        }
        $children_count = $cate->children_count;
        $cate->delete();

        /* delete data in table category_product */
        $this->deleteCateProduct($id);

        if($children_count){
            $children_cate = Categories::where('parent_id', $id)->get();
            foreach ($children_cate as $child) {
                $this->deleteCateAndSub($child->id,false);
            }
        }
    }

    public function deleteCateProduct($id){
        $items = CategoriesProduct::where('category_id',$id)->get();
        foreach ($items as $item) {
            CategoriesProduct::find($item->id)->delete();
        }
    }

    public function updateChildrenLevel($c_id,$p_id=null){
        if($p_id){
            $parent = Categories::find($p_id);
            $level = $parent->level + 1;
        }else{
            $level = 1;
        }
        $children = Categories::find($c_id);
        $children->parent_id = $p_id;
        $children->level = $level;
        $children->save();
        if($children->children_count){
            $c_childrens = Categories::where('parent_id', $c_id)->get();
            foreach ($c_childrens as $c_children) {
                $c_children->level = $children->level + 1;
                $c_children->save();
                if($c_children->children_count){
                    $this->updateChildrenLevel($c_children->id,$c_id);
                }
            }
        }
        return true;
    }

    public static function getTreeHtml($parent_id, $selected=0){
        $html = '';
        $root_cate = Categories::where('parent_id', $parent_id)->orderBy('sort_order','ASC')->get();
        $html .= view("Categories::cate_tree",compact('parent_id','root_cate','selected'))->render();
        return $html;
    }

    public static function getCateListArray($pid=0,$ignore=null){
        $list = array();
        $cate = Categories::where('parent_id',$pid)
                    ->orderBy('sort_order','ASC')
                    ->get()
                    ->toArray();
        if(count($cate)){
            foreach ($cate as $value) {
                if($value['id']!=$ignore){
                    $list[$value['id']]['data'] = $value;
                    if($value['children_count']>0){
                        $childs = static::getCateListArray($value['id'],$ignore);
                        $list[$value['id']]['childs'] = $childs;
                    }
                }
            }
        }
        return $list;
    }

    public static function buildSelectParent($listCate,$selected=array()){
        $result = '';
        foreach ($listCate as $id => $value) {
            $result .= '<option value="'.$id.'"';
            if(!$value['data']['status']){
                $result .= ' class="status-disable"';
            }
            if(in_array($id, $selected)){
                $result .= ' selected="selected"';
            }
            $result .='>';

            for ($i=1; $i < $value['data']['level'] ; $i++) { 
                $result .= '---';
            }

            $result .= ' '.$value['data']['name'];
            $result .= '</option>';
            if(isset($value['childs']) && count($value['childs'])){
                $result .= static::buildSelectParent($value['childs'],$selected);
            }
        }
        return $result;
    }

    public function getFormHtml($id=''){
        $html = '';
        $pid = 0;
        if($id)
            $pid = Categories::where('id',$id)->pluck('parent_id')->first();
        $cateList = static::getCateListArray(0,$id);
        $selectHtml = static::buildSelectParent($cateList,array($pid));

        if($id){
            $cate = Categories::find($id);
            $html .= view("Categories::cate_form",compact('id','cate','selectHtml'))->render();
        }else{
            $html .= view("Categories::cate_form",compact('id','selectHtml'))->render();
        }
        return $html;
    }

    public function ajaxPost(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'url_key' => 'required'
        ]);
        $error_message = array();
        $success_message = '';
        $tree_html = '';
        $form_html = '';
        $form_title = 'Create New Category';
        $cate_id = 0;

        if($validation->fails()){
            foreach ($validation->messages()->getMessages() as $key => $value) {
                $error_message[] = $value;
            }
        }else{
            $input = $request->all();
            if(isset($input['id']) && $input['id']){
                /* ajax update cate */
                $cate = Categories::find($input['id']);
                $parent_id = empty($input['parent_id']) ? 0 : $input['parent_id'];
                $level = 1;

                if($cate->parent_id!=$parent_id){
                    if(!$cate->parent_id){
                        $new_parent =  Categories::find($parent_id);
                        $new_parent->children_count = $new_parent->children_count + 1;
                        $level = $new_parent->level + 1;
                        $new_parent->save();
                    }else{
                        $parent_cate = Categories::find($cate->parent_id);
                        $parent_cate->children_count = $parent_cate->children_count - 1;
                        $parent_cate->save();
                        if($parent_id){
                            $new_parent =  Categories::find($parent_id);
                            $new_parent->children_count = $new_parent->children_count + 1;
                            $level = $new_parent->level + 1;
                            $new_parent->save();
                        }
                    }
                    $this->updateChildrenLevel($input['id'],$parent_id);
                }
                $cate->name = $input['name'];
                $cate->url_key  = $input['url_key'];
                $cate->description  = $input['description'];
                /*$cate->custom_layout = $input['custom_layout'];*/
                $cate->parent_id = $parent_id;
                $cate->level = $level;
                $cate->sort_order = $input['sort_order'];
                $cate->status = $input['status'];
                $cate->save();
                $cate_id = $cate->id;

                $success_message = 'Category '.$cate->name.' updated successfully';
            }else{
                /* ajax add new cate */
                $parent_id = empty($input['parent_id']) ? 0 : $input['parent_id'];
                if($parent_id){
                    $parent_cate = Categories::find($parent_id);
                    $parent_cate->children_count = $parent_cate->children_count + 1;
                    $parent_cate->save();
                    $level = $parent_cate->level + 1;
                }else{
                    $level = 1;
                }
                $cate =  new Categories;
                $cate->name = $input['name'];
                $cate->url_key = $input['url_key'];
                $cate->description  = $input['description'];
                /*$cate->custom_layout = $input['custom_layout'];*/
                $cate->parent_id = $input['parent_id'];
                $cate->level = $level;
                $cate->sort_order = $input['sort_order'];
                $cate->status = $input['status'];
                $cate->save();
                $cate_id = $cate->id;
                $success_message = 'Category '.$cate->name.' created successfully';
            }
            $tree_html = $this->getTreeHtml(0,$cate->id);
            $form_html = $this->getFormHtml($cate_id);
            $form_title = 'Edit Category: '.$cate->name;
        }
        $result['error_message'] = $error_message;
        $result['success_message'] = $success_message;
        $result['form_html'] = $form_html;
        $result['tree_html'] = $tree_html;
        $result['form_title'] = $form_title;
        $result['id'] = $cate_id;

        echo json_encode($result);
    }

    public function ajaxItemAction(Request $request){
        $input = $request->all();
        $form_title = 'Create New Category';
        $item_id = 0;
        if($input['type']=='edit'){
            $item_id = $input['id'];
            $name = Categories::where('id',$item_id)->pluck('name')->first();
            $form_title = 'Edit Category: '.$name;

        }elseif($input['type']=='delete'){
            $this->deleteCateAndSub($input['id']);

        }elseif($input['type']=='moveup'){
            $cate = Categories::find($input['id']);
            $parent_cate = Categories::find($cate->parent_id);
            $parent_cate->children_count = $parent_cate->children_count - 1;
            $parent_cate->save();
            $pid = 0;
            if($parent_cate->parent_id){
                $new_parent =  Categories::find($parent_cate->parent_id);
                $new_parent->children_count = $new_parent->children_count + 1;
                $new_parent->save();
                $pid = $new_parent->id;
            }
            $this->updateChildrenLevel($cate->id,$pid);
        }

        $tree_html = $this->getTreeHtml(0,$item_id);
        $form_html = $this->getFormHtml($item_id);
        $result['form_html'] = $form_html;
        $result['tree_html'] = $tree_html;
        $result['form_title'] = $form_title;
        echo json_encode($result);
    }

    public function renderCreateForm(Request $request){
        $result = array();
        $result['form_html'] = $this->getFormHtml();
        $result['form_title'] = 'Create New Category';
        echo json_encode($result);
    }
}