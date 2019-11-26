<?php

namespace App\Modules\Localbank\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class LocalbankUser extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'localbanks_user';
    protected $fillable = [
        'code', 'acc_num', 'acc_name', 'branch', 'card_num', 'paygate_code', 'approved', 'user_id'
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}