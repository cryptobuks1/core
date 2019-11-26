<?php

namespace App\Modules\Product\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'product_option';
    protected $fillable = [
        'lang',
        'type',
        'name',
        'option_type',
        'sort_order',
        'is_required',
        'status',
    ];

    /**
     * Get values for the option.
     */
    public function values()
    {
        return $this->hasMany(
            'App\Modules\Product\Models\ProductOptionValue',
            'option_id',
            'id'
        );
    }
}