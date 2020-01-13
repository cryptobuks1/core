<?php

namespace App\Modules\Flights\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class FlightStations extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'flight_stations';
    protected $fillable = [
        'name',
        'module',
        'slug',
        'name_en',
        'search_tags',
        'code',
        'country_code',
        'city_code',
        'city_vi',
        'city_en',
        'country_vi',
        'country_en',
        'description',
        'image',
        'area',
        'local',
        'status',
    ];

}
