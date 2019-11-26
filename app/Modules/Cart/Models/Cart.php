<?php

namespace App\Modules\Cart\Models;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $items;
    protected $table = 'cart';
    protected $fillable = [
        'identifier', 'instance','content'
    ];
    
}