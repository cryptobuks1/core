<?php

namespace App\Modules\Catalog\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Catalog extends Model
{
    use HasRoles;
    use NodeTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name',
       'slug',
       'lang',
       'image',
       'cover',
       'icon',
       'description',
       'parent_id',
       '_lft',
       '_rgt',
       'sort',
       'status',
       'hidden',
       'featured',
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}