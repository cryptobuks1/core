<?php

namespace App\Modules\Language\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'code',
        'flag',
        'default',
        'status',
        'hreflang',
        'charset',
        'sort'

    ];


}