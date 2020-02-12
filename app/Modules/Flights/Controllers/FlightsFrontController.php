<?php

namespace App\Modules\Flights\Controllers;

use App\Modules\Currency\Models\Currencies;
use App\Modules\Flights\Models\Countries;
use App\Modules\Flights\Models\Cities;
use App\Modules\Flights\Models\FlightAirlines;
use App\Modules\Flights\Models\FlightStations;
use App\Modules\Flights\Models\FlightRoutes;
use App\Modules\Flights\Models\Flights;
use App\Modules\Flights\Models\Services;
use App\Modules\Flights\Models\FlightOrders;
use App\Modules\Flights\Helpers\FlightHelper;
use App\Modules\News\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Modules\Frontend\Controllers\FrontendController;
use Illuminate\Support\Collection;
use Auth;
use DB;
use Cache;
use App\User;
use Response;


class FlightsFrontController extends FrontendController
{
    public function search(){
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        $airline    = FlightAirlines::where('module','Flight')->where('status',1)->orderBy('name','ASC')->get();
        $services   = Services::where('module','Flight')->where('status',1)->get();
        return theme_view('flight.search',compact('airline','currencies','services'));
    }
    public function search3(){
        $date                  = Carbon::now()->addDays(7)->toDateString();
        $DepartDate            = \DateTime::createFromFormat('Y-m-d',$date);
        $Dep_Date              = $DepartDate->format('d-m-Y');
        $DateDeparture         = $DepartDate->format('d/m/Y');
        $type                  = 'EV-ND';

        $input = array();
        $input['StartPoint'] = 'HAN';
        $input['EndPoint'] = 'SGN';
        $input['DepartDate'] = $DateDeparture;
        $input['DepartDate2'] = '';
        $input['type'] = 0;
        $input['Adt'] = 1;
        $input['Chd'] = 0;
        $input['Inf'] = 0;
        $flight_data = FlightHelper::ApiEnViet($input);


        if($flight_data != null){
            $convert = FlightHelper::convertData($flight_data,$type, $StartPoint = 'HAN', $EndPoin = 'SGN' , $Dep_Date, $Arr_Date = '');
            $datas = collect($convert)->sortBy('SumPrice');
        }
        else{
            $datas   = [];
        }
        $news        = News::where('status',1)->orderBy('publish_date','DESC')->limit(4)->get();
        $stations    =  FlightStations::where('status',1)->get();
        $currencies  = Currencies::where('fiat', 1)->where('status',1)->get();
        $airline     = FlightAirlines::where('module','Flight')->where('status',1)->orderBy('name','ASC')->get();
        $services    = Services::where('module','Flight')->where('status',1)->get();
        return theme_view('flight.search3',compact('airline','currencies','services','datas','stations','airline','news'));
    }
    public function search2(){
        $currencies  = Currencies::where('fiat', 1)->where('status',1)->get();
        $stations    = FlightStations::where('status',1)->where('featured',1)->get();
        $airline     = FlightAirlines::where('module','Flight')->where('status',1)->orderBy('name','ASC')->get();
        $services    = Services::where('module','Flight')->where('status',1)->get();
        return theme_view('flight.search2',compact('airline','currencies','services','stations'));
    }



    public function ajaxDeparture(Request $request)
    {
        $input = $request->get('searchTerm');
        return FlightHelper::Departure($input);
    }
    public function ajaxArrival2(Request $request){
        $stations = FlightStations::where('status',1)->where('featured',1)->where('code','!=',$request->code)->get();
        if($stations){
            $html = '';
            $html .= "<option >Điểm đến</option>";
            foreach ($stations as $value) {
                $html .= "<option  value='" . $value['code'] . "') >" . $value['city_vi'].' ('.$value['name'].')' . "</option>";
            }
            return $html;
        }
    }
    //danh sách tìm
    public function list(Request $request){
        if($request->type == 0){
            $this->validate($request, [
                'StartPoint' => 'required',
                'EndPoint'   => 'required',
                'DepartDate' => 'required',
                'Adt'        => 'required|min:1',
                'Chd'        => 'min:0',
                'Inf'        => 'min:0',
            ],
                $messages = [
                    'StartPoint.required' => 'Bạn cần chọn điểm khởi hành!',
                    'EndPoint.required'   => 'Bạn cần chọn điểm đến!',
                    'DepartDate.required' => 'Bạn cần chọn ngày về!',
                    'Adt.required'        => 'Bạn cần nhập số người lớn!',
                    'Inf.min'             => 'Số em bé phải là số dương!',
                    'Inf.Chd'             => 'Số trẻ em phải là số dương!',
                    'Adt.min'             => 'Số người lớn phải lớn hơn 1!',
                ]);
        }
        else{
            $this->validate($request, [
                'StartPoint'  => 'required',
                'EndPoint'    => 'required',
                'DepartDate'  => 'required',
                'DepartDate2' => 'required',
                'Adt'         => 'required|min:1',
                'Chd'         => 'min:0',
                'Inf'         => 'min:0',
            ],
                $messages = [
                    'StartPoint.required'   => 'Bạn cần chọn điểm khởi hành!',
                    'EndPoint.required'     => 'Bạn cần chọn điểm đến!',
                    'DepartDate2.required'  => 'Bạn cần chọn ngày khởi hành!',
                    'DepartDate.required'   => 'Bạn cần chọn ngày về!',
                    'Adt.required'          => 'Bạn cần nhập số người lớn!',
                    'Inf.min'               => 'Số em bé phải là số dương!',
                    'Inf.Chd'               => 'Số trẻ em phải là số dương!',
                    'Adt.min'               => 'Số người lớn phải lớn hơn 1!',
                ]
            );

        }
        ini_set('max_execution_time', 3000);

        $DepartDate      = \DateTime::createFromFormat('d/m/Y',$request->DepartDate);
        $Dep_Date        = $DepartDate->format('d-m-Y');
        if($request->has('DepartDate2') && $request->DepartDate2 != null){
            $DepartDate2 = \DateTime::createFromFormat('d/m/Y',$request->DepartDate2);
            $Arr_Date    = $DepartDate2->format('d-m-Y');
        }
        else{
            $Arr_Date = null;
        }
        if ($request->has('DepartDate') && $request->has('DepartDate2') && $request->DepartDate !== null && $request->DepartDate2 !== null) {
            if (Carbon::parse($Dep_Date)->gt(Carbon::parse($Arr_Date))) {
                return redirect()->back()->withErrors(['error' => 'Thời gian khởi ngày đi phải nhỏ hơn thời gian ngày về!']);
            }
        }
        $input = $request->all();
        $airline    = FlightAirlines::where('status',1)->get();
        $Stations   =  FlightStations::where('status',1)->get();
        $StartPoint = $request->StartPoint;
        $EndPoint   = $request->EndPoint;
        $start      = FlightStations::where('code', $request->StartPoint)->first();
        $end        = FlightStations::where('code', $request->EndPoint)->first();
        if ($start->country_code == 'VN' && $end->country_code == 'VN') {
            $type  = 'EV-ND';
        }
        else{
            $type  = 'EV-QT';
        }
        $flight_data = FlightHelper::ApiEnViet($input);

        if($flight_data != null){
            $convert     = FlightHelper::convertData($flight_data,$type, $StartPoint, $EndPoint, $Dep_Date, $Arr_Date);
            $datas       = collect($convert)->groupBy('RecordIndex');
        }
        else{
            $datas = [];
        }
        return theme_view('flight.list',compact('datas','StartPoint','EndPoint','airline','Stations'));
    }



}
