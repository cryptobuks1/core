<?php

namespace App\Modules\Affiliate\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'affiliates';
    protected $fillable = [
        'user_id',
        'user_name',
        'order_code',
        'affiliate_code',
        'description',
        'ip',
        'module',
        'type',
        'percent',
        'fixed',
        'currency_id',
        'currency_code',
        'order_price',
        'amount',
        'status',
        'payment_at',
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}