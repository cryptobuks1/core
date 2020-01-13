<?php

namespace App\Modules\Tours\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tours';
    protected $casts=[
        'schedule'=>'array',
        'service'=>'array',
        'hotel'=>'array',
        'price'=>'array',
        'price_land'=>'array',
        'fees'=>'array',
        'fees_land'=>'array',
    ];

}
