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


class FlightsApi extends BackendController{

    public function index(){


        ///$client = "http://xml.enviet-group.com/servicebooking.asmx?wsdl";

    }

}

