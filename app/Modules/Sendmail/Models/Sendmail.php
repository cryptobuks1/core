<?php

namespace App\Modules\Sendmail\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Sendmail extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'sendmail_setting';
    protected $fillable = [ 'from_email', 'from_name', 'driver'

    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}