<?php

namespace App\Modules\Ticket\Controllers;

use App\Modules\Ticket\Models\TicketReply;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use Cache;
use App\Modules\Ticket\Models\Ticket;


class TicketController extends BackendController
{

	public function index(Request $request)
	{
		$title    = "Vé hỗ trợ";
		$tickets = Ticket::orderBy('updated_at','DESC')->paginate(40);
		if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Tìm: ".$keyword;
            $tickets = Ticket::where('code', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(40);
        }
		return view("Ticket::index", compact('title','tickets'));
	}

	public function viewticket($id){
	    $ticket = Ticket::find($id);
	    if(!$ticket){
	        return redirect()->back()->withErrors(['error' => 'Vé không tồn tại']);
        }
        $title = $ticket->code;
        $replies = TicketReply::where('ticket_id', $id)->orderBy('id', 'ASC')->paginate(25);
	    return view("Ticket::view", compact('title','ticket', 'replies'));

    }

    public function replyticket(Request $request){
	    $this->validate($request, [
	        'reply' => 'required',
	        'ticket' => 'required',
        ]);

	    $ticket = Ticket::find($request->ticket);
	    if(!$ticket){
            return redirect()->back()->withErrors(['error' => 'Vé không tồn tại']);
        }

        $setting = Cache::get('settings');

	    $reply = new TicketReply;
	    $reply->reply = $request->reply;
	    $reply->ticket_id = $ticket->id;
	    $reply->ticket_code = $ticket->code;
	    $reply->user = Auth::user()->id;
	    $reply->user_phone = $setting['phone'];
	    $reply->user_email = $setting['email'];
	    $reply->user_name = $setting['name'];
	    $reply->save();
        return redirect()->back()
            ->with('success','Trả lời thành công!');

    }

	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
        	$title    = "Form Management";
            return view('Form::create',compact('title'));
        }else{
            return 'Not Access';
        }
	}

	public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'sort' => 'numeric'
        ]);

        $input = $request->all();
        if($request->image){
            $imagelink = explode('storage',$request->image);
            $input['image'] = '/storage'.$imagelink[1];
        }


        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;


        Sendform::create($input);
        return redirect()->route('weblinks.index')
                        ->with('success','Weblink created successfully');
    }

    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {

            $title    = "Trao đổi Banner";
        	$weblink  = Sendform::find($id);
            return view('Weblink::edit',compact('title','weblink'));
        }else{
            return 'Not Access';
        }
	}

	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'sort' => 'numeric'
        ]);

        $weblink = Sendform::find($id);
        if(isset($request->status))
        {
        	$weblink->status = 1;
        }else{
        	$weblink->status = 0;
        }
        $weblink->name = $request->name;

        if($request->image){
            $imagelink = explode('storage',$request->image);
            $weblink->image = '/storage'.$imagelink[1];
        }

        $weblink->url  = $request->url;
        $weblink->description = $request->description;
        $weblink->sort = $request->sort;
        $weblink->save();
        return redirect()->route('weblinks.index')
                        ->with('success','Weblink updates successfully');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            Sendform::find($id)->delete();
            return redirect()->route('weblinks.index')
                        ->with('success','Weblink deleted successfully');
        }else{
            return redirect()->route('weblinks.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

}