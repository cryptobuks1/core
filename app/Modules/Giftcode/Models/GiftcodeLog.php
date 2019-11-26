<?php

namespace App\Modules\Giftcode\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class GiftcodeLog extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'giftcode_logs';
    protected $fillable = [
        'code',
        'user_id',
        'model',
        'logs',
        'sku',
        'status',
        'checksum',
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}