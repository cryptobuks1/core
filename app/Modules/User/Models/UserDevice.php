<?php

namespace App\Modules\User\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'device_id',
        'version',
        'user_agent',
        'verified',
        'verified_at',
    ];


}
