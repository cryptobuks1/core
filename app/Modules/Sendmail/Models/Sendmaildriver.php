<?php

namespace App\Modules\Sendmail\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Sendmaildriver extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'sendmail_driver';
    protected $fillable = [ 'name', 'driver', 'configs', 'status'

    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}