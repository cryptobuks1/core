<?php

namespace App\Modules\Price\Controllers;

use App\Modules\Price\Models\Tourdetails;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use \App\User;
use App\Modules\Currency\Models\Currencies;


class PriceController extends BackendController
{


    public static function createPrice(){
        $currencies = Currencies::where(['status' => 1,'fiat' => 1 ])->orderBy('default', 'DESC')->get();

        $prices = view('Tourdetails::priceform', compact('currencies'))->render();

        return $prices;

    }




}
