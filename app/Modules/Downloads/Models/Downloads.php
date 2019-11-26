<?php

namespace App\Modules\Downloads\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Downloads extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'downloads';
    protected $fillable = [

        'name',
        'slug',
        'avatar',
        'filename'
        // 'created_at',
        // 'updated_ad',
    ];

    protected $casts = [
        'price' => 'array'
    ];

}
