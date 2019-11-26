<?php

namespace App\Modules\tiki\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Modules\tiki\Models\Category;
use Auth;

class CategoryController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate=Category::all();
        return  view('tiki::category',compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tiki::category_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $cate=new Category;
        $cate->name=$request->name;
        $cate->url_key=str_slug($request->name);
        $cate->status=$request->status;
        $cate->description=$request->description;
        $cate->save();
        return redirect()->route('tiki.category')->with('success','Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate=Category::find($id);
        return  view('tiki::category_edit',compact('cate'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $cate=Category::find($id);
        $cate->name=$request->name;
        $cate->url_key=str_slug($request->name);
        $cate->status=$request->status;
        $cate->description=$request->description;
        $cate->save();
        return redirect()->route('tiki.category')->with('success','Sửa thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Category::destroy($id);
      return back()->with('success','Xóa thành công');

    }

}
