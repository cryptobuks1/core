<?php

namespace App\Modules\Flights\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class FlightAirlines extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'flight_airlines';
    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'module',
        'slug',
        'code',
        'description',
        'image',
        'local',
        'status'
    ];
}
