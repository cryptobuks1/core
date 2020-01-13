<?php

namespace App\Modules\Tours\Controllers;

use App\Modules\Tours\Models\TourTypes;
use App\Modules\Tours\Models\TourServices;
use App\Modules\Tours\Models\TourSchedules;
use App\Modules\Tours\Models\TourPlaces;
use App\Modules\Tours\Models\Tours;
use App\Modules\Tours\Models\Countries;
use App\Modules\Tours\Models\Cities;
use App\Modules\Tours\Models\Provinces;
use App\Modules\Tours\Models\TourDetails;
use App\Modules\Tours\Models\TourImages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Auth;
use DB;
use App\Modules\Currency\Models\Currencies;


class ToursController extends BackendController
{
    //Tour
    public function index(Request $request){
        $countries = Countries::all();
        $types = TourTypes::where('module','Tour')->where('status',1)->get();
        $type_tours = TourTypes::where('module','Tour')->where('status',1)->where('type',$request->type)->get();
        $datas = new Tours();
        $datas = $datas->where('module','Tour');
        if($request->has('keyword') && $request->keyword != null){
            $title='Tìm kiếm: '.$request->keyword;
            $datas=Tours::where('name','LIKE','%'.$request->keyword.'%')->where('module','Tour')->paginate(20);
            return view('Tours::tour_index',compact('datas','countries','types','type_tours','title'));
        }
        if($request->has('type') && $request->type !=null){
            $datas = $datas->where('type',$request->type);
        }
        if($request->has('type_tour') && $request->type_tour !=null){
            foreach ($types as $item){
                if($request->type_tour == $item->id){
                    $datas = $datas->where('type_tour',$request->type_tour);
                }
            }
        }
        $datas = $datas->orderBy('id','DESC')->paginate(20);
        return view('Tours::tour_index',compact('datas','countries','types','type_tours'));
    }

