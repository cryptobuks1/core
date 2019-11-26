<?php

namespace App\Modules\Tags\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Tagslist extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'tags';
    protected $fillable = [
        'code',
        'label',
        'module',
        'model',
        'model_id',
        'checksum',
        'description',
        'author',
        'status'
    ];
}