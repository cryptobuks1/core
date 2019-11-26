<?php

namespace App\Modules\Giftcode\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Giftcode extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'code',
        'prefix',
        'model',
        'sku',
        'currency_id',
        'currency_code',
        'value',
        'discount',
        'status',
        'active',
        'user',
        'used_time',
        'premiumday',
        'logs',
        'expired_at',
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}