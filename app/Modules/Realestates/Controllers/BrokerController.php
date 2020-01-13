<?php

namespace App\Modules\Realestates\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use App\Modules\Group\Models\Group;
use App\Modules\Realestates\Models\Provinces;
use App\Modules\Realestates\Models\RealestatesImg;
use App\Modules\Realestates\Models\RealestatesType;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\Project;
use App\Modules\Realestates\Models\GroupProject;
use App\Modules\Realestates\Models\Cities;
use App\Modules\Realestates\Models\Broker;
use Auth;

class BrokerController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brokers= Broker::where('module','Realestates')->orderBy('id','DESC')->paginate(20);
        $types=RealestatesType::all();
        return view('Realestates::broker',compact('brokers','types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $broker= Broker::find($id);
        $cities=Cities::all();
        $province= Provinces::where('city_code',$broker->city)->get();
        $types=RealestatesType::orderBy('form_id','desc')->get();
        return view('Realestates::broker_edit',compact('broker','types','cities','province'));
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
        $this->validate($request, [
            'name'     => 'required',
            'address'  => 'required',
            'phone'    => 'required|min:10',
            'email'    => 'email|required',
            'fields'   => 'required',
            'city'     => 'required',
            'province' => 'required',
            'type'    => 'required',
        ]);

        $user_id= Auth::user()->id;
        $broker= Broker::find($id);
        $broker->name=$request->name;
        $broker->slug= str_slug($request->name);
        $broker->address= $request->address;
        $broker->type= $request->type;
        $broker->city= $request->city;
        $broker->province= $request->province;
        $broker->phone= $request->phone;
        $broker->email= $request->email;
        $broker->website= $request->website;
        $broker->fields= $request->fields;
        $broker->introduce= $request->introduce;
        $broker->introduce_show= $request->introduce_show;
        $broker->module= 'Realestates';
        $broker->status= $request->status;
        $broker->featured= $request->featured;
        if($request->hasFile('image')){
            $avatar=$request->image->getClientOriginalName();
            $broker->image=$avatar;
            $request->image->storeAs('public/avatar',$avatar);
        }
        $broker->save();
        $update=Auth::user()->where('id',$user_id)->update(['broker'=>$request->type]);
        return redirect()->route('broker.index')->with('success','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $broker=Broker::find($id);
        Broker::destroy($id);
        $update=Auth::user()->where('id',$broker->user_id)->update(['broker'=>0]);
        return back()->with('success','Xóa thành công');
    }



}
