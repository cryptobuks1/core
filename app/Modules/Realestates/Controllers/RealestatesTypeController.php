<?php

namespace App\Modules\Realestates\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\RealestatesType;
use Auth;

class RealestatesTypeController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types=RealestatesType::orderBy('form_id','asc')->paginate(20);
        return view('Realestates::type',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Realestates::create_type');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type=new  RealestatesType;
        $type->form_id=$request->form_id;
        $type->slug=str_slug($request->name);
        $type->name=$request->name;
        $type->status=$request->status;
        $type->save();
        return redirect()->route('type.index')->with('success','Thêm thành công');
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
        $type=RealestatesType::find($id);
        return view('Realestates::edit_type',compact('type'));
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
        $type=RealestatesType::find($id);
        $type->form_id=$request->form_id;
        $type->slug=str_slug($request->name);
        $type->name=$request->name;
        if(isset($request->status))
        {
            $type->status = 1;
        }else{
            $type->status = 0;
        }
        $type->save();
        return redirect()->route('type.index')->with('success','Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RealestatesType::destroy($id);
        return back()->with('success','Xóa thành công');
    }

}
