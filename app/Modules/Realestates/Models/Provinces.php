<?php

namespace App\Modules\Realestates\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table= 'provinces';
    protected $fillable=[
        'name','city_code'
    ];


    /**
     * Get gallery for the product.
     */


}
