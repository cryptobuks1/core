<?php

namespace App\Modules\Product\Helpers;

use App\Modules\Merchant\Models\Merchant;
use App\Modules\Order\Models\Order;
use App\Modules\User\Models\User as UserModel;
use App\Modules\Wallet\Models\Wallet;
use DB;
use Log;

class ProductHelper
{
    public static function checkAvailable($qty, $provider, $sku, $value)
    {
        ///Lấy sku nhà cung cấp
        try {
            if ($provider === 'Stock' || $provider === 'Preorder') {
                $provider_sku = $sku;
            } else {
                $sku_obj = Inventory::where('product_sku', $sku)->where('stock_provider', $provider)->first();

                $provider_sku = $sku_obj->key;
            }

            $classPath = '\App\Modules\Stockcard\Providers\\' . $provider . '\\' . $provider;
            $CardService = new $classPath;

            $check = $CardService->getQuantity($qty, $provider_sku, $value);

            if ($check === 'INSTOCK') {
                return 'INSTOCK';
            } elseif($check ==='OUTSTOCK') {
                return 'OUTSTOCK';
            }else{
                return $check;
            }
        } catch (\Exception $e) {
            return 308;
        }

    }



}
