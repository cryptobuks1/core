<?php

namespace App\Modules\Tours\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TourPlaces extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tour_places';
    
}