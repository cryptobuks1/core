<?php

namespace App\Modules\Group\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Group extends Model
{
    protected $fillable = [
       'name','description', 'status', 'hideit'
    ];


}