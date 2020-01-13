<?php

namespace App\Modules\Hotels\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TourImages extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tour_images';
    protected $fillable = [
        'module',
        'name',
        'tour_id',
    ];



}
