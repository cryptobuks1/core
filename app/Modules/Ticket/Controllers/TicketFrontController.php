<?php

namespace App\Modules\Ticket\Controllers;

use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use App;
use App\Modules\Ticket\Models\Ticket;
use Illuminate\Routing\Route;
use App\User;
use Carbon\Carbon;


class TicketFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index(){

        $title = 'Gửi yêu cầu';
        $submit = 'Gửi yêu cầu';
        $myform = static::renderform($title, $submit);
        return theme_view('pages.ticket', compact('myform'));
    }

    public static function renderform($title, $submit){

        $lang = App::getLocale();
        $other_infos = \App\Modules\Ticket\Models\TicketField::where('lang', $lang)->where('status', 1)->get();
        return theme_view('widgets.ticket-render', compact('other_infos','title', 'submit'))->render();
    }

    public function postrequest(Request $request){
        $this->validate($request, [
           'name' => 'required',
           'phone' => 'required|numeric',
        ]);

        $sendform = new Ticket;
        $sendform->title = strip_tags($request->title);
        $sendform->name = strip_tags($request->name);
        $sendform->code = 'HW'. time() . mt_rand(1000, 9999);
        $sendform->phone = strip_tags($request->phone);
        if($request->has('email')){
            $sendform->email= strip_tags($request->email);
        }

        $other_info = $request->other_info;
        if($request->has('other_info')){
            $sendform->other_info = $other_info;

            if(isset($other_info['address'])){
                $sendform->address = $other_info['address'];
            }

            if(isset($other_info['city'])){
                $sendform->city = $other_info['city'];
            }

        }
        if($request->has('current_url')){
            $sendform->current_url = strip_tags(base64_decode($request->current_url));
        }
        $sendform->message = strip_tags($request->message);
        $sendform->user = (Auth::check()) ? Auth::user()->id : null;
        $sendform->lang = App::getLocale();
        $sendform->save();

        return redirect()->route('home')->with('success', 'Gửi yêu cầu thành công');
    }
}
