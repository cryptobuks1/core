<?php

namespace App\Modules\Flights\Controllers;

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
use App\Modules\Backend\Controllers\BackendController;
use Auth;
use DB;
use Response;
use \App\User;
use App\Modules\Currency\Models\Currencies;
use function GuzzleHttp\Psr7\str;


class FlightsController extends BackendController
{
    //Flights
    public function index(){
        $datas   = FlightOrders::where('module','Flight')->paginate(20);
        $sations = FlightStations::where('module','Flight')->where('status',1)->orderBy('name','ASC')->get();
        return view('Flights::flight_index',compact('datas','sations'));
    }

    public function create(){

    }

    public function store(Request $request){

    }

    public function edit($id){

    }

    public function update($id){

    }

    public function delete($id){

    }

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
        return view('Flights::flight_search',compact('airline','currencies','services'));
    }

    //danh sách tìm
    public function list(Request $request){
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
        return view('Flights::flight_list',compact('datas','start','end','stations','airline','start_time','end_time'));
    }
    //đặt vé
    public function checkin($Session,$FareDataId,$FlightValue){
        $data = array(
            'ListFareData'=> array( array(
                'Session' => $Session,
                'FareDataId' => $FareDataId,
                'AutoIssue' => false,
                'ListFlight'=>  array( array(
                    'FlightValue' => $FlightValue,
                ),
                ),
            ),
            ),
            'HeaderUser' => $this->config['HeaderUser'],
            'HeaderPass' => $this->config['HeaderPass'],
            'ProductKey' => $this->config['ProductKey'],
            'Language' => $this->config['Language'],
            'AgentAccount' => $this->config['AgentAccount'],
            'AgentPassword' =>$this->config['AgentPassword'],
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST',"http://platform.datacom.vn/flights/verifyflight", [
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        $datas = json_decode($response, true);
        dd($datas);

    }
    protected function postCheckin(){

    }


    //Flight Routes
    public function indexRoute(){
        $datas    = FlightRoutes::where('module','Flight')->orderBy('id','ASC')->paginate(20);
        $stations = FlightStations::where('module','Flight')->get();
        return view('Flights::route_index',compact('datas','stations'));
    }

    public function createRoute(){

        $stations = FlightStations::where('module','Flight')->where('status',1)->get();
        $airlines = FlightAirlines::where('module','Flight')->where('status',1)->get();
        return view('Flights::route_create',compact('stations','airlines'));
    }

    public function storeRoute(Request $request){
        $this->validate($request, [
            'departure_station' => 'required',
            'name'              => 'required',
            'arrival_station'   => 'required',
        ]);
        $sation = FlightStations::where('code',$request->arrival_station)->first();
        if($request->departure_station === $request->arrival_station){
            return back()->withErrors('Điểm khởi hành và điểm đến không được chùng nhau');
        }
        $input = $request->all();
        $input['module'] = 'Flight';
        $input['search'] = $sation->search_tags.','.$sation->name;
//        $input['code']   = strtoupper($request->code);
        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 2;
        FlightRoutes::create($input);
        return redirect()->route('flight.route.index')->with('success','Thêm thành công');

    }

    public function editRoute($id){
        $data      = FlightRoutes::find($id);
        $countries = Countries::all();
        $cities    = Cities::all();
        $airlines  = FlightAirlines::where('module','Flight')->where('status',1)->get();
        $stations  = FlightStations::where('module','Flight')->where('status',1)->get();
        return view('Flights::route_edit',compact('data','stations','countries','cities','airlines'));

    }

    public function updateRoute($id, Request $request){
        $this->validate($request, [
            'departure_station' => 'required',
            'name'              => 'required',
            'arrival_station'   => 'required',
        ]);
        $data   = FlightRoutes::find($id);
        $sation = FlightStations::where('code',$request->arrival_station)->first();
        if(isset($request->status)) {$data->status = 1;} else {$data->status = 2;}
//        $data->code = strtoupper($request->code);
        $data->name              = $request->name;
        $data->arrival_station   = $request->arrival_station;
        $data->departure_station = $request->departure_station;
        $data->airline           = $request->airline;
        $data->local             = $request->local;
        $data->range             = $request->range;
        $data->search            = $sation->search_tags.','.$sation->name;
        $data->save();
        return redirect()->route('flight.route.index')->with('success','Cập nhật thành công');
    }

    public function deleteRoute($id){
        FlightRoutes::destroy($id);
        return  back()->with('success','Xóa thành công');
    }


    //Flight Stations
    public function indexStation(){
        $countries = Countries::all();
        $cities    = Cities::all();
        $datas     = FlightStations::where('module','Flight')->paginate(20);
        return view('Flights::station_index',compact('datas','countries','cities'));

    }

    public function createStation(){
        $countries = Countries::all();
        $cities    = Cities::all();
        return view('Flights::station_create',compact('cities','countries','tags'));

    }

    public function storeStation(Request $request){
        $this->validate($request, [
            'code'        => 'required|unique:flight_stations',
            'image'       => 'required',
            'description' => 'required',
            'local'       => 'required',
            'city'        => 'required',
            'country'     => 'required',
            'name'        => 'required',
        ]);
        DB::beginTransaction();
        try{
            $input = $request->all();
            if( $request->hasFile('image')){
                $imagelink      = explode('storage',$request->image);
                $input['image'] = '/storage'.$imagelink[1];
            }
            $input['module'] = 'Flight';
            $input['code']   = strtoupper($request->code);
            $input['slug']   = $input['code'].'-'.str_slug($request->name);
            ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 2;
            $news = FlightStations::create($input);

            DB::commit();
            return redirect()->route('flight.station.index')->with('success','Thêm thành công');
        }
        catch (\Exception $e){
            DB::rollback();
            return redirect()->route('flight.station.index')->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function editStation($id){
        $data      = FlightStations::find($id);
        $countries = Countries::all();
        $cities    = Cities::where('country_code',$data->country)->get();
        $tags      = app('App\Modules\Tags\Models\Tagslist')->select('id','code','label')->limit(20)->get();
        $selected_tags = app('App\Modules\Tags\Models\Tagslist')->where('model_id',$id)
            ->where('module','Flight')
            ->groupBy('id')
            ->pluck('id')
            ->toArray();
        return view('Flights::station_edit',compact('data','countries','cities','tags','selected_tags'));
    }

    public function updateStation($id, Request $request){
        $this->validate($request, [
            'code'        => 'required|unique:flight_stations,code,' . $id,
            'description' => 'required',
            'local'       => 'required',
            'city'        => 'required',
            'country'     => 'required',
            'name'        => 'required',
        ]);
        $data              = FlightStations::find($id);
        $data->name        = $request->name;
        $data->name_en     = $request->name_en;
        $data->code        = strtoupper($request->code);
        $data->slug        = $data->code.'-'.str_slug($request->name);
        $data->description = $request->description;
        $data->local       = $request->local;
        $data->search_tags = $request->search_tags;
        $data->city        = $request->city;
        $data->country     = $request->country;
        $data->area        = $request->area;
        if( $request->hasFile('image')){
            $imagelink   = explode('storage',$request->image);
            $data->image = '/storage'.$imagelink[1];
        }
        if(isset($request->status)) {$data->status = 1;} else {$data->status = 2;}
        $data->save();


        return redirect()->route('flight.station.index')->with('success','Cập nhật thành công');

    }

    public function deleteStation($id){
        FlightStations::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    //Flight Airlines
    public function indexAirline(){
        $datas = FlightAirlines::where('module','Flight')->orderBy('id','ASC')->paginate(20);
        return view('Flights::airline_index',compact('datas'));
    }

    public function createAirline(){
        return view('Flights::airline_create');
    }

    public function storeAirline(Request $request){
        $this->validate($request, [
            'code'        => 'unique:flight_airlines|required',
            'image'       => 'required',
            'description' => 'required',
            'local'       => 'required',
        ]);
        if ($request->file('importFile')) {
            $this->validate($request, [
                'importFile' => 'required|file|mimes:xlsx'
            ]);

            $file = $request->file('importFile');

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
        }
        $input = $request->all();
        if( $request->hasFile('image')){
            $imagelink      = explode('storage',$request->image);
            $input['image'] = '/storage'.$imagelink[1];
        }
        $input['module'] = 'Flight';
        $input['code']   = strtoupper($request->code);
        $input['slug']   = $input['code'].'-'.str_slug($request->name);
        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 2;
        FlightAirlines::create($input);
        return redirect()->route('flight.airline.index')->with('Thêm thành công');

    }

    public function editAirline($id){
        $data = FlightAirlines::find($id);
        return view('Flights::airline_edit',compact('data'));
    }

    public function updateAirline($id,Request $request){
        $this->validate($request, [
            'code'        => 'required|unique:flight_airlines,code,' . $id,
            'image'       => 'required',
            'description' => 'required',
            'local'       => 'required',
        ]);
        $data              = FlightAirlines::find($id);
        $data->name        = $request->name;
        $data->code        = strtoupper($request->code);
        $data->slug        = $data->code.'-'.str_slug($request->name);
        $data->description = $request->description;
        $data->local       = $request->local;
        if(isset($request->status)) {$data->status = 1;} else {$data->status = 2;}
        $data->save();
        return redirect()->route('flight.airline.index')->with('success','Cập nhật thành công');
    }

    public function deleteAirline($id){
        FlightAirlines::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    //ajax
    public function ajaxCountries(Request $request)
    {

        $countries = Countries::where('name', 'like', '%' . $request->get('searchTerm') . '%')->limit(5)->get();
        $currency  = session()->get('currency');
        $data = [];
        foreach ($countries as $key => $country) {
            $ivalue = [
                'text' => $country->name,
                'id'   => $country->code
            ];
            $data[] = $ivalue;
        }
        return Response::json($data);
    }
    public function ajaxCities(Request $request)
    {
        $types = Cities::orderBy('name_city','ASC')->where('country_code', $request->code)->get();
        $html  = '';
        $html .= "<option value=''>-- Chọn thành phố --</option>";
        foreach ($types as $value) {
            $html .= "<option value='" . $value['code'] . "'>" . $value['name_city'] . "</option>";
        }
        return $html;
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
    public function getImport(Request $request)
    {
        return view('Flights::import_airline');
    }
    public function postImport(Request $request)
    {
        ini_set('max_execution_time', 3000);
        if ($request->file('importFile')) {
            $this->validate($request, [
                'importFile' => 'required|file|mimes:xlsx'
            ]);

            $file = $request->file('importFile');

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            unset($sheetData[0]);
            foreach ($sheetData as $data){
                if(strlen($data['1']) > 2){
                    $airline = new FlightStations();
                    $airline->code = trim($data[1]);
                    $airline->city_code = trim($data[2]);
                    $airline->country_code = trim($data[3]);
                    $airline->area = trim($data[4]);
                    $airline->name = trim($data[5]);
                    $airline->name_en = $data[6];
                    $airline->city_vi = $data[7];
                    $airline->city_en = $data[8];
                    $airline->country_vi = $data[9];
                    $airline->country_en = $data[10];
                    $airline->search_tags = trim($data[1]).','.trim($data[2]).','.trim($data[3]).','.trim($data[4]).','.$data[5].','.$data[6].','.$data[7].','.$data[8].','.$data[9].','.$data[10];
                    $airline->save();
                }
                else{
                    continue;
                }
            }
        }
        return back();
    }


}
