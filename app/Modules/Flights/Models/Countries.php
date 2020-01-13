<?php

namespace App\Modules\Flights\Models;

use App\Modules\Currency\Models\Currencies;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'countries';

}
