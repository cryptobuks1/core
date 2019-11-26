<?php

namespace App\Modules\Sms\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'text', 'secret', 'verified', 'user_id','modulename', 'model_id', 'type', 'expired_at', 'log'
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


}
