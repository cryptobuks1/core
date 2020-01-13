<?php

namespace App\Modules\Price\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'price';
    public $timestamps = false;
    protected $fillable = [
        'module',
        'model',
        'model_id',
        'sku',
        'group',
        'price',
        'period',
        'currency_id',
        'currency_code',
        'symbol',
        'type',
        'checksum'

    ];


    public static function addPrice(array $data){
        $price = new Tourdetails;

        if(!isset($data['module']) ||  !isset($data['sku']) ||  !isset($data['group']) ||  !isset($data['price'])
            ||  !isset($data['type']) ||  !isset($data['currency_id'])  ||  !isset($data['model_id']) ){
            return false;
        }

        if($data['type'] == 'circle'){
            if(!isset($data['period'])){
                return false;
            }
        }

        $currency = Currencies::find($data['currency_id']);
        if(!$currency){
            return false;
        }

        $price->module = $data['module'];
        $price->model = (isset($data['model'])) ? $data['model'] : '';
        $price->model_id = $data['model_id'];
        $price->group = $data['group'];
        $price->price = $data['price'];
        $price->type = $data['type'];
        $price->sku = $data['sku'];
        $price->period = (isset($data['period'])) ? $data['period'] : '';
        $price->currency_id = $data['currency_id'];
        $price->currency_code = $currency->code;
        $price->symbol = (isset($currency->symbol_left)) ? $currency->symbol_left : $currency->symbol_right;
        $price->checksum = md5($price->module.$price->model_id.$price->sku.$price->currency_id.$price->type.$price->group.$price->period);

        if (!Tourdetails::where('checksum', $price->checksum)->first()) {
            $price->save($price->module);

            return true;
        }else{
            return false;
        }

    }



}
