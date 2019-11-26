<?php

namespace App\Modules\Realestates\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class RealestatesImg extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'realestates_img';
    protected $fillable=['img','realestates_id','project_id'];


    /**
     * Get gallery for the product.
     */


}
