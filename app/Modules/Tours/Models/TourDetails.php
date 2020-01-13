<?php

namespace App\Modules\Tours\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TourDetails extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tour_details';
    protected $fillable = [
        'start_day',
        'tour_id',
        'end_day',
        'days',
        'hotel',
        'ticket_start',
        'ticket_end',
        'tour_guide',
        'converge_time',
        'converge_place',
        'total',
        'purchased',
        'start_place',
        'price',
        'fees',
        'price_land',
        'fees_land',
        'discount',
        'day_converge',
    ];

    protected $casts=[
      'hotel'=>'array',
      'price'=>'array',
      'price_land'=>'array',
      'fees'=>'array',
      'fees_land'=>'array',
    ];



}
