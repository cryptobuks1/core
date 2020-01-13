<?php

namespace App\Modules\Funds\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Fund_type extends Model
{



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'fund_type';
    protected $fillable=['name','type'];
    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
