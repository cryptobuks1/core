<?php

namespace App\Modules\Weblink\Controllers;

use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use App\Modules\Weblink\Models\Weblink;


class WeblinkController extends BackendController
{

	public function index(Request $request)
	{
		$title    = "Trao đổi Banner";
		$weblinks = Weblink::orderBy('id','DESC')->paginate(40);
		if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $weblinks = Weblink::where('name', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(40);
        }
		return view("Weblink::index", compact('title','weblinks'));
	}

	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
        	$title    = "Weblinks Management";
            return view('Weblink::create',compact('title'));
        }else{
            echo 'Not Access';
            return ;
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


        Weblink::create($input);
        return redirect()->route('weblinks.index')
                        ->with('success','Weblink created successfully');
    }

    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {

            $title    = "Trao đổi Banner";
        	$weblink  = Weblink::find($id);
            return view('Weblink::edit',compact('title','weblink'));
        }else{
            echo 'Not Access';
            return ;
        }
	}

	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'sort' => 'numeric'
        ]);

        $weblink = Weblink::find($id);
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
        	Weblink::find($id)->delete();
            return redirect()->route('weblinks.index')
                        ->with('success','Weblink deleted successfully');
        }else{
            return redirect()->route('weblinks.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

}