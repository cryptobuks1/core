<?php

namespace App\Modules\Realestates\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use App\Modules\tiki\Models\Product;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\BuyVip;
use App\Modules\Realestates\Models\GroupProject;
use Auth;

class GroupProjectController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $data=GroupProject::orderBy('code','asc')->paginate(10);
        if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $data = GroupProject::where('name', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(10);
        }
        return view('Realestates::group',compact('data','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Realestates::group_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=new  GroupProject();
        $data->name=$request->name;
        $data->slug=str_slug($request->name);
        $data->code=$request->code;
        $data->status=$request->status;
        $data->save();
        return redirect()->route('group.index')->with('success','Thêm thành công');
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
        $data=GroupProject::find($id);
        return view('Realestates::group_edit',compact('data'));
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
        $data=GroupProject::find($id);
        $data->name=$request->name;
        $data->slug=str_slug($request->name);
        $data->code=$request->code;
        $data->status=$request->status;
        $data->save();
        return redirect()->route('group.index')->with('success','Thêm thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GroupProject::destroy($id);
        return back()->with('success','Xóa thành công');
    }

}
