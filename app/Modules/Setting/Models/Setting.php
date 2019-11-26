<?php

namespace App\Modules\Setting\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'key','value', 'tab'
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}