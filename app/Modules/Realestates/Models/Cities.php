<?php

namespace App\Modules\Realestates\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table= 'cities';
    protected $fillable=[
        'name','code','dial_code','lang'
    ];


    /**
     * Get gallery for the product.
     */


}
