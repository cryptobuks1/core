<?php

namespace App\Modules\Tours\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TourSchedules extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tour_schedules';
    protected $fillable = [
        'place',
        'tour_id',
        'description',
        'sort',
    ];
}
