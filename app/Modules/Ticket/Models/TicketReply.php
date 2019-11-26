<?php

namespace App\Modules\Ticket\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'ticket_reply';
    protected $fillable = [
       'ticket_id',
        'ticket_code',
        'reply',
        'user',
        'user_name',
        'user_email',
        'user_phone',
        'file',
    ];

    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}