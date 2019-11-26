<?php

namespace App\Modules\Categories\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'category';
    protected $fillable = [
    	// 'id',
		'name',
		'url_key',
        'description',
        'parent_id',
        'level',
        'custom_layout',
        'children_count',
		'sort_order',
		'status',
		// 'created_at',
		// 'updated_at',
    ];

    public function childs() {
        return $this->hasMany('App\Modules\Categories\Models\Categories','parent_id','id') ;
    }
}