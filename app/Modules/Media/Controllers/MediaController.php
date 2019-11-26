<?php

namespace App\Modules\Media\Controllers;

use App\Modules\Backend\Controllers\BackendController;

class MediaController extends BackendController
{
    public function index()
    {
        return view("Media::index");
    }
}