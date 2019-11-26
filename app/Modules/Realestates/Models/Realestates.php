<?php

namespace App\Modules\Realestates\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Realestates extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'realestates';
    protected $fillable=['title'];


    /**
     * Get gallery for the product.
     */
    ///Hàm lấy danh sách loại thẻ đã mua
    public function orderItems($order_code)
    {
        $items = RealestatesOrderItems::where(['order_code' => $order_code, 'payment' => 'none'])->get();
        return $items;
    }

    public function updateCheckout($order)
    {
        $order->realestates_id;

        ///Trả thẻ cho đơn hàng con
        $orderSuccess = RealestatesOrderItems::where('order_code', $order->order_code)->where('shipment', 0)->get();
        $orderSuccess2 = RealestatesOrderItems::where('order_code', $order->order_code)->where('shipment', 0)->first();
        $data=Realestates::where('id',$orderSuccess2->realestates_id)->first();


        if (!count($orderSuccess) > 0) {
            return false;
        }
        $ketqua = array();
        $output = array();
        if ($order->payment == 'paid') {

            /// Update trạng thái thanh toán cho đơn hàng con
            foreach ($orderSuccess as $key => $softcard_item) {

                $softcard_item->payment = 'paid';
                $softcard_item->status = 'completed';
                $softcard_item->update();
            }

            if (!in_array(0, $ketqua)) {
                $data->type_news=$orderSuccess2->vip_level;
                $data->featured=1;
                $data->end_date=$orderSuccess2->vip_enddate;
                $data->start_date=$orderSuccess2->vip_startdate;
                $data->approved=1;
                $data->status=1;
                $data->save();
                $order->update(['status' => 'completed']);
                $output['order_code'] = $order->order_code;
                $output['redirect'] = 'tin.order';
                $output['message'] = 'Đăng tin vip thành công. Xin cảm ơn!';
            } else {
                $output['order_code'] = $order->order_code;
                $output['redirect'] = 'tin.order';
                $output['message'] = 'Đăng tin vip không thành công!';
            }

        }
            else{
            $output['order_code'] = $order->order_code;
            $output['redirect'] = 'tin.order';
            $output['message'] = 'Tin vip của bạn đã được thanh toán!';
        }
        return $output;
    }

}
