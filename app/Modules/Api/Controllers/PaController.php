<?php

namespace App\Modules\Api\Controllers;

use App\Helpers\CurlHelper;
use App\Modules\Api\Models\Api;
use App\Modules\Backend\Controllers\BackendController;
use Auth;
use DB;



class PaController extends BackendController{

        public $config = [
            'post_url' => 'https://daily.pavietnam.vn/interface_test.php',
            'api_key' => 'b87a076bfe6a9cbcf63d2d10b097f8ed',
            'username'	=> USERNAME,//Username đại lý

        ];
}
