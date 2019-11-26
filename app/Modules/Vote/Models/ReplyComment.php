<?php

namespace App\Modules\Vote\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table= 'reply_comments';
    protected $fillable=[
        'module',
        'model_id',
        'comment_id',
        'comment',
        'like',
        'name',
        'user_id',
    ];
    public static function create($data){
        if (!isset($data['model_id']) || !isset($data['module']) || !isset($data['comment']) || !isset($data['comment_id']) || !isset($data['name'])){

                return false;
        }
        try{
           $reply = new ReplyComment();
           $reply->module = $data['module'];
           $reply->model_id = $data['model_id'];
           $reply->comment = $data['comment'];
           $reply->comment_id = $data['comment_id'];
           $reply->name = $data['name'];
           $reply->user_id = isset($data['user_id'])?$data['user_id']:null;
           $reply->save();
           return $reply;
        }catch (\Exception $ex){
            return false;
        }
    }

}
