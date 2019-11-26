<?php

namespace App\Modules\Weblink\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Weblink extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name','url','description','status', 'image', 'sort'
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}