<?php

namespace App\Modules\Tool\Controllers;

use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use Illuminate\Routing\Route;
use App\User;
use Carbon\Carbon;


class ToolFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();

    }

}
