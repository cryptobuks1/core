<?php

namespace App\Modules\Realestates\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'realestates_broker';
    protected $fillable=[
        'user_id','module','name','address','phone','email','website','fields'
    ];
    protected $casts=[
        'fields'=>'array'
    ];

    /**
     * Get gallery for the product.
     */


}
