<?php

namespace App\Modules\Affiliate\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class AffiliateConfig extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'affiliates_config';
    protected $fillable = [
        'key',
        'value',
        'description',
    ];


    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}