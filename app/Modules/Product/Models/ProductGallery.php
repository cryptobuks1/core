<?php

namespace App\Modules\Product\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Product\Models\Product;

class ProductGallery extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'product_gallery';
    protected $fillable = [
        // 'id',
        'product_id',
        'product_type',
        'value',
        'label',
        'is_thumb',
        'sort_order',
        'status',
    ];
    public function getImageFirst($id){
        $gallery = Product::find($id)->gallery()
            ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
            ->orderBy('sort_order','ASC')
            ->first();
        if ($gallery){
            return $gallery->value;
        }else{
            return null;
        }
    }
    public function getAvatar($id){
        $gallery = $this->where('product_type','product')->where('product_id',$id)->where('is_thumb',1)->first();
        if ($gallery){
            return $gallery->value;
        }
        return false;
    }

}