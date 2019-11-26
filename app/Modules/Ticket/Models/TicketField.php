<?php

namespace App\Modules\Ticket\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TicketField extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'ticket_fields';
    protected $fillable = [
       'key',
        'title',
        'placeholder',
        'value',
        'type',
        'lang',
        'status'
    ];

    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}