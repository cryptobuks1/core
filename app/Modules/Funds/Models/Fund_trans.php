<?php

namespace App\Modules\Funds\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Fund_trans extends Model
{



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'fund_trans';
    protected $casts=[
        'sender_info'=>'array',
        'receiver_info'=>'array',
    ];
    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
