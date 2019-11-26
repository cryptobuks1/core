<?php

namespace App\Modules\Twofactor\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Twofactor extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'twofactors';
    protected $fillable = [
        'object',
        'driver',
        'user_id',
        'secret',
        'text',
        'modulename',
        'model_id',
        'expired_at'
    ];

}