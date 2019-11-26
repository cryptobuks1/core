<?php

namespace App\Modules\Realestates\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class GroupProject extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'realestates_project_group';


    /**
     * Get gallery for the product.
     */


}
