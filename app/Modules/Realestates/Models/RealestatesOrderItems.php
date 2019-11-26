<?php

namespace App\Modules\Realestates\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class RealestatesOrderItems extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'realestates_order_items';
    protected $casts=[
        'note'=>'array'
    ];
    /**
     * Get gallery for the product.
     */
    ///Hàm lấy danh sách loại thẻ đã mua
    public function orderItems($order_code)
    {
        $items = Orders::where(['order_code' => $order_code, 'payment' => 'none'])->get();
        return $items;
    }

    ///Hàm lấy kết quả sau khi đơn hàng hoàn thành
    public function orderResults($order_code)
    {

    }

}
