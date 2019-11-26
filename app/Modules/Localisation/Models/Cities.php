<?php

namespace App\Modules\Localisation\Models;

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
        'name_city','code','country_code'
    ];

    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
