<?php

namespace App\Modules\Ticket\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'ticket';
    protected $fillable = [
        'name',
        'title',
        'phone',
        'email',
        'address',
        'city',
        'message',
        'lang',
        'file',
        'other_info',
        'current_url',
        'user',
    ];

    protected $casts = [
        'other_info' => 'array',
    ];

    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}