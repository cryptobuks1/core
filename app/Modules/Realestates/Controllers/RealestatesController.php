<?php

namespace App\Modules\Realestates\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use App\Modules\Paygate\Controllers\PaygateFrontController;
use App\Modules\Realestates\Models\BuyVip;
use App\Modules\Realestates\Models\Cities;
use App\Modules\Realestates\Models\Orders;
use App\Modules\Realestates\Models\Project;
use App\Modules\Realestates\Models\Provinces;
use App\Modules\Realestates\Models\GroupProject;
use App\Modules\Realestates\Models\RealestatesOrderItems;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\RealestatesType;
use App\Modules\Realestates\Models\Realestates;
use App\Modules\Realestates\Models\RealestatesImg;
use Auth;
use Carbon\Carbon;

class RealestatesController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $title='Thống kê tin đăng';
        $data= new Realestates;
        $data=$data->where('module','Realestates');

        $type=RealestatesType::where('form_id',$request->form)->get();

        $vip=BuyVip::where('status',1)->get();

        if ($request->has('form') && $request->form == 1) {
            $data = $data->where('form',1);
        }
        if ($request->has('form') && $request->form == 2) {
            $data = $data->where('form',2);
        }
        foreach ($type as $item){
            if ($request->has('type') && $request->type == $item->name) {
                $data = $data->where('type', $request->type);
            }}

        if($request->has('title') &&  $request->title !== null) {
            $data = $data->where('title', 'LIKE','%'.$request->title.'%');
        }
        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {
            if(Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {
                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }
            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();
            $data = $data->whereBetween('created_at', [$fromdate, $todate]);
        }
        $data = $data->orderBy('id', 'DESC')->paginate(20);
        return view('Realestates::realestates',compact('data','vip','title','type'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Realestates::create_realestates');
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
        $paygates = PaygateFrontController::showpaygate('listPaygatePayFullwidth', 'payment');
        $vip=BuyVip::all();
        $files=RealestatesImg::where('realestates_id',$id)->get();
        $types=RealestatesType::all();
        $data=Realestates::find($id);
        $cities=Cities::all();
        $province=Provinces::where('city_code',$data->city)->get();
        $project=Project::where('province',$data->province)->get();
        $now= Carbon::now();
        $today=Carbon::now()->toDateString();
        $end =Carbon::parse($data->end_date);
        $check=$now->gt($end);
        return view('Realestates::edit_realestates',compact('types','data','cities','province','files','vip','paygates','project','check','today'));
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
        $data=Realestates::find($id);
        $data->title=$request->title;
        $data->slug=str_slug($request->title.'-'.$id);
        $data->form=$request->form;
        $data->module='Realestates';
        $data->type=$request->type;
        $data->city=$request->city;
        $data->province=$request->province;
        $data->commune=$request->commune;
        $data->street=$request->street;
        $data->project=$request->project;
        $data->acreage=$request->acreage;
        $data->price=$request->price;
        $data->address=$request->address;
        $data->description=$request->description;
        $data->facade=$request->facade;
        $data->way_in=$request->way_in;
        $data->direction=$request->direction;
        $data->directio_balcony=$request->directio_balcony;
        $data->floor=$request->floor;
        $data->bedroom=$request->bedroom;
        $data->toilet=$request->toilet;
        $data->furniture=$request->furniture;
        $data->name_contact=$request->name_contact;
        $data->address_contact=$request->address_contact;
        $data->phone_contact=$request->phone_contact;
        $data->email_contact=$request->email_contact;
        $data->pay=$request->pay;
        $data->type_news=$request->type_news;

        $data->start_date=$request->start_date;
        if(isset($request->featured)) {$data->featured = 1;}else{$data->featured = 0;}
        if(isset($request->status))   {$data->status = 1;}else{$data->status = 0;}
        if(isset($request->approved)) {$data->approved = 1;}else{$data->approved = 0;}
        if($request->type_news==7){
            $data->featured=0;
        }
        else{
            $data->featured=1;
        }
        if($request->hasFile('avatar')){
            $avatar=$request->avatar->getClientOriginalName();
            $data->image=$avatar;
            $request->avatar->storeAs('public/avatar',$avatar);
        }
        $data->save();
        if($request->hasFile('images')) {
            foreach($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new RealestatesImg([
                    'realestates_id' => $id,
                    'img' => $filename,
                ]);
                $file->save();
            }
        }
        return redirect()->route('realestates')->with('success','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Realestates::destroy($id);
        return back()->with('success','Xóa thành công.');
    }
    public function deleteImg($id){
        RealestatesImg::destroy($id);
        return back();
    }

    public function order(Request $request){
        $orders= new RealestatesOrderItems;
        $orders=$orders->where('module','Realestates');
        $vip=BuyVip::where('status',1)->where('level','!=',7)->get();

        foreach ($vip as $item){
            if($request->has('vip') && $request->vip==$item->level && $request->vip!=null){
                $orders=$orders->where('vip_level',$request->vip);
            }
        }

        if($request->has('title') &&  $request->title !== null) {
            $orders = $orders->where('realestates_title','LIKE' ,'%'.$request->title.'%');
        }

        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {
            if (Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {
                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }
            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();
            $orders = $orders->whereBetween('updated_at', [$fromdate, $todate]);
        }
        $orders = $orders->orderBy('id', 'DESC')->paginate(20)->appends([
            'vip' => $request->vip,
            'user_id' => $request->user_id,
            'id' => $request->id
        ]);
        return view('Realestates::order',compact('orders','vip'));
    }
    public function delete($id){
        Orders::destroy($id);
        return back();
    }

    public function getAjaxForm2(Request $request)
    {
        $type=RealestatesType::where('form_id',$request->code)->get();
        $html = '';
        $html .= "<option >--Lọc theo loại tin đăng--</option>";
        foreach ($type as $value) {
            $html .= "<option value='".$value['name']."'>".$value['name']."</option>";
        }
        return $html;
    }
}
