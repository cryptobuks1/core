<?php

namespace App\Modules\Hotels\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'hotel_room';
    protected $casts= [
    'price' => 'array',
    'fees' => 'array',
    'service' => 'array',
    'room' => 'array',
    ];
}
