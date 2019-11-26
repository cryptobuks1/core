<?php

namespace App\Modules\Product\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'product_brands';
    protected $fillable = [
        'name',
        'image',
        'description',
        'status',
        'cat_id',
        'slug'
    ];
    protected $casts = [
        'cat_id'=>'array',
    ];
    public function getById($id){
        return $this->find($id);
    }
}