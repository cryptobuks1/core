<?php

namespace App\Modules\Setting\Helpers;

use DB;
use Log;
use App\Modules\Upload\Models\Upload;

class SettingHelper
{

	public static function img($upload_id, $set='') {
        $upload = Upload::find($upload_id);
        if(isset($upload->id)) {
            return url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name.'?s='.$set);
        } else {
			return "";
		}
    }

}