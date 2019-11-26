<?php

namespace App\Modules\Vote\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table= 'votes';
    protected $fillable=[
        'point',
        'user_id',
        'name',
        'module',
        'model_id',
        'ip',
        'comments',
        'user_data'
    ];
    protected $casts = [
        'user_data' => 'array'
    ];


}
