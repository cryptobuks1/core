<?php

namespace App\Modules\Block\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class BlockContent extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'block_content';
    protected $fillable = [
        'block',
        'lang',
        'title',
        'image',
        'icon',
        'info',
        'data',
        'url',
        'status',
        'sort',
    ];
    protected $casts = [
        'data' => 'array',
    ];

    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}