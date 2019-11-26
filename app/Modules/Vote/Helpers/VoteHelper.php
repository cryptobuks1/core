<?php

namespace App\Modules\Vote\Helpers;

use App\Modules\Merchant\Models\Merchant;
use App\Modules\Order\Models\Order;
use App\Modules\User\Models\User as UserModel;
use App\Modules\Vote\Models\VoteProduct;
use App\Modules\Vote\Models\Votes;
use App\Modules\Wallet\Models\Wallet;
use DB;
use Log;

class VoteHelper
{
   public static function created($data){
        if (!isset($data['user_id']) || !isset($data['point']) || !isset($data['model_id']) || !isset($data['module']) || !isset($data['name'])){
                return false;
        }
        $vote = Votes::where('user_id',$data['user_id'])->where('model_id',$data['model_id'])->where('module',$data['module'])->first();
        if ($vote){
            return false;
        }
        try{
        $vote = new Votes();
        $vote->user_id = $data['user_id'];
        $vote->model_id = $data['model_id'];
        $vote->module = $data['module'];
        $vote->point = $data['point'];
        $vote->name = $data['name'];
        $vote->comments = isset($data['comments'])?$data['comments']:null;
        $vote->user_data = isset($data['user_data'])?$data['user_data']:null;
        $vote->ip = isset($data['ip'])?$data['ip']:null;
        $vote->save();
        return $vote;
        }catch (\Exception $ex){
            return false;
        }
   }
   public static function updatePercentVote($module,$model_id){
        $precent = VoteProduct::where('module',$module)->where('model_id',$model_id)->first();
        $vote = Votes::where('module',$module)->where('model_id',$model_id)->get();
        $vote_1s = Votes::where('module',$module)->where('model_id',$model_id)->where('point',1)->count();
        $vote_2s = Votes::where('module',$module)->where('model_id',$model_id)->where('point',2)->count();
        $vote_3s = Votes::where('module',$module)->where('model_id',$model_id)->where('point',3)->count();
        $vote_4s = Votes::where('module',$module)->where('model_id',$model_id)->where('point',4)->count();
        $vote_5s = Votes::where('module',$module)->where('model_id',$model_id)->where('point',5)->count();
        $avg = $vote->avg('point');
        if (!$precent){
            $precent = new VoteProduct();
            $precent->module = $module;
            $precent->model_id = $model_id;
        }
        $precent->percent_1s = $vote_1s/count($vote)*100;
        $precent->percent_2s = $vote_2s/count($vote)*100;
        $precent->percent_3s = $vote_3s/count($vote)*100;
        $precent->percent_4s = $vote_4s/count($vote)*100;
        $precent->percent_5s = $vote_5s/count($vote)*100;
        $precent->score_avg = $avg;
        $precent->save();
        return $precent;
   }
   public static function replyComment($id,$model_id){

   }
}
