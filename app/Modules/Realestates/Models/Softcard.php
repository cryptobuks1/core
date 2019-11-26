<?php

namespace App\Modules\Softcard\Models;

use App\Modules\Group\Models\Group;
use App\Modules\Stockcard\Models\Stockcard;
use App\Modules\Wallet\Models\Wallet;
use App\User;
use League\Flysystem\Exception;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class Softcard extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'softcard';
    protected $fillable = [

        'name',
        'url_key',
        'service_code',
        'image',
        'short_description',
        'description',
        'status',
        'discount_in'

    ];


    public static function getProductName($order_code)
    {

        $sp = SoftcardOrder::where('order_code', $order_code)->select('product', 'qty')->get();
        if (count($sp) > 0) {
            $list = '';
            foreach ($sp as $item) {
                $list .= $item->qty . ' ' . $item->product . '<br>';
            }
        } else {
            $list = '';
        }

        return $list;
    }

    public static function getProductNameWithLink($order_code)
    {

        $sp = SoftcardOrder::where('order_code', $order_code)->select('id', 'product', 'qty')->get();
        if (count($sp) > 0) {
            $list = '';
            foreach ($sp as $item) {

                $list .= "<a class='view-childsoftcard-btn' data-id='$item->id' href='#'>" . $item->qty . ' ' . $item->product . '</a><br>';
            }
        } else {
            $list = '';
        }

        return $list;
    }


    /**
     * Get items for the softcard.
     */
    public function items()
    {
        return $this->hasMany(
            'App\Modules\Softcard\Models\SoftcardItem',
            'softcard_id',
            'id'
        );
    }

    /**
     * Get discounts for the softcard.
     */
    public function discounts()
    {
        return $this->hasManyThrough(
            'App\Modules\Softcard\Models\SoftcardDiscount',
            'App\Modules\Softcard\Models\SoftcardItem',
            'softcard_id',
            'item_id',
            'id',
            'id'
        );
    }

    /**
     * Get item prices for the softcard.
     */
    public function prices()
    {
        return $this->hasManyThrough(
            'App\Modules\Softcard\Models\SoftcardPrice',
            'App\Modules\Softcard\Models\SoftcardItem',
            'softcard_id',
            'item_id',
            'id',
            'id'
        );
    }

    /**
     * Get categories for the softcard.
     */
    public function categories()
    {
        return $this->hasMany(
            'App\Modules\Softcard\Models\SoftcardCategories',
            'product_id',
            'id'
        );
    }

    /**
     * Get gallery for the softcard.
     */
    public function gallery()
    {
        return $this->hasMany(
            'App\Modules\Softcard\Models\SoftcardGallery',
            'product_id',
            'id'
        );
    }

    ///Hàm lấy danh sách loại thẻ đã mua
    public function orderItems($order_code)
    {
        $items = SoftcardOrder::where(['order_code' => $order_code, 'payment' => 'none'])->get();
        return $items;
    }

    ///Hàm lấy kết quả sau khi đơn hàng hoàn thành
    public function orderResults($order_code)
    {
        $cards = \App\Modules\Softcard\Models\SoftcardPurchased::where('order_code', $order_code)->get();

        if (count($cards) > 0) {
            return $cards;
        } else {
            return null;
        }
    }


    /// Hàm lấy thẻ
    public static function getCard($softcard_item)
    {

        $path = app_path('Modules//Stockcard//Providers');
        if (!file_exists($path . '/' . $softcard_item->provider . '/' . $softcard_item->provider . '.php')) {
            return false;
        } else {
            $classPath = '\App\Modules\Stockcard\Providers\\' . $softcard_item->provider . '\\' . $softcard_item->provider;

            $CardService = new $classPath;

            //// downloadCard là hàm chuẩn để lấy thẻ cào về. Được xây dựng ở mỗi provider

            $response = $CardService->downloadCard($softcard_item);

            return $response;
        }


    }


    public function updateCheckout($order)
    {

        ///Trả thẻ cho đơn hàng con
        $orderSuccess = SoftcardOrder::where('order_code', $order->order_code)->where('shipment', 0)->get();

        if (!count($orderSuccess) > 0) {
            return false;
        }

        $ketqua = array();
        $output = array();
        if ($order->payment == 'paid') {

            /// Update trạng thái thanh toán cho đơn hàng con
            foreach ($orderSuccess as $key => $softcard_item) {

                $softcard_item->payment = 'paid';
                $softcard_item->update();

                $result = $this->getCard($softcard_item);

                if ($result === true) {
                    $ketqua[$key] = 1;

                } else {
                    $ketqua[$key] = 0;
                }

            }

            if (!in_array(0, $ketqua)) {
                $order->update(['status' => 'completed']);

                $output['order_code'] = $order->order_code;
                $output['redirect'] = 'frontend.softcard.success';
                $output['message'] = 'Đơn hàng thành công. Xin cảm ơn!';


            } else {
                $output['order_code'] = $order->order_code;
                $output['redirect'] = 'frontend.softcard.success';
                $output['message'] = 'Đơn hàng của bạn chưa hoàn thành! Vui lòng đợi chúng tôi xuất thẻ!';
            }

        }else{
            $output['order_code'] = $order->order_code;
            $output['redirect'] = 'frontend.softcard.success';
            $output['message'] = 'Đơn hàng của bạn chưa được thanh toán!';
        }


        return $output;
    }


}
