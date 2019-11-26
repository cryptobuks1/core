<?php

namespace App\Modules\Product\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'product_option_value';
    protected $fillable = [
        'option_id',
        'option_name',
        'name',
        'sku',
        'price',
        'sort_order',
        'product_id',
        'lang',
        'status',
    ];

    protected $casts = [
        'price' => 'array',
    ];
}