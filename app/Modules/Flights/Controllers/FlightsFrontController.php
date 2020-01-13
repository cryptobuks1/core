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
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\Order\Models\Order;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use App\User;
use Response;


class FlightsFrontController extends FrontendController
{
    //Tìm kiếm chuyến bay
    public $config = [
        'url' => 'http://platform.datacom.vn/flights/search',
        'HeaderUser' => 'datacom',
        'HeaderPass' => 'dtc@19860312',
        'ProductKey' => 'fhu95z5yn394ix8',
        'Language' => 'vi',
        'AgentAccount' => 'DC10961',
        'AgentPassword' =>'kzx0q7fh',
    ];
    public function search(){
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        $airline    = FlightAirlines::where('module','Flight')->where('status',1)->orderBy('name','ASC')->get();
        $services   = Services::where('module','Flight')->where('status',1)->get();
        return theme_view('flight.search',compact('airline','currencies','services'));
    }

    //danh sách tìm
    public function list(Request $request){
        if ($request->has('DepartDate') && $request->has('DepartDate2') && $request->DepartDate !== null && $request->DepartDate2 !== null) {
            if (Carbon::parse($request->DepartDate)->gt(Carbon::parse($request->DepartDate2))) {
                return redirect()->back()->withErrors(['error' => 'Thời gian khởi hành phải nhỏ hơn thời gian về']);
            }
        }
        if($request->has('DepartDate2') && $request->DepartDate2 != null){
            $data = array(
                'Adt' => $request->Adt,
                'Chd' => $request->Chd,
                'Inf' => $request->Inf,
                'ViewMode' => '',
                'ListFlight'=> array( array(
                    'StartPoint' => $request->StartPoint,
                    'EndPoint' => $request->EndPoint,
                    'DepartDate' => Carbon::parse($request->DepartDate)->format('dmY'),
                    'Airline' => $request->Airline,
                ),
                    array(
                        'StartPoint' => $request->EndPoint,
                        'EndPoint' => $request->StartPoint,
                        'DepartDate' => Carbon::parse($request->DepartDate2)->format('dmY'),
                        'Airline' => $request->Airline,
                    ),
                ),

                'HeaderUser' => $this->config['HeaderUser'],
                'HeaderPass' => $this->config['HeaderPass'],
                'ProductKey' => $this->config['ProductKey'],
                'Language' => $this->config['Language'],
                'AgentAccount' => $this->config['AgentAccount'],
                'AgentPassword' =>$this->config['AgentPassword'],
            );
        }
        else{
            $data = array(
                'Adt' => $request->Adt,
                'Chd' => $request->Chd,
                'Inf' => $request->Inf,
                'ViewMode' => '',
                'ListFlight'=> array( array(
                    'StartPoint' => $request->StartPoint,
                    'EndPoint' => $request->EndPoint,
                    'DepartDate' => Carbon::parse($request->DepartDate)->format('dmY'),
                    'Airline' => $request->Airline,
                ),
                ),
                'HeaderUser' => $this->config['HeaderUser'],
                'HeaderPass' => $this->config['HeaderPass'],
                'ProductKey' => $this->config['ProductKey'],
                'Language' => $this->config['Language'],
                'AgentAccount' => $this->config['AgentAccount'],
                'AgentPassword' =>$this->config['AgentPassword'],
            );
        }

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['url'], [
            'json' => $data
        ]);
        $stations = FlightStations::where('status',1)->get();
        $airline = FlightAirlines::all();
        $response = $response->getBody()->getContents();
        $datas = json_decode($response, true);
        $start = FlightStations::where('code',$request->StartPoint)->first();
        $end = FlightStations::where('code',$request->EndPoint)->first();
        $start_time = Carbon::parse($request->DepartDate)->format('d-m-Y');
        if($request->DepartDate2 == null){
            $end_time = null;
        }
        else{
            $end_time = Carbon::parse($request->DepartDate2)->format('d-m-Y');
        }
        return theme_view('flight.list',compact('datas','start','end','stations','airline','start_time','end_time'));
    }

    public function ajaxDeparture(Request $request)
    {
        $station = FlightStations::where('search_tags', 'like', '%' . $request->get('searchTerm') . '%')->where('module','Flight')->orderBy('country_code','ASC')->limit(5)->get();
        $data = [];
        foreach ($station as $key => $item) {
            {
                $ivalue = [
                    'text' => $item->city_vi.'-'.$item->country_vi.'('.$item->name.')',
                    'id'   => $item->code
                ];
                $data[] = $ivalue;
            }
        }
        return Response::json($data);
    }
    public function ajaxArrival(Request $request)
    {
        $station = FlightStations::where('search_tags', 'like', '%' . $request->get('searchTerm') . '%')->where('module','Flight')->orderBy('country_code','ASC')->where('status',1)->limit(5)->get();
        $data = [];
        foreach ($station as $key => $item) {
            {
                $ivalue = [
                    'text' => $item->city_vi.'-'.$item->country_vi.'('.$item->name.')',
                    'id'   => $item->code
                ];
                $data[] = $ivalue;
            }
        }
        return Response::json($data);
    }
    public function ajaxAirline(Request $request)
    {
        $airlines = FlightAirlines::where('search_tags', 'like', '%' . $request->get('searchTerm') . '%')->where('module','Flight')->where('status',1)->limit(5)->get();
        $data = [];
        foreach ($airlines as $key => $item) {
            $ivalue = [
                'text' => $item->name,
                'id'   => $item->code
            ];
            $data[] = $ivalue;
        }
        return Response::json($data);
    }


}
