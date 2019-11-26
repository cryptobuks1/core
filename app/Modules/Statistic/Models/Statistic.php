<?php

namespace App\Modules\Statistic\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [

    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}