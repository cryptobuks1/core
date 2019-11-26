<?php

namespace App\Modules\Sliders\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'sliders';
    protected $fillable = [
        // 'id',
        'slider_name',
        'slider_image',
        'slider_text',
        // 'slider_url',
        'slider_btn_text',
        'slider_btn_url',
        'sort_order',
        'status',
        // 'created_at',
        // 'updated_at'
    ];
}