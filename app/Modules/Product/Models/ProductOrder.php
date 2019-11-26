<?php

namespace App\Modules\Product\Models;

use App\Modules\Inventory\Models\Inventory;
use App\Modules\Merchant\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Modules\Product\Models\Product;


class ProductOrder extends Model
{
    protected $table = 'product_orders';
    protected $fillable = [
        'order_code',
        'product',
        'product_id',
        'product_type',
        'value',
        'order_id',
        'price',
        'qty',
        'sumvalue',
        'discount',
        'subtotal',
        'currency_id',
        'currency_code',
        'user',
        'user_info',
        'status',
        'payment',
        'cart_content',
        'shipment',
        'shipment_info',
        'provider',
        'provider_request',
        'provider_trans',
        'logs',
        'merchant_logs',
        'views',
        'request_id',
        'partner_id',
        'method',

    ];

}
