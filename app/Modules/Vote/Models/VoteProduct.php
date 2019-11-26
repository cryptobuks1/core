<?php

namespace App\Modules\Vote\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class VoteProduct extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table= 'vote_product';
    protected $fillable=[
        'module',
        'model_id',
        'percent_1s',
        'percent_2s',
        'percent_3s',
        'percent_4s',
        'percent_5s',
        'score_avg'
    ];

}
