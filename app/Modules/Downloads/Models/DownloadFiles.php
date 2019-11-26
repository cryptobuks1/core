<?php

namespace App\Modules\Downloads\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class DownloadFiles extends Model
{
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'download_files';
    public function downloads(){
        return $this->belongsTo('App/Modules/Downloads/Models/Downloads');
    }
    protected $fillable = ['filename', 'download_id','user_id','file_extension','file_description'];


    /**
     * Get gallery for the product.
     */


}
