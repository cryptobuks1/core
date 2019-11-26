<?php

namespace App\Modules\Language\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'languages_trans';
    protected $fillable = [
        'lang_code',
        'lang_key',
        'filename',
        'key',
        'content',
        'type'
    ];


}