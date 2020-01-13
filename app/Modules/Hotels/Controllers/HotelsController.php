<?php

namespace App\Modules\Hotels\Controllers;

use App\Modules\Hotels\Models\Countries;
use App\Modules\Hotels\Models\Cities;
use App\Modules\Hotels\Models\Hotels;
use App\Modules\Hotels\Models\Provinces;
use App\Modules\Hotels\Models\TourImages;
use App\Modules\Hotels\Models\TourServices;
use App\Modules\Hotels\Models\HotelRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Auth;
use DB;
use \App\User;
use App\Modules\Currency\Models\Currencies;
use function GuzzleHttp\Psr7\str;


class HotelsController extends BackendController
{
    public function index($hotel_id){
        $hotel= Hotels::find($hotel_id);
        $rooms = HotelRoom::where('module','Hotel')->where('hotel_id',$hotel_id)->orderBy('id','DESC')->paginate(20);
        $cities = Cities::all();
        $provinces = Provinces::all();
        return view('Hotels::room_index',compact('rooms','provinces','cities','hotel'));
    }

    public function create($hotel_id){
        $services = TourServices::where('type','hotel')->get();
        $countries = Countries::all();
        $provinces = Provinces::all();
        $cities = Cities::where('country_code','VN')->get();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return view('Hotels::room_create',compact('services','countries','currencies','cities','provinces','hotel_id','tags'));
    }

