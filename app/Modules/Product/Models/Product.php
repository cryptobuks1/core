<?php

namespace App\Modules\Product\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasRoles;

    const PRODUCT_INSTOCK = 1;
    const PRODUCT_OUTSTOCK = 0;
    const PRODUCT_TYPE_DEFAULT = 'product';
    const PRODUCT_OPTIONS_TYPE = array(
        'radio' => 'Radio Button',
        'checkbox' => 'Check Box',
        'select' => 'Drop Down',
        'multi' => 'Multi Select',
        'input' => 'Input text',
        'inputnum' => 'Input number',
    );

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'product';
    protected $fillable = [
        // 'id',
        'name',
        'cats',
        'product_uri',
        'product_slug',
        'sku',
        'barcode',
        'short_description',
        'description',
        'price',
        'listedprice',
        'custom_layout',
        'inputprice',
        'special_start_date',
        'special_end_date',
        'qty',
        'is_instock',
        'hotdeal',
        'bestsales',
        'new',
        'status',
        'product_branded',
        'weight',
        'volume',
    ];

    protected $casts = [
        'cats' => 'array',
        'price' => 'array',
        'listedprice' => 'array',
        'inputprice' => 'array',
    ];

    /**
     * Get gallery for the product.
     */
    public function gallery()
    {
        return $this->hasMany(
            'App\Modules\Product\Models\ProductGallery',
            'product_id',
            'id'
        );
    }

    /**
     * Get options for the product.
     */
    public function options()
    {
        return $this->hasMany(
            'App\Modules\Product\Models\ProductOption',
            'product_id',
            'id'
        );
    }

    /**
     * Get categories for the product.
     */
    public function categories()
    {
        return $this->hasMany(
            'App\Modules\Product\Models\ProductCategories',
            'product_id',
            'id'
        );
    }

    public function getProductThumb($pid){
        $thumb = \App\Modules\Product\Models\ProductGallery::where('product_id',$pid)
                                ->where('product_type',self::PRODUCT_TYPE_DEFAULT)
                                ->where('is_thumb',1)
                                ->where('status',1)
                                ->first();
        if(!$thumb)
        $thumb = \App\Modules\Product\Models\ProductGallery::where('product_id',$pid)
                                ->where('product_type',self::PRODUCT_TYPE_DEFAULT)
                                ->where('status',1)
                                ->first();
        if($thumb)
            return $thumb;   
        else
            return false;
    }


    public function orderItems($order_code)
    {
        $items = ProductOrder::where(['order_code' => $order_code, 'payment' => 'none'])->get();
        return $items;
    }


    public function updateCheckout($order)
    {

        $orderSuccess = ProductOrder::where('order_code', $order->order_code)->where('shipment', 0)->get();

        if (!count($orderSuccess) > 0) {
            return false;
        }

        $output = array();
        if ($order->payment == 'paid') {

            /// Update trạng thái thanh toán cho đơn hàng con
            foreach ($orderSuccess as $key => $p_item) {
                $p_item->payment = 'paid';
                $p_item->update();
            }

            $output['order_code'] = $order->order_code;
            $output['redirect'] = 'home';
            $output['message'] = 'Đơn hàng đã được thanh toán thành công. Xin cảm ơn!';

        }else{
            $output['order_code'] = $order->order_code;
            $output['redirect'] = 'home';
            $output['message'] = 'Đơn hàng của bạn chưa được thanh toán!';
        }


        return $output;
    }



}