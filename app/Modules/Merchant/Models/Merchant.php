<?php

namespace App\Modules\Merchant\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'user', 'partner_id','partner_key','wallet_num', 'ips', 'callback', 'callback_type', 'description', 'status'
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}