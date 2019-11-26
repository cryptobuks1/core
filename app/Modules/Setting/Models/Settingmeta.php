<?php

namespace App\Modules\Setting\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Settingmeta extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'settings_meta';
    protected $fillable = [

        'meta_title',
        'meta_description',
        'meta_keywords',
        'description',
        'language',
        'h1',
        'module'

    ];
}