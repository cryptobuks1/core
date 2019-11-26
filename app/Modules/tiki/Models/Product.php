<?php

namespace App\Modules\tiki\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'product';
    protected $fillable=['title'];


    /**
     * Get gallery for the product.
     */


}
