<?php

namespace App\Modules\Flights\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class FlightOrders extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'flight_oders';
    protected $fillable = [
        'module',
        'code',
        'user_id',
        'user_info',
        'route_code',
        'day_go',
        'day_back',
        'airline_code',
        'local',
        'price',
        'fees',
        'tax',
        'discount',
        'total',
        'description',
        'services',
        'status',
    ];
    protected $casts =[
        'price' => 'array',
        'fees' => 'array',
        'tax' => 'array',
        'services' => 'array',
        'user_info' => 'array',
    ];

}
