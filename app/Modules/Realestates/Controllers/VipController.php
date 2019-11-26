<?php

namespace App\Modules\Realestates\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\BuyVip;
use Auth;

class VipController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vip=BuyVip::orderBy('level','asc')->paginate(10);
        return view('Realestates::vip',compact('vip'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Realestates::vip_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vip=new  BuyVip();
        $vip->name=$request->name;
        $vip->price=$request->price;
        $vip->day=$request->day;
        $vip->level=$request->level;
        $vip->status=$request->status;
        $vip->save();
        return redirect()->route('vip.index')->with('success','Thêm thành công');
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
        $vip=BuyVip::find($id);
        return view('Realestates::vip_edit',compact('vip'));
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
        $vip=BuyVip::find($id);
        $vip->name=$request->name;
        $vip->day=$request->day;
        $vip->price=$request->price;
        $vip->level=$request->level;
        $vip->status=$request->status;
        $vip->save();
        return redirect()->route('vip.index')->with('success','Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BuyVip::destroy($id);
        return back()->with('success','Xóa thành công');
    }
}
