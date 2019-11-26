<?php

namespace App\Modules\Vote\Controllers;

use App\Modules\Vote\Helpers\VoteHelper;
use App\Modules\Vote\Models\ReplyComment;
use App\Modules\Vote\Models\VoteProduct;
use App\Modules\Vote\Models\Votes;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use Log;
use File;
use Lang;
use Cookie;
use GeoIp2\Database\Reader;
use Illuminate\Routing\Route;
use App\User;
use Carbon\Carbon;
use Session;

class VoteFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function getRating()
    {
        $user_id = Auth::user()->id;
        Cookie::queue('user_data', $user_id, 120);

        $avgStar = Votes::avg('point');
        return view('Vote::rating',compact('avgStar','user_id'));

    }
    public function postRating(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'comment' => 'required',
            'model_id' => 'required',
            'point' => 'required',
        ]);

        if (!Auth::check()){
            return redirect()->route('frontend.account.login');
        }

        $data = $request->all();
        $user_id = Auth::user()->id;
        $ip = getIpClient();
            $vote_check = Votes::where('user_id',$user_id)->where('model_id',$request->model_id)->first();
            if(!$vote_check){
                $data['module'] = 'Product';
                $data['ip'] = $ip;
                $data['user_id'] = $user_id;
                $vote = VoteHelper::created($data);
                if ($vote){
                    $precent = VoteHelper::updatePercentVote($vote->module,$vote->model_id);
                }
            }
        return redirect()->back()->with('success','Cảm ơn bạn đã đánh giá sản phẩm');
    }
    public function likeVote(Request $request){
        $vote = Votes::find($request->id);
        if (!$vote){
            return false;
        }
        if(!Session::has('like_vote_'.$request->id)){
            $vote->like = $vote->like +1;
            $vote->save();
            Session::put('like_vote_'.$request->id,true);
        }
        return $vote->like;
    }
    public function replyComment(Request $request){
        $this->validate($request, [
                'comment' => 'required',
                'name' => 'required',
                'comment_id' => 'required',
            ]);
        $vote = Votes::find($request->comment_id);
        if (!$vote){
            return redirect()->back()->withErrors('Lỗi phản hồi bình luận');
        }
        $data = $request->all();
        $data['model_id'] = $vote->model_id;
        $data['module'] = 'Product';
        $data['user_id'] = isset(Auth::user()->id)?Auth::user()->id:null;
        $create = ReplyComment::create($data);
        return redirect()->back()->with('success','Trả lời bình luận thành công');
    }



}
