<?php

namespace App\Modules\Menu\Controllers;

use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use Validator;
use App\Modules\Menu\Models\Menu;

class MenuController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'Menu Management';
        View::share ('title', $title );
    }

	public function index(Request $request)
	{
        $form_title = 'Create New Menu';
        $tree_html = $this->getTreeHtml(0);
        $form_html = $this->getFormHtml();
		return view("Menu::index",compact('tree_html','form_html','form_title'));
	}

	public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required'
        ]);

        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        if($input['parent_id']){
            $parent_menu = Menu::find($input['parent_id']);
            $parent_menu->children_count = $parent_menu->children_count + 1;
            $parent_menu->save();
            $level = $parent_menu->level + 1;
        }else{
            $level = 1;
        }
        $input['level'] = $level;
        $input['status'] = empty($input['status']) ? 1 : $input['status'];
        $menu = Menu::create($input);
        return redirect()->route('menu.index')
                        ->with('success','Menu created successfully');
    }

    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $name = Menu::where('id',$id)->pluck('name')->first();
            $form_title = 'Edit Menu: '.$name;
            $tree_html = $this->getTreeHtml(0,$id);
            $form_html = $this->getFormHtml($id);
            return view("Menu::index",compact('tree_html','form_html','form_title'));
        }else{
            echo 'Not Access';
            return ;
        }
	}

	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required'
        ]);

        $menu = Menu::find($id);
        $menu_status = empty($request->status) ? 1 : $request->status;
        $parent_id = empty($request->parent_id) ? 0 : $request->parent_id;
        $level = 1;

        if($menu->parent_id!=$parent_id){
            if(!$menu->parent_id){
                $new_parent =  Menu::find($parent_id);
                $new_parent->children_count = $new_parent->children_count + 1;
                $level = $new_parent->level + 1;
                $new_parent->save();
            }else{
                $parent_menu = Menu::find($menu->parent_id);
                $parent_menu->children_count = $parent_menu->children_count - 1;
                $parent_menu->save();
                if($parent_id){
                    $new_parent =  Menu::find($parent_id);
                    $new_parent->children_count = $new_parent->children_count + 1;
                    $level = $new_parent->level + 1;
                    $new_parent->save();
                }
            }
            $this->updateChildrenLevel($id,$parent_id);
        }
        $menu->name = $request->name;
        $menu->url  = $request->url;
        $menu->parent_id = $parent_id;
        $menu->level = $level;
        $menu->sort_order = $request->sort_order;
        $menu->status = $menu_status;
        $menu->save();
        return redirect()->route('menu.index')
                        ->with('success','Menu updated successfully');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $this->deleteMenuAndSub($id);
            return redirect()->route('menu.index')
                        ->with('success','Menu deleted successfully');
        }else{
            return redirect()->route('menu.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

    public function deleteMenuAndSub($id,$current=true){
        $menu = Menu::find($id);
        if($menu->parent_id && $current){
            $parent_menu =  Menu::find($menu->parent_id);
            $parent_menu->children_count = $parent_menu->children_count - 1;
            $parent_menu->save();
        }
        $children_count = $menu->children_count;
        $menu->delete();

        if($children_count){
            $children_menu = Menu::where('parent_id', $id)->get();
            foreach ($children_menu as $child) {
                $this->deleteMenuAndSub($child->id,false);
            }
        }
    }

    public function updateChildrenLevel($c_id,$p_id=null){
        if($p_id){
            $parent = Menu::find($p_id);
            $level = $parent->level + 1;
        }else{
            $level = 1;
        }
        $children = Menu::find($c_id);
        $children->parent_id = $p_id;
        $children->level = $level;
        $children->save();
        if($children->children_count){
            $c_childrens = Menu::where('parent_id', $c_id)->get();
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
        $root_menu = Menu::where('parent_id', $parent_id)->orderBy('sort_order','ASC')->get();
        $html .= view("Menu::menu_tree",compact('parent_id','root_menu','selected'))->render();

        return $html;
    }

    public function getMenuListArray($pid=0,$ignore=null){
        $list = array();
        $menu = Menu::where('parent_id',$pid)
                    ->orderBy('sort_order','ASC')
                    ->get()
                    ->toArray();
        if(count($menu)){
            foreach ($menu as $value) {
                if($value['id']!=$ignore){
                    $list[$value['id']]['data'] = $value;
                    if($value['children_count']>0){
                        $childs = $this->getMenuListArray($value['id'],$ignore);
                        $list[$value['id']]['childs'] = $childs;
                    }
                }
            }
        }
        return $list;
    }

    public function getMenuListBytype($type){
        $list = array();
        $menu = Menu::where('parent_id',0)
                    ->where('menu_type',$type)
                    ->orderBy('sort_order','ASC')
                    ->get()
                    ->toArray();
        if(count($menu)){
            foreach ($menu as $value) {
                $list[$value['id']]['data'] = $value;
                if($value['children_count']>0){
                    $childs = $this->getMenuListArray($value['id']);
                    $list[$value['id']]['childs'] = $childs;
                }
            }
        }
        return $list;
    }

    public function buildSelectParent($listMenu,$selected){
        $result = '';
        foreach ($listMenu as $id => $value) {
            $result .= '<option value="'.$id.'"';
            if(!$value['data']['status']){
                $result .= ' class="status-disable"';
            }
            if($id==$selected){
                $result .= ' selected="selected"';
            }
            $result .='>';

            for ($i=1; $i < $value['data']['level'] ; $i++) { 
                $result .= '---';
            }

            $result .= ' '.$value['data']['name'];
            $result .= '</option>';
            if(isset($value['childs']) && count($value['childs'])){
                $result .= $this->buildSelectParent($value['childs'],$selected);
            }
        }
        return $result;
    }

    public function getFormHtml($id=''){
        $html = '';
        $pid = 0;
        if($id)
            $pid = Menu::where('id',$id)->pluck('parent_id')->first();
        $menuList = $this->getMenuListArray(0,$id);
        $selectHtml = $this->buildSelectParent($menuList,$pid);

        if($id){
            $menu = Menu::find($id);
            $html .= view("Menu::menu_form",compact('id','menu','selectHtml'))->render();
        }else{
            $html .= view("Menu::menu_form",compact('id','selectHtml'))->render();
        }
        return $html;
    }

    public function ajaxPost(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'required'
        ]);

        $error_message = array();
        $success_message = '';
        $tree_html = '';
        $form_html = '';
        $form_title = 'Tạo menu mới';
        $menu_id = 0;

        if($validation->fails()){
            foreach ($validation->messages()->getMessages() as $key => $value) {
                $error_message[] = $value;
            }
        }else{
            $input = $request->all();
            if(isset($input['id'])){
                /* ajax update menu */
                $menu = Menu::find($input['id']);
                $parent_id = empty($input['parent_id']) ? 0 : $input['parent_id'];
                $level = 1;

                if($menu->parent_id !== $parent_id){
                    if(!$menu->parent_id){
                        $new_parent =  Menu::find($parent_id);
                        $new_parent->children_count = $new_parent->children_count + 1;
                        $level = $new_parent->level + 1;
                        $new_parent->save();
                    }else{
                        $parent_menu = Menu::find($menu->parent_id);
                        $parent_menu->children_count = $parent_menu->children_count - 1;
                        $parent_menu->save();
                        if($parent_id){
                            $new_parent =  Menu::find($parent_id);
                            $new_parent->children_count = $new_parent->children_count + 1;
                            $level = $new_parent->level + 1;
                            $new_parent->save();
                        }
                    }
                    $this->updateChildrenLevel($input['id'],$parent_id);
                }
                $menu->name = $input['name'];
                if(isset($input['menu_type']))
                    $menu->menu_type  = $input['menu_type'];
                $menu->url  = $input['url'];
                $menu->parent_id = $parent_id;
                $menu->level = $level;
                $menu->sort_order = $input['sort_order'];
                $menu->status = $input['status'];
                $menu->save();
                $menu_id = $menu->id;

                $success_message = 'Menu '.$menu->name.' updated successfully';
            }else{
                /* ajax add new menu */
                $parent_id = empty($input['parent_id']) ? 0 : $input['parent_id'];
                if($parent_id){
                    $parent_menu = Menu::find($parent_id);
                    $parent_menu->children_count = $parent_menu->children_count + 1;
                    $parent_menu->save();
                    $level = $parent_menu->level + 1;
                }else{
                    $level = 1;
                }
                $menu =  new Menu;
                $menu->name = $input['name'];
                if(isset($input['menu_type']))
                    $menu->menu_type  = $input['menu_type'];
                $menu->url = $input['url'];
                $menu->parent_id = $input['parent_id'];
                $menu->level = $level;
                $menu->sort_order = $input['sort_order'];
                $menu->status = $input['status'];
                $menu->save();
                $menu_id = $menu->id;
                $success_message = 'Menu '.$menu->name.' created successfully';
            }
            $tree_html = $this->getTreeHtml(0,$menu->id);
            $form_html = $this->getFormHtml($menu_id);
            $form_title = 'Edit Menu: '.$menu->name;
        }
        $result['error_message'] = $error_message;
        $result['success_message'] = $success_message;
        $result['form_html'] = $form_html;
        $result['tree_html'] = $tree_html;
        $result['form_title'] = $form_title;
        $result['id'] = $menu_id;

        echo json_encode($result);
    }

    public function ajaxItemAction(Request $request){
        $input = $request->all();
        $form_title = 'Create New Menu';
        $item_id = 0;
        if($input['type']=='edit'){
            $item_id = $input['id'];
            $name = Menu::where('id',$item_id)->pluck('name')->first();
            $form_title = 'Edit Menu: '.$name;

        }elseif($input['type']=='delete'){
            $this->deleteMenuAndSub($input['id']);

        }elseif($input['type']=='moveup'){
            $menu = Menu::find($input['id']);
            $parent_menu = Menu::find($menu->parent_id);
            $parent_menu->children_count = $parent_menu->children_count - 1;
            $parent_menu->save();
            $pid = 0;
            if($parent_menu->parent_id){
                $new_parent =  Menu::find($parent_menu->parent_id);
                $new_parent->children_count = $new_parent->children_count + 1;
                $new_parent->save();
                $pid = $new_parent->id;
            }
            $this->updateChildrenLevel($menu->id,$pid);
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
        $result['form_title'] = 'Create New Menu';
        echo json_encode($result);
    }
}