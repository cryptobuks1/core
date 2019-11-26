<?php

namespace App\Modules\Slug\Controllers;

use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use App\Modules\Sliders\Models\Sliders;
use Storage;

class SlugController extends BackendController
{

    public function ajaxSlug(Request $request){

        $slugobj = new \App\Helpers\SlugHelper;
        $slug = $slugobj->slug($request->title);

        return $slug;
    }


}