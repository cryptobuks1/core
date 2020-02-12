<?php

namespace App\Modules\User\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'token',
        'user_id',
        'description',
        'image',
        'size',
        'extension',
        'album',
        'cat',
        'sort',
        'type',
        'admin'
    ];


}
