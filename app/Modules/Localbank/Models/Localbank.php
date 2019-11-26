<?php

namespace App\Modules\Localbank\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Localbank extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'localbanks';
    protected $fillable = [
        'code','name', 'acc_num', 'acc_name','branch','paygate_code', 'paygate', 'card_num', 'link', 'info', 'icon', 'deposit', 'withdraw', 'status', 'sort'
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}