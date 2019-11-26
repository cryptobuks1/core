<?php

namespace App\Modules\Sms\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class SmsProvider extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sms_provider';
    protected $fillable = [
        'name', 'provider','configs','status','installed'
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


}
