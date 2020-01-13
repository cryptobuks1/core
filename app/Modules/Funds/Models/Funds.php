<?php

namespace App\Modules\Funds\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Funds extends Model
{



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'funds';
    protected $fillable = [
        'name', 'acc_number', 'acc_name','type','bank_code', 'balance',
    ];
    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
