<?php

namespace App\Modules\Localisation\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table= 'countries';
    protected $fillable=[
        'name','code','dial_code','lang'
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
