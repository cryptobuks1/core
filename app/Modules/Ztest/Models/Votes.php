<?php

namespace App\Modules\Ztest\Models;

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
        'point'
    ];


}
