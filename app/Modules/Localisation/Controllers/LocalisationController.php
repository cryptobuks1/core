<?php

namespace App\Modules\Localisation\Controllers;
use Illuminate\Http\Request;
use App\Modules\Localisation\Models\Countries;
use App\Modules\Localisation\Models\Cities;
use App\Modules\Localisation\Models\Provinces;
use App\Modules\Backend\Controllers\BackendController;
use App\Modules\Localisation\Requests\RequestCountry;
use App\Modules\Localisation\Requests\RequestCity;
use App\Modules\Localisation\Requests\RequestEditCountry;
use App\Modules\Localisation\Requests\RequestEditCity;


class LocalisationController extends BackendController
{
    public function getAddCountry()
    {
        $data=Countries::all();
        return view('Localisation::addcountry',compact('data'));
    }

    public function postAddCountry(RequestCountry $request)
    {
        $country= new Countries;
        $country->name=$request->name;
        $country->code=$request->code;
        $country->dial_code=$request->dial_code;
        $country->featured=$request->featured;
        $country->sort=$request->sort;
        $country->lang=$request->lang;
        $country->status=$request->status;
        $country->save();
        return redirect()->route('country')
            ->with('success','Thêm quốc gia');
    }

    public function getEditCountry($id){
        $data=Countries::find($id);
        $countries= new Countries;
        return view('Localisation::editcountry',compact('data'));
    }

    public function postEditCountry(RequestEditCountry $request,$id){
        $country=Countries::find($id);
        $country->name=$request->name;
        $country->code=$request->code;
        $country->dial_code=$request->dial_code;
        $country->featured=$request->featured;
        $country->sort=$request->sort;
        $country->lang=$request->lang;
        $country->status=$request->status;
        $country->save();
        return redirect()->route('country')
            ->with('success','Sửa thành quốc gia');
    }

    public  function getDeleteCountry($id){
        Countries::destroy($id);
        return back();
    }


    public function getAddCity()
    {
        $data=Cities::all();
        $countries=Countries::all();
            return view('Localisation::addcity',compact('countries','data') );
    }

    public function postAddCity(RequestCity $request)
    {
        $city= new Cities;
        $city->name_city=$request->name_city;
        $city->code=$request->code;
        $city->country_code=$request->country_code;
        $city->sort=$request->sort;
        $city->featured=$request->featured;
        $city->region=$request->region;
        $city->status=$request->status;
        $city->save();
        return redirect()->route('city')
            ->with('success','Thêm tỉnh/thành phố thành công');
    }

    public function getEditCity($id){
        $coun=Countries::all();
        $data=Cities::find($id);
        return view('Localisation::editcity',compact('data','coun'));
    }

    public function postEditCity(RequestEditCity $request,$id){
        $city=Cities::find($id);
        $city->name_city=$request->name_city;
        $city->code=$request->code;
        $city->country_code=$request->country_code;
        $city->sort=$request->sort;
        $city->featured=$request->featured;
        $city->region=$request->region;
        $city->status=$request->status;
        $city->save();
        return redirect()->route('city');
    }

    public function getDeletCity($id){
        Cities::destroy($id);
        return back();
    }

    public function getAddProvince(){
        $cities=Cities::all();
        $data=Provinces::all();
        return view('Localisation::addprovince',compact('cities','data'));
    }

    public function postAddProvince(Request $request){
        $provience= new Provinces;
        $provience->name=$request->name;
        $provience->type=$request->type;
        $provience->city_code=$request->city_code;
        $provience->sort=$request->sort;
        $provience->featured=$request->featured;
        $provience->status=$request->status;
        $provience->save();
        return redirect()->route('province')
            ->with('success','Thêm quận/huyện thành công');
    }

    public function getEditProvince($id){
        $data = Provinces::find($id);
        $city= Cities::all();
        return view('Localisation::editprovince',compact('data','city'));
    }

    public function postEditProvince(Request $request,$id){
        $provience= Provinces::find($id);
        $provience->name=$request->name;
        $provience->type=$request->type;
        $provience->city_code=$request->city_code;
        $provience->sort=$request->sort;
        $provience->featured=$request->featured;
        $provience->status=$request->status;
        $provience->save();
        return redirect()->route('province');
    }

    public function getDeletProvince($id){
        Provinces::destroy($id);
        return back();
    }

    public function getCity(Request $request)
    {
        $data=Cities::orderBy('id','DESC')->paginate(20);
        $countries=Countries::all();
        if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$data;
            $data = Cities::where('name_city', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(20);
        }
        return view('Localisation::cities',compact('countries','data','title'));
    }

    public function getCountry(Request $request)
    {
        $title    = "Quản lý danh sách các quốc gia";
        $data=Countries::orderBy('id','DESC')->paginate(20);
        if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$data;
            $data = Countries::where('name', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(20);
        }
        return view('Localisation::countries',compact('data','title'));
    }

    public function getProvince(Request $request)
    {
        $title='Danh sách quận huyện';
        $cities=Cities::all();
        $data=Provinces::orderBy('id','DESC')->paginate(20);
        if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$data;
            $data = Provinces::where('name', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(20);
        }
        return view('Localisation::provinces',compact('data','cities','title'));
    }

}

