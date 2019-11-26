<?php

namespace App\Modules\Notification\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table = 'notification';
    protected $fillable = [
        // 'id',
        'module',
        'message',
        'status',
    ];

    public static function setNotification($message,$module=''){
        $notification = static::where('status',0)->where('module',$module)->where('message',$message)->count();
        if(!$notification){
            $notification = static::create([
                            'module' => $module,
                            'message' => $message,
                            'status' => 0
                        ]);
        }
        return $notification;
    }

    public static function getNotification($module='',$limit=0){
        $notification = static::where('status',0);
        if($module!=''){
            $notification->where('module',$module);
        }
        if($limit>0){
            $notification->limit($limit);
        }
        $result = $notification->get();
        $notification->delete();
        return $result;
    }
}
