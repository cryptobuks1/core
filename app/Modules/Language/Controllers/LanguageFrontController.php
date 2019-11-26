<?php

namespace App\Modules\Language\Controllers;

use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use App\User;
use Carbon\Carbon;


class LanguageFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();

    }



}
