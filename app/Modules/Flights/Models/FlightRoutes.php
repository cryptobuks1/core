<?php

namespace App\Modules\Flights\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class FlightRoutes extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table    = 'flight_routes';
    protected $fillable = [
        'module',
        'name',
        'departure_station',
        'arrival_station',
        'code',
        'local',
        'airline',
        'range',
        'status',
        'search',
    ];
    protected $casts = [
        'airline' => 'array'
    ];

}
