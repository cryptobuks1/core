<?php

namespace App\Modules\Categories\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class CategoriesProduct extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'category_product';
    protected $fillable = [
        // 'id',
        'category_id',
        'product_id',
        'product_type',
        'sort_order',
        // 'created_at',
        // 'updated_ad',
    ];
}