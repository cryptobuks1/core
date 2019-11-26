<?php

namespace App\Modules\Block\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'key',
        'lang',
        'require_login',
        'position',
        'widget',
        'qty',
        'url',
        'sort',
        'status',

    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}