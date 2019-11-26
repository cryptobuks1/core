<?php

namespace App\Modules\tiki\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Modules\tiki\Models\Product;
use App\Modules\tiki\Models\Category;
use Auth;

class ProductController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Product::all();
        $cate=Category::all();
        return view('tiki::product',compact('data','cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate=Category::all();
        return view('tiki::product_create',compact('cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data= new Product;
        $user_id=Auth::user()->id;
        $data->user_id=$user_id;
        dd(123);
        $data->name=$request->name;
        $data->cat_id=$request->cat_id;
        $data->product_slug=str_slug($request->name);
        $data->description=$request->description;
        $data->short_description=$request->short_description;
        $data->inputprice=$request->inputprice;
        $data->price=$request->price;
        $data->special_price=$request->special_price;
        $data->product_branded=$request->product_branded;
        $data->status=$request->status;
        $data->approved=$request->approved;
        $data->hotdeal=$request->hotdeal;
        if($request->hasFile('image')){
            $fileimage=$request->image->getClientOriginalName();
            $data->image=$fileimage;
            $request->image->storeAs('public/avatar',$fileimage);
        }
        dd($fileimage);
        $data->save();
        return  redirect()->route('tiki.product')->with('success','Thêm sản phẩm thành công');
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
        $files=RealestatesImg::where('realestates_id',$id)->get();
        $types=RealestatesType::all();
        $data=Realestates::find($id);
        $cities=Cities::all();
        $province=Provinces::all();
        return view('Product::edit_realestates',compact('types','data','cities','province','files'));
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
        $data->type_news=$request->type_news;
        $data->start_date=$request->start_date;
        $data->end_date=$request->end_date;
        $data->approved=$request->approved;
        $data->featured=$request->featured;
        $data->status=$request->status;
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

}