    public function create(){
        $countries = Countries::all();
        $services = TourServices::where('status',1)->where('module','Tour')->get();
        return view('Tours::tour_create',compact('datas','countries','services','currencies'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'type' => 'required',
            'type_tour' => 'required',
            'name' => 'required',
            'note' => 'required',
            'avatar' => 'required',
        ]);
        $user_id = Auth::user()->id;
        $code = strtoupper('TOUR-'.uniqid());
        $data = new Tours();
        $data->name = $request->name;
        $data->user_id = $user_id;
        $data->code = $code;
        $data->countries = $request->countries;
        $data->type = $request->type;
        $data->type_tour = $request->type_tour;
        $data->service = $request->service;
        $data->description = $request->description;
        $data->note = $request->note;
        if($request->hasFile('image')){
            $imagelink = explode('storage',$request->image);
            $data->avatar = '/storage'.$imagelink[1];
        }

        $data->sku = $code.'-'.str_slug($request->name);
        $data->save();
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new TourImages([
                    'tour_id' => $data->id,
                    'name' => $filename
                ]);
                $file->save();
            }
        }
        return redirect()->route('tour.index')->with('success','Tạo TOUR thành công');
    }

    public function edit($id){
        $countries = Countries::all();
        $services = TourServices::where('status',1)->where('module','Tour')->get();
        $tour = Tours::find($id);
        $files = TourImages::where('tour_id',$id)->get();
        $types = TourTypes::where('type',$tour->type)->where('status',1)->get();
        return view('Tours::tour_edit',compact('tour','countries','services','types','files'));
    }

    public function update($id,Request $request){
        $this->validate($request, [
            'type' => 'required',
            'type_tour' => 'required',
            'name' => 'required',
            'note' => 'required',
            'avatar' => 'required',
        ]);
        $data = Tours::find($id);
        $data->name = $request->name;
        $data->sku = $data->code.'-'.str_slug($data->name);
        $data->countries = $request->countries;
        $data->type = $request->type;
        $data->type_tour = $request->type_tour;
        $data->service = $request->service;
        $data->description = $request->description;
        $data->note = $request->note;
        if( $request->hasFile('image')){
            $imagelink = explode('storage',$request->image);
            $data->avatar = '/storage'.$imagelink[1];
        }
        $data->save();
        if($request->images != null) {
            foreach ($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new TourImages([
                    'tour_id' => $id,
                    'name' => $filename
                ]);
                $file->save();
            }
        }
        return redirect()->route('tour.index')->with('success','Cập nhật TOUR thành công');
    }

    public function destroy($id){
        Tours::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    //delete file ảnh tour
    public function destroyImage($id){
        TourImages::destroy($id);
        return back()->with('success','Xóa thành công');
    }
    //Detail
    public function detailsList($id, Request $request){
        $tour = Tours::find($id);
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        $datas = new TourDetails();
        $datas = $datas->where('tour_id',$id)->where('module','Tour');
        if ($request->has('start_day') && $request->has('end_day') && $request->start_day !== null && $request->end_day !== null) {
            if(Carbon::parse($request->start_day)->gt(Carbon::parse($request->end_day))) {
                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }
            $start = Carbon::parse($request->start_day)->startOfDay();
            $end = Carbon::parse($request->end_day)->endOfDay();

            $datas = $datas->whereBetween('start_day', [$start, $end]);
        }

        $datas = $datas->orderBy('start_day','ASC')->paginate(10);
        return view('Tours::details_index',compact('datas','tour','currencies'));
    }

    public function detailCreate($id){
        $tour = Tours::find($id);
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return view('Tours::detail_create',compact('tour','currencies'));
    }

    public function detailStore($id,Request $request){
        $this->validate($request, [
            'start_day' => 'required',
            'end_day' => 'required',
            'converge_time' => 'required',
            'converge_place' => 'required',
            'total' => 'required',
        ]);
        if(Carbon::parse($request->start_day)->gt(Carbon::parse($request->end_day))) {
            return redirect()->back()->withErrors(['error' => 'Thời gian ngày đi phải nhỏ hơn thời gian ngày về']);
        }
        if(Carbon::parse($request->converge_time)->gt(Carbon::parse($request->start_day))) {
            return redirect()->back()->withErrors(['error' => 'Thời gian tập trung phải nhỏ hơn thời gian ngày đi']);
        }
        $input = $request->all();
        $input['start_day'] = Carbon::parse($request->start_day)->toDateTimeString();
        $input['end_day'] = Carbon::parse($request->end_day)->toDateTimeString();
        $input['converge_time'] = Carbon::parse($request->converge_time)->toDateTimeString();
        $dt = Carbon::parse($request->start_day)->diffInDays(Carbon::parse($request->end_day))+1;
        $input['days'] = $dt;
        $input['month'] = Carbon::parse($request->start_day)->month;
        $input['tour_id'] = $id;
        TourDetails::create($input);
        return redirect()->route('tour.index')->with('success','Add thành công');
    }

    public function detailsEdit($id){
        $data = TourDetails::find($id);

        $tour = Tours::find($data->tour_id);
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return view('Tours::detail_edit',compact('data','currencies','tour'));
    }

    public function detailsUpdate($id, Request $request){
        $this->validate($request, [
            'start_day' => 'required',
            'end_day' => 'required',
            'converge_time' => 'required',
            'converge_place' => 'required',
            'total' => 'required',
        ]);
        if(Carbon::parse($request->start_day)->gt(Carbon::parse($request->end_day))) {
            return redirect()->back()->withErrors(['error' => 'Thời gian ngày đi phải nhỏ hơn thời gian ngày về']);
        }
        if(Carbon::parse($request->converge_time)->gt(Carbon::parse($request->start_day))) {
            return redirect()->back()->withErrors(['error' => 'Thời gian tập trung phải nhỏ hơn thời gian ngày đi']);
        }
        $data = TourDetails::find($id);
        $data->start_day = Carbon::parse($request->start_day)->toDateTimeString();
        $data->end_day = Carbon::parse($request->end_day)->toDateTimeString();
        $data->converge_time = Carbon::parse($request->converge_time)->toDateTimeString();
        $data->hotel = $request->hotel;
        $data->month = Carbon::parse($request->start_day)->month;
        $data->ticket_start = $request->ticket_start;
        $data->ticket_end = $request->ticket_end;
        $data->tour_guide = $request->tour_guide;
        $data->converge_place = $request->converge_place;
        $data->total = $request->total;
        $data->start_place = $request->start_place;
        $data->price = $request->price;
        $data->fees = $request->fees;
        $data->price_land = $request->price_land;
        $data->fees_land = $request->fees_land;
        $data->discount = $request->discount;
        $dt=Carbon::parse($request->start_day)->diffInDays(Carbon::parse($request->end_day))+1;
        $data->days = $dt;

        $data->save();
        return back()->with('success','Cập nhật thành công');
    }

    public function detailsDelete($id){
        TourDetails::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    //Schedules
    public function schedulesIndex($id){
        $datas = TourSchedules::where('module','Tour')->where('tour_id',$id)->orderBy('sort','ASC')->paginate(20);
        $tour = Tours::find($id);
        return view('Tours::schedules_index',compact('datas','tour'));
    }

    public function schedulesCreate($id){
        $tour = Tours::find($id);
        return view('Tours::schedules_create',compact('datas','tour'));
    }

    public function schedulesStore($id, Request $request){
        $input = $request->all();
        $input['tour_id'] = $id;
        TourSchedules::create($input);
        return back()->with('success','Thêm thành công');
    }

    public function schedulesDelete($id){
        TourSchedules::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    public function schedulesEdit($id){
        $data = TourSchedules::find($id);
        return view('Tours::schedules_edit',compact('data'));
    }

    public function schedulesUpdate($id,Request $request){
        $this->validate($request, [
            'sort' => 'required',
            'place' => 'required',
            'description' => 'required',
        ]);
        $data = TourSchedules::find($id);
        $data->sort = $request->sort;
        $data->place = $request->place;
        $data->description = $request->description;
        if(isset($request->status))
        {
            $data->status = 1;
        }else{
            $data->status = 0;
        }
        $data->save();
        return back()->with('success','Cập nhật thành công');
    }

    //Tour Types
    public function indexType(){
        $types = TourTypes::where('module','Tour')->paginate(20);
        return view('Tours::type_index',compact('types'));
    }

    public function createType(){
        return view('Tours::type_create');
    }

    public function storeType(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);
        $input = $request->all();
        $input['sku'] = str_slug($request->name);
        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;
        TourTypes::create($input);
        return redirect()->route('tour.type.index')->with('success','Tạo TOUR thành công');
    }

    public function editType($id){
        $type = TourTypes::find($id);
        return view('Tours::type_edit',compact('type'));
    }

    public function updateType( Request $request ,$id){
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);
        $type = TourTypes::find($id);
        $type->type = $request->type;
        $type->name = $request->name;
        $type->sku = str_slug($request->name);
        if(isset($request->status))
        {
            $type->status = 1;
        }else{
            $type->status = 0;
        }
        $type->save();
        return redirect()->route('tour.type.index')->with('success','Cập nhật thành công');
    }

    public function destroyType($id){
        TourTypes::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    //Tour Services
    public function indexService(){
        $datas = TourServices::orderBy('type','DESC')->paginate(20);
        return view('Tours::service_index',compact('datas'));
    }

    public function createService(){
        return view('Tours::service_create');
    }

    public function storeService(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);
        $input = $request->all();
        if($request->type == 'flight'){
            $input['module'] = 'Flight';
        }
        elseif($request->type == 'tour'){
            $input['module'] = 'Tour';
        }
        elseif($request->type == 'hotel'){
            $input['module'] = 'Hotel';
        }
        $input['sku'] = str_slug($request->name);
        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;
        TourServices::create($input);
        return redirect()->route('tour.service.index')->with('success','Thêm dịch vụ thành công');
    }

    public function editService($id){
        $data = TourServices::find($id);
        return view('Tours::service_edit',compact('data'));
    }

    public function updateService(Request $request,$id){
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);

        $data = TourServices::find($id);
        if($request->type == 'flight'){
            $data->module = 'Flight';
        }
        elseif($request->type == 'tour'){
            $data->module  = 'Tour';
        }
        elseif($request->type == 'hotel'){
            $data->module  = 'Hotel';
        }
        $data->name = $request->name;
        $data->type = $request->type;
        if($request->type == 'hotel'){
            $data->type_services = $request->type_services;
        }
        $data->sku = str_slug($request->name);
        if(isset($request->status))
        {
            $data->status = 1;
        }else{
            $data->status = 0;
        }
        $data->save();
        return redirect()->route('tour.service.index')->with('success','Cập nhật thành công');

    }

    public function destroyService($id){
        TourServices::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    //Tour Places
    public function indexPlace(){
        $places = TourPlaces::where('module','Places.Tour')->get();
        $countries = Countries::all();
        $cities = Cities::all();
        $provinces = Provinces::all();
        $types = TourTypes::where('module','Tour')->get();
        return view('Tours::places_index',compact('places','countries','cities','types'));
    }

    public function createPlace(){
        $countries = Countries::all();
        $provinces = Provinces::all();
        $cities = Cities::where('country_code','VN')->get();
        $type = TourTypes::where('module','Tour')->get();
        return view('Tours::place_create',compact('countries','provinces','cities','provinces','type'));
    }

    public function storePlace(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'type_tour' => 'required',
            'city' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        $place=new TourPlaces();
        $place->name = $request->name;
        $place->sku = str_slug($request->name);
        $place->type = $request->type;
        $place->type_tour = $request->type_tour;
        $place->country = $request->country;
        $place->city = $request->city;
        $place->province = $request->province;
        $place->short_description = $request->short_description;
        $place->description = $request->description;
        if(isset($request->status))
        {
            $place->status = 1;
        }else{
            $place->status = 0;
        }
        if($request->has('image')){

            $imagelink = explode('storage',$request->image);
            $place->avatar = '/storage'.$imagelink[1];
        }
        $place->save();
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new TourImages([
                    'tour_id' => $place->id,
                    'module' => 'Places.Tour',
                    'name' => $filename
                ]);
                $file->save();
            }
        }
        return redirect()->route('tour.place.index')->with('success','Thêm địa điểm du lịch thành công');
    }

    public function editPlace($id){
        $place = TourPlaces::find($id);
        $countries = Countries::orderBy('name','ASC')->get();
        $provinces = Provinces::where('city_code',$place->city)->orderBy('name','ASC')->get();
        $cities = Cities::where('country_code',$place->country)->orderBy('name_city','ASC')->get();
        $type = TourTypes::where('module','Tour')->where('type',$place->type)->get();
        $files = TourImages::where('module','Places.Tour')->where('tour_id',$id)->get();
        return view('Tours::place_edit',compact('countries','provinces','cities','provinces','type','place','files'));
    }

    public function updatePlace($id, Request $request){
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'type_tour' => 'required',
            'city' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        $place = TourPlaces::find($id);
        $place->name = $request->name;
        $place->sku = str_slug($request->name);
        $place->type = $request->type;
        $place->type_tour = $request->type_tour;
        $place->country = $request->country;
        $place->city = $request->city;
        $place->province = $request->province;
        $place->short_description = $request->short_description;
        $place->description = $request->description;
        if(isset($request->status))
        {
            $place->status = 1;
        }else{
            $place->status = 0;
        }
        if($request->image != null){
            $imagelink = explode('storage',$request->image);
            $place->avatar = '/storage'.$imagelink[1];
        }
        $place->save();
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new TourImages([
                    'tour_id' => $place->id,
                    'module' => 'Places.Tour',
                    'name' => $filename
                ]);
                $file->save();
            }
        }
        return redirect()->route('tour.place.index')->with('success','Cập nhật thành công');
    }

    public function destroyPlace($id){
        TourPlaces::destroy($id);
        return back()->with('success','Xóa thành công');
    }
    //delete file ảnh place
    public function destroyImagePlace($id){
        TourImages::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    //ajax
    public function ajaxTourType(Request $request){
        if($request->has('code')){
            $types = TourTypes::where('type',$request->code)->get();
            $html = '';
            $html .= "<option valude=''>--Nhấp chọn loại tour--</option>";
            foreach ($types as $value) {
                $html .= "<option value='".$value['id']."'>".$value['name']."</option>";
            }
            return $html;
        }
    }
    public function ajaxCountries(Request $request){
        if($request->has('code')){
            $cities = Cities::where('country_code',$request->code)->get();
            $html = '';
            $html .= "<option >-- Chọn tỉnh/thành phố --</option>";
            foreach ($cities as $value) {
                $html .= "<option value='".$value['code']."'>".$value['name_city']."</option>";
            }
            return $html;
        }
    }
    public function ajaxDeleteImages(Request $request){
        if($request->has('code')){
            TourImages::destroy($request->code);
            return response()->json(['success','Xóa thành công']);
        }
    }

}
