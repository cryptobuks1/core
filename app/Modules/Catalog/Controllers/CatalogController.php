<?php

namespace App\Modules\Catalog\Controllers;

use App\Modules\Language\Models\Language;
use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use App\Modules\Catalog\Models\Catalog;

class CatalogController extends BackendController
{

    ///1. ĐỔI PARENT
    // $parent = Catalog::find(3);
    // $zing= Catalog::find(6);
    // $zing->appendToNode($parent)->save();

    ///2. SẮP XẾP NODE
    // $hangxom = Catalog::find(9);
    // $nhaminh= Catalog::find(6);
    // $nhaminh->afterNode($hangxom)->save(); => đứng sau nhà hàng xóm
    // $nhaminh->beforeNode($hangxom)->save(); => đứng trước nhà hàng xóm



	public function index(Request $request)
	{
		$title    = "Quản lý Nested Catalog";
		$catalogs = Catalog::where('lang', 'vi')->get()->toTree();
        $langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();
        $cats = Catalog::where('id', '!=', 1)->get();

         $hangxom = Catalog::find(9);
         $nhaminh= Catalog::find(4);
         //$nhaminh->afterNode($hangxom)->save();
         $nhaminh->beforeNode($hangxom)->save();


		return view("Catalog::index", compact('title','catalogs', 'langs', 'cats'));
	}


	public function create()
	{
		if(allow('create') === true)
        {
        	$title    = "Thêm catalog";
        	$langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();
            $cats = Catalog::where('id', '!=', 1)->get();

            return view('Catalog::create',compact('title', 'langs', 'cats'));
        }else{

            return redirect()->back()->withErrors(['error' => 'Bạn không có quyền thực hiện tác vụ này!']);
        }
	}

	public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'parent_id' => 'required',
            'lang' => 'required',
            'slug' => 'required|unique:catalogs,slug'
        ]);

        $input = $request->all();
        $parent = Catalog::find($request->parent_id);

        if(isset($input['status']))
        {
        	$input['status'] = 1;
        }else{
        	$input['status'] = 0;
        }
        if(isset($input['hidden']))
        {
            $input['hidden'] = 1;
        }else{
            $input['hidden'] = 0;
        }
        if(isset($input['featured']))
        {
            $input['featured'] = 1;
        }else{
            $input['featured'] = 0;
        }
        Catalog::create($input, $parent);
        return redirect()->route('catalogs.index')
                        ->with('success','catalog created successfully');
    }

    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
        	$title    = "Catalog Management";
        	$catalog  = Catalog::find($id);
            return view('Catalog::edit',compact('title','catalog'));
        }else{
            echo 'Not Access';
            return ;
        }
	}

	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required|unique:catalogs,url,'.$id,
        ]);

        $catalog = Catalog::find($id);
        if(isset($request->public))
        {
        	$catalog->public = 1;
        }else{
        	$catalog->public = 0;
        }
        $catalog->name = $request->name;
        $catalog->url  = $request->url;
        $catalog->description = $request->description;
        $catalog->save();
        return redirect()->route('catalogs.index')
                        ->with('success','catalog updates successfully');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
        	Catalog::find($id)->delete();
            return redirect()->route('catalogs.index')
                        ->with('success','Catalog deleted successfully');
        }else{
            return redirect()->route('catalogs.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

}