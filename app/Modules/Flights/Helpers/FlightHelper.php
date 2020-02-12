<?php
namespace App\Modules\Flights\Helpers;

use App\Modules\Sendmail\Controllers\SendmailController;
use App\Modules\Wallet\Controllers\WalletController;
use Illuminate\Support\Facades\Hash;
use App\Modules\Flights\Models\FlightStations;

use App\Modules\Wallet\Models\Wallet;
use DB;
use Log;
use Auth;
use Cookie;
use Cache;
use Response;
use Carbon\Carbon;

class FlightHelper {
    public static function convertData($datas,$type, $StartPoint, $EndPoint, $Dep_Date, $Arr_Date){
        try{
            $output  = array();
            $i = 0;
            if($type == 'EV-QT'){
                foreach ($datas as  $items){
                    foreach ($items as  $data){
                        $DepartDate    = \DateTime::createFromFormat('d/m/Y',$data['DepartureDate']);
                        $DepartureDate = $DepartDate->format('d-m-Y');

                        $DepartDate2   = \DateTime::createFromFormat('d/m/Y',$data['ArrivalDate']);
                        $ArrivalDate   = $DepartDate2->format('d-m-Y');

                        $output[$i]['Departure']        = $data['DepartureCity'];
                        $output[$i]['DepartureDate']    = $DepartureDate;
                        $output[$i]['DepartureTime']    = $data['DepartureTime'];
                        $output[$i]['Arrival']          = $data['ArrivalCity'];
                        $output[$i]['ArrivalDate']      = $ArrivalDate;
                        $output[$i]['ArrivalTime']      = $data['ArrivalTime'];
                        $output[$i]['Airline']          = $data['FlightAirline'];
                        if($data['TypeAir'] === 'Bay thẳng'){
                            $output[$i]['TypeAir'] = 0;
                        }
                        else{
                            $output[$i]['TypeAir'] = 1;
                        }
                        if($StartPoint === $data['DepartureCity']){
                            $output[$i]['RoundTrip']    = 0;
                        }
                        else{
                            $output[$i]['RoundTrip']    = 1;
                        }
                        $output[$i]['FlightNumber']     = $data['FlightNo'];
                        $output[$i]['Currency']         = 'VND';
                        $output[$i]['RecordIndex']      = $data['RecordIndex'];
                        $output[$i]['FlightType']       = 1;
                        $output[$i]['SumPrice']         = $data['SumPrice']*23337;

                        if($data['TypeAir'] == 'Bay thẳng'){
                            $output[$i]['Journeys'][0]['Departure']     = $data['StopInfo']['StopInfo']['Form'];
                            $output[$i]['Journeys'][0]['DepartureDate'] = $data['StopInfo']['StopInfo']['DepartureDate'];
                            $output[$i]['Journeys'][0]['DepartureTime'] = $data['StopInfo']['StopInfo']['DepartureTime'];
                            $output[$i]['Journeys'][0]['FlightNumber']  = $data['StopInfo']['StopInfo']['Airline'];
                            $output[$i]['Journeys'][0]['Arrival']       = $data['StopInfo']['StopInfo']['To'];
                            $output[$i]['Journeys'][0]['ArrivalDate']   = $data['StopInfo']['StopInfo']['ArrivalDate'];
                            $output[$i]['Journeys'][0]['ArrivalTime']   = $data['StopInfo']['StopInfo']['ArrivalTime'];
                            $output[$i]['Journeys'][0]['Duration']      = $data['StopInfo']['StopInfo']['Duration'];
                            $output[$i]['Journeys'][0]['TicketType']    = $data['StopInfo']['StopInfo']['TicketType'];
                        }
                        else{
                            $output[$i]['Journeys'][0]['Departure']     = $data['StopInfo']['StopInfo'][0]['Form'];
                            $output[$i]['Journeys'][0]['DepartureDate'] = $data['StopInfo']['StopInfo'][0]['DepartureDate'];
                            $output[$i]['Journeys'][0]['DepartureTime'] = $data['StopInfo']['StopInfo'][0]['DepartureTime'];
                            $output[$i]['Journeys'][0]['FlightNumber']  = $data['StopInfo']['StopInfo'][0]['Airline'];
                            $output[$i]['Journeys'][0]['Arrival']       = $data['StopInfo']['StopInfo'][0]['To'];
                            $output[$i]['Journeys'][0]['ArrivalDate']   = $data['StopInfo']['StopInfo'][0]['ArrivalDate'];
                            $output[$i]['Journeys'][0]['ArrivalTime']   = $data['StopInfo']['StopInfo'][0]['ArrivalTime'];
                            $output[$i]['Journeys'][0]['Duration']      = $data['StopInfo']['StopInfo'][0]['Duration'];
                            $output[$i]['Journeys'][0]['TicketType']    = $data['StopInfo']['StopInfo'][0]['TicketType'];

                            $output[$i]['Journeys'][1]['Departure']     = $data['StopInfo']['StopInfo'][0]['Form'];
                            $output[$i]['Journeys'][1]['DepartureDate'] = $data['StopInfo']['StopInfo'][0]['DepartureDate'];
                            $output[$i]['Journeys'][1]['DepartureTime'] = $data['StopInfo']['StopInfo'][0]['DepartureTime'];
                            $output[$i]['Journeys'][1]['FlightNumber']  = $data['StopInfo']['StopInfo'][0]['Airline'];
                            $output[$i]['Journeys'][1]['Arrival']       = $data['StopInfo']['StopInfo'][1]['To'];
                            $output[$i]['Journeys'][1]['ArrivalDate']   = $data['StopInfo']['StopInfo'][0]['ArrivalDate'];
                            $output[$i]['Journeys'][1]['ArrivalTime']   = $data['StopInfo']['StopInfo'][0]['ArrivalTime'];
                            $output[$i]['Journeys'][1]['Duration']      = $data['StopInfo']['StopInfo'][0]['Duration'];
                            $output[$i]['Journeys'][1]['TicketType']    = $data['StopInfo']['StopInfo'][0]['TicketType'];
                        }
                        $i++;
                    }
                }
            }
            if($type == 'EV-ND') {
                foreach ($datas as $i => $data) {
                    if($data['RoundTrip'] == 0){
                        if(Carbon::parse($data['ToTime'])->gt(Carbon::parse($data['StartTime']))){
                            $output[$i]['Departure']      = $StartPoint;
                            $output[$i]['DepartureDate']  = $Dep_Date;
                            $output[$i]['DepartureTime']  = $data['StartTime'];
                            $output[$i]['Arrival']        = $EndPoint;
                            $output[$i]['ArrivalDate']    = $Dep_Date;
                            $output[$i]['ArrivalTime']    = $data['ToTime'];
                        }
                        else{
                            $output[$i]['Departure']      = $StartPoint;
                            $output[$i]['DepartureDate']  = $Dep_Date;
                            $output[$i]['DepartureTime']  = $data['StartTime'];
                            $output[$i]['Arrival']        = $EndPoint;
                            $output[$i]['ArrivalDate']    = Carbon::parse($Dep_Date)->addDays(1)->format('d-m-Y');
                            $output[$i]['ArrivalTime']    = $data['ToTime'];
                        }
                        $output[$i]['RoundTrip']    = 0;
                    }
                    else{
                        if(Carbon::parse($data['ToTime'])->gt(Carbon::parse($data['StartTime']))){
                            $output[$i]['Departure']      = $EndPoint;
                            $output[$i]['DepartureDate']  = $Arr_Date;
                            $output[$i]['DepartureTime']  = $data['StartTime'];
                            $output[$i]['Arrival']        = $StartPoint;
                            $output[$i]['ArrivalDate']    = $Arr_Date;
                            $output[$i]['ArrivalTime']    = $data['ToTime'];
                        }
                        else{
                            $output[$i]['Departure']      = $EndPoint;
                            $output[$i]['DepartureDate']  = $Arr_Date;
                            $output[$i]['DepartureTime']  = $data['StartTime'];
                            $output[$i]['Arrival']        = $StartPoint;
                            $output[$i]['ArrivalDate']    = Carbon::parse($Arr_Date)->addDays(1)->format('d-m-Y');
                            $output[$i]['ArrivalTime']    = $data['ToTime'];
                        }
                        $output[$i]['RoundTrip']    = 1;
                    }
                    if ($data['AirlineType']  == 1) {
                        $output[$i]['Airline']    = 'Vietnam Airlines';
                    } elseif ($data['AirlineType'] == 2) {
                        $output[$i]['Airline']    = 'Vietjet';
                    } elseif ($data['AirlineType'] == 3) {
                        $output[$i]['Airline']    = 'Jetstar Pacific';
                    } elseif ($data['AirlineType'] == 4) {
                        $output[$i]['Airline']    = 'Bamboo Airways';
                    }
                    $output[$i]['FlightNumber']   = $data['AirFlight'];
                    if ($data['FlightDetail'] == 'Bay thẳng') {
                        $output[$i]['TypeAir']    = 0;
                    } else {
                        $output[$i]['TypeAir']    = 1;
                    }
                    $output[$i]['SumPrice'] = round(($data['Price'] + $data['TAX'] + $data['FEE'] + $data['PriceCHD'] + $data['TAXCHD'] + $data['FEECHD'] + $data['PriceINF'] + $data['TAXINF'] + $data['FEEINF'] + $data['FeeDV']));
                    $output[$i]['Currency']      = 'VND';
                    $output[$i]['RecordIndex']      = $i;
                    $output[$i]['FlightType']      = 0;

                    $output[$i]['Journeys'][0]['Departure']     = $StartPoint;
                    $output[$i]['Journeys'][0]['DepartureDate'] = $output[$i]['DepartureDate'];
                    $output[$i]['Journeys'][0]['DepartureTime'] = $data['StartTime'];
                    $output[$i]['Journeys'][0]['Arrival']       = $EndPoint;
                    $output[$i]['Journeys'][0]['ArrivalDate']   = $output[$i]['ArrivalDate'];
                    $output[$i]['Journeys'][0]['ArrivalTime']   = $data['ToTime'];
                    $output[$i]['Journeys'][0]['FlightNumber']  = $data['AirFlight'];
                    $output[$i]['Journeys'][0]['Duration']      = Carbon::parse($output[$i]['DepartureDate'].' '.$data['StartTime'])->diffInHours(Carbon::parse($output[$i]['ArrivalDate'].' '.$data['ToTime'])).':'.(Carbon::parse($output[$i]['DepartureDate'].' '.$data['StartTime'])->diffInMinutes(Carbon::parse($output[$i]['ArrivalDate'].' '.$data['ToTime']))%60);
                    $output[$i]['Journeys'][0]['TicketType']    = $data['AirClass'];
                }
            }
            return $output;
        } catch (\Exception $e) {
            return $output = [];
        }

    }
    public static function Departure($input)
    {
        try{
            $station = FlightStations::where('search_tags', 'like', '%' . $input . '%')->where('module', 'Flight')->orderBy('featured', 'DESC')->limit(10)->get();
            $data = [];
            foreach ($station as $key => $item) {
                {
                    $ivalue = [
                        'text' => $item->city_vi . ' (' . $item->name . ')',
                        'id' => $item->code
                    ];
                    $data[] = $ivalue;
                }
            }
            return Response::json($data);
        } catch (\Exception $e) {
            return null;
        }

    }
    public static function ApiEnViet($input){
        try{
            $flight_data  = Cache::remember('flight_data_'.$input['StartPoint'].$input['EndPoint'].$input['DepartDate'].$input['DepartDate2'], 5, function () use ($input) {
                $start    = FlightStations::where('code', $input['StartPoint'])->first();
                $end      = FlightStations::where('code', $input['EndPoint'])->first();
                if ($start->country_code == 'VN' && $end->country_code == 'VN') {
                    $type = 'EV-ND';
                }
                else{
                    $type = 'EV-QT';
                }
                $client = new \SoapClient("http://xml.enviet-group.com/ServiceBooking.asmx?wsdl");
                $params = new \stdClass();
                if ($type == 'EV-ND') {
                    $params->Departure     = $input['StartPoint'];
                    $params->Departurename = '';
                    $params->Arrival       = $input['EndPoint'];
                    $params->Arrivalname   = '';
                    $params->DateDeparture = $input['DepartDate'];
                    if ($input['DepartDate2'] != '' && $input['DepartDate2'] != null && $input['type'] == 1) {
                        $params->DateArrival = $input['DepartDate2'];
                    } else {
                        $params->DateArrival = '';
                    }
                    $params->AirlineType = 0;
                    $params->Roundtrip   = $input['type'];
                    $params->ADL         = $input['Adt'];
                    if ($input['Chd'] != '' && $input['Chd'] && $input['Chd'] >= 0) {
                        $params->CHD = $input['Chd'];
                    } else {
                        $params->CHD = 0;
                    }
                    if ($input['Inf'] != '' && $input['Inf'] && $input['Inf'] >= 0) {
                        $params->INF = $input['Inf'];
                    } else {
                        $params->INF = 0;
                    }
                    $params->DiscountVN = 0;
                    $params->FeeDVVN    = 0;
                    $params->DiscountBL = 0;
                    $params->FeeDVBL    = 0;
                    $params->DiscountVJ = 0;
                    $params->FeeDVVJ    = 0;
                    $params->DiscountQH = 0;
                    $params->FeeDVQH    = 0;
                    $params->Sabre      = '';
                    $params->KeyWord    = 'a1di6Ex+ASHUSbw7Od2bkA==';
                    $objectresult       = $client->GetFilghtXML(array('Infor' => $params));
                    $xml = simplexml_load_string($objectresult->GetFilghtXMLResult->any);
                    $response = json_encode($xml, true);
                    $result = json_decode($response, true);
                    if(isset($result) && $result != null){
                        $data = collect($result['FlightList'])->sortBy('RoundTrip');
                        $data->values()->all();
                    }
                    else{
                        $data = null;
                    }

                }
                elseif($type == 'EV-QT') {
                    $params->DepartureCity    = $input['StartPoint'];
                    $params->ArrivalCity      = $input['EndPoint'];
                    $params->Dep_Date         = $input['DepartDate'];
                    if ($input['DepartDate2'] != '' && $input['DepartDate2'] != null && $input['type'] == 1) {
                        $params->Arr_Date = $input['DepartDate2'];
                    } else {
                        $params->Arr_Date = '';
                    }
                    $params->adt = $input['Adt'];
                    if ($input['Chd'] != '' && $input['Chd'] && $input['Chd'] >= 0) {
                        $params->chd = $input['Chd'];
                    } else {
                        $params->chd = 0;
                    }
                    if ($input['Inf'] != '' && $input['Inf'] && $input['Inf'] >= 0) {
                        $params->inf = $input['Inf'];
                    } else {
                        $params->inf = 0;
                    }
                    $params->ggqt    = 0;
                    $params->dvqt    = 0;
                    $params->ggvj    = 0;
                    $params->dvvj    = 0;
                    $params->ggbl    = 0;
                    $params->dvbl    = 0;
                    $params->tygia   = 23337;
                    $params->slvj    = 0;
                    $params->slbl    = 0;
                    $params->sl1g    = 0;
                    $params->sltatca = 0;
                    $objectresult    = $client->XMLGetFilghtGalileo($params);
                    $xml             = simplexml_load_string($objectresult->XMLGetFilghtGalileoResult->any);
                    $response        = json_encode($xml, true);
                    $result          = json_decode($response, true);
                    if(isset($result) && $result != null){
                        $data = collect($result['Flight_Galileo'])->groupBy('RecordIndex');
                    }
                    else{
                        $data = null;
                    }
                }
                return $data;
            });
            return $flight_data;
        }
        catch (\Exception $e) {
            return null;
        }

    }
}
