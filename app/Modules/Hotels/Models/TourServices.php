<?php

namespace App\Modules\Hotels\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TourServices extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tour_services';
    protected $fillable = [
        'name',
        'sku',
        'module',
        'status',
    ];
}