    public function store($hotel_id,Request $request){
        $this->validate($request, [
            'name' => 'required',
            'image'=>'required',
            'description'=>'required',
            'short_description'=>'required',
        ]);

            $user_id = Auth::user()->id;
            $room = new HotelRoom();
            $room->name = $request->name;
            $room->module = 'Hotel';
            $room->user_id = $user_id;
            $room->hotel_id = $hotel_id;
            $room->short_description = $request->short_description;
            $room->description = $request->description;
            $room->price = $request->price;
            $room->fees = $request->fees;
            $room->service = $request->service;
            $room->room = $request->room;
            $room->discount = $request->discount;
            if (isset($request->status)) {
                $room->status = 1;
            } else {
                $room->status = 0;
            }
            if ($request->has('image') && $request->image != null) {
                $imagelink = explode('storage', $request->image);
                $room->avatar = '/storage' . $imagelink[1];
            }
            $room->save();
            $code = strtoupper('ROOM-' . $room->id);
            $room->sku = $code . '-' . str_slug($request->name);
            $room->code = $code;
            $room->save();
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $filename = $file->getClientOriginalName();
                    $path = $file->storeAs('public/avatar', $filename);
                    $file = new TourImages([
                        'tour_id' => $room->id,
                        'name' => $filename,
                        'module' => 'R.Hotel'
                    ]);
                    $file->save();
                }
            }

            return redirect()->route('room.index', compact('hotel_id'))->with('success', 'Thêm thành công');


    }

    public function edit($id){
        $room=HotelRoom::find($id);
        $services = TourServices::where('type','hotel')->get();
        $countries = Countries::all();
        $provinces = Provinces::where('city_code',$room->cities)->get();
        $cities = Cities::where('country_code','VN')->get();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        $files=TourImages::where('module','R.Hotel')->where('tour_id',$id)->get();

        return view('Hotels::room_edit',compact('services','countries','currencies','cities','provinces','room','files'));
    }

    public function update($id, Request $request){
        $this->validate($request, [
            'name' => 'required',
            'description'=>'required',
            'short_description'=>'required',
        ]);
        $room = HotelRoom::find($id);
        $room->name = $request->name;
        $room->module = 'Hotel';
        $room->short_description = $request->short_description;
        $room->description = $request->description;
        $room->price = $request->price;
        $room->fees = $request->fees;
        $room->service = $request->service;
        $room->room = $request->room;
        $room->discount = $request->discount;
        if(isset($request->status)) {$room->status = 1;}else{$room->status = 0;}
        if($request->has('image') && $request->image != null){
            $imagelink = explode('storage',$request->image);
            $room->avatar = '/storage'.$imagelink[1];
        }
        $room->sku = $room->code.'-'.str_slug($request->name);
        $room->save();
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new TourImages([
                    'tour_id' => $room->id,
                    'name' => $filename,
                    'module' => 'R.Hotel'
                ]);
                $file->save();
            }
        }
        $hotel_id=$room->hotel_id;
        return redirect()->route('room.index',compact('hotel_id'))->with('success','Cập nhật thành công');
    }
    public function delete($id){
        HotelRoom::destroy($id);
        return back()->with('success','Xóa thành công');
    }
    public function indexHotel(Request $request){
        $hotels = new Hotels();
        $hotels = $hotels->where('module','Hotel');
        $cities = Cities::where('country_code','VN')->get();
        $provinces = Provinces::all();
        $province = Provinces::where('city_code', $request->city)->get();
        if($request->has('keyword') && $request->keyword != null){

            $title='Tìm kiếm: '.$request->keyword;
            $hotels = Hotels::where('name','LIKE','%'.$request->keyword.'%')->where('module','Hotel')->orderBy('id','DESC')->paginate(20);
            return view('Hotels::hotel_index',compact('hotels','provinces','cities','title','province'));
        }
        if($request->has('city') && $request->city != null){
            foreach ($cities as $item){
                if($item->code == $request->city){
                    $hotels = $hotels->where('city',$item->code);
                }
            }
        }
        if($request->has('province') && $request->province != null){
            foreach ($province as $item){
                if( $item->name == $request->province){
                    $hotels = $hotels->where('province',$request->province);
                }
            }
        }
        $hotels = $hotels->orderBy('id','DESC')->paginate(20);
        return view('Hotels::hotel_index',compact('hotels','provinces','cities','province'));
    }
    public function createHotel(){
        $tags = app('App\Modules\Tags\Models\Tagslist')->get(array('id','code','label'));
        $provinces = Provinces::all();
        $cities = Cities::where('country_code','VN')->get();
        return view('Hotels::hotel_create',compact('cities','provinces','tags'));
    }
    public function storeHotel(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'city' => 'required',
            'province' => 'required',
            'address' => 'required',
            'image' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user_id = Auth::user()->id;
            $hotel= new Hotels();
            $hotel->name = $request->name;
            $hotel->module = 'Hotel';
            $hotel->user_id = $user_id;
            $hotel->city = $request->city;
            $hotel->province = $request->province;
            $hotel->address = $request->address;
            $hotel->description = $request->description;
            $hotel->short_description = $request->short_description ;
            if(isset($request->status)) {$hotel->status = 1;}else{$hotel->status = 0;}
            if(isset($request->featured)) {$hotel->featured = 1;}else{$hotel->featured = 0;}
            if($request->has('image') && $request->image != null){
                $imagelink = explode('storage',$request->image);
                $hotel->image = '/storage'.$imagelink[1];
            }
            $hotel->save();
            $code = strtoupper('HOTEL-'.$hotel->id);
            $hotel->sku = $code.'-'.str_slug($hotel->name);
            $hotel->code = $code;
            $hotel->save();
            if($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $filename = $file->getClientOriginalName();
                    $path = $file->storeAs('public/avatar', $filename);
                    $file = new TourImages([
                        'tour_id' => $hotel->id,
                        'name' => $filename,
                        'module' => 'Hotel'
                    ]);
                    $file->save();
                }
            }
            /** save news tags **/
            $new_tags = array();
            if (isset($request->tags))
                $new_tags = $request->tags;
            if ($request->new_tags && $request->new_tags != '') {
                $new_tags_ids = \App\Modules\Tags\Controllers\TagslistController::createNewTags($request->new_tags, 'Hotel', 'Hotel', $hotel->id);
                $new_tags = array_merge($new_tags, $new_tags_ids);

            }
            if (count($new_tags) > 0) {

                \App\Modules\Tags\Controllers\TagslistController::addTag($new_tags, 'Hotel', 'Hotel', $hotel->id);

            }
            /** end save news tags **/
            DB::commit();
            return redirect()->route('hotel.index')->with('success','Thêm thành công');
        }
        catch (\Exception $e){
            DB::rollback();
            return redirect()->route('hotel.index')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function editHotel($id){
        $hotel = Hotels::find($id);
        $provinces = Provinces::where('city_code',$hotel->city)->get();
        $cities = Cities::where('country_code','VN')->get();
        $files = TourImages::where('module','Hotel')->where('tour_id',$hotel->id)->get();
        $tags = app('App\Modules\Tags\Models\Tagslist')->select('id','code','label')->limit(20)->get();
        $selected_tags = app('App\Modules\Tags\Models\Tagslist')->where('model_id',$id)
            ->where('module','Hotel')
            ->groupBy('id')
            ->pluck('id')
            ->toArray();
        return view('Hotels::hotel_edit',compact('cities','provinces','hotel','files','tags','selected_tags'));
    }
    public function updateHotel($id, Request $request){
        $this->validate($request, [
            'name' => 'required',
            'city' => 'required',
            'province' => 'required',
            'address' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);
        $hotel=Hotels::find($id);
        $hotel->name = $request->name;
        $hotel->module = 'Hotel';
        $hotel->city = $request->city;
        $hotel->province = $request->province;
        $hotel->address = $request->address;
        $hotel->description = $request->description;
        $hotel->short_description = $request->short_description ;
        if(isset($request->status)) {$hotel->status = 1;}else{$hotel->status = 0;}
        if(isset($request->featured)) {$hotel->featured = 1;}else{$hotel->featured = 0;}
        if($request->has('image') && $request->image != null){
            $imagelink = explode('storage',$request->image);
            $hotel->image = '/storage'.$imagelink[1];
        }
        $hotel->save();
        $hotel->sku = $hotel->code.'-'.str_slug($hotel->name);
        $hotel->save();
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new TourImages([
                    'tour_id' => $id,
                    'name' => $filename,
                    'module' => 'Hotel'
                ]);
                $file->save();
            }
        }
        /** save news tags **/
        $new_tags = array();
        $delete_tags = array();
        $module_type = 'Hotel';
        $selected_tags = \App\Modules\Tags\Models\Tagslist::where('model_id',$id)
            ->where('module',$module_type)
            ->groupBy('id')
            ->pluck('id')
            ->toArray();

        if(count($selected_tags)>0){
            if($request->tags && count($request->tags)>0){
                $delete_tags = array_diff($selected_tags, $request->tags);
                $new_tags = array_diff($request->tags,$selected_tags);
            }else{
                $delete_tags = $request->tags;
            }
        }else{
            if($request->tags){
                $new_tags = $request->tags;
            }

        }


        if($request->new_tags && $request->new_tags!=''){
            $new_tags_ids= \App\Modules\Tags\Controllers\TagslistController::createNewTags($request->new_tags, 'Hotel', 'Hotel', $id);
            $new_tags = array_merge($new_tags,$new_tags_ids);
        }

        if($delete_tags && count($delete_tags)>0){
            foreach ($delete_tags as $tagId) {
                \App\Modules\Tags\Controllers\TagslistController::deleteTagItems($tagId);
            }
        }

        //// Add tag vào bài viết
        if($new_tags && count($new_tags)>0){
            \App\Modules\Tags\Controllers\TagslistController::addTag($new_tags,'Hotel','Hotel', $id);
        }

        return redirect()->route('hotel.index')->with('success','Cập nhật thành công');
    }
    public function deleteHotel($id){
        Hotels::destroy($id);
        return back()->with('success','Xóa thành công');
    }
}
