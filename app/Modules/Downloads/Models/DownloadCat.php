<?php

namespace App\Modules\Downloads\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class DownloadCat extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'download_cat';
    protected $fillable = [
        // 'id',
        'name'
        // 'created_at',
        // 'updated_ad',
    ];

    /**
     * Get gallery for the product.
     */


}
