<?php

namespace App\Modules\Product\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Product\Models\Product;

class ProductPrice extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'product_price';
    protected $fillable = [
        // 'id',
        'group',
        'product_id',
        'price',
        'currency_id',
        'currency_code',
        'checksum',
    ];
    public function getPrice($group,$pro_id){
        return $this->where('group',$group)->where('product_id',$pro_id)->first();
    }

}