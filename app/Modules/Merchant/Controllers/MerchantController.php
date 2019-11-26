<?php

namespace App\Modules\Merchant\Controllers;

use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use App\Modules\Merchant\Models\Merchant;


class MerchantController extends BackendController
{

	public function index(Request $request)
	{
		$title    = "Quản lý đối tác API";
        $merchants = Merchant::orderBy('id','DESC')->paginate(25);
		if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Tìm: ".$keyword;
            $merchants = Merchant::where('user', $keyword)->orWhere('partner_id', 'LIKE', '%'.$keyword.'%')->orWhere('wallet_num', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(25);
        }
		return view("Merchant::index", compact('title','merchants'));
	}

	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
        	$title    = "Quản lý đối tác API";
            return view('Merchant::create',compact('title'));
        }else{
            echo 'Not Access';
            return false;
        }
	}

	public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user' => 'required',
            'partner_id' => 'required',
            'partner_key' => 'required',
            'wallet_num' => 'required'
        ]);


        $input = $request->all();

        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;

        Merchant::create($input);
        return redirect()->route('merchants.index')
                        ->with('success','Tạo đối tác API thành công!');
    }

    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {

            $title    = "Quản lý đối tác API";
        	$merchant  = Merchant::find($id);
            return view('Merchant::edit',compact('title','merchant'));
        }else{
            echo 'Not Access';
            return ;
        }
	}

	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'user' => 'required',
            'partner_id' => 'required',
            'partner_key' => 'required',
            'wallet_num' => 'required'
        ]);

        $merchant = Merchant::find($id);
        if(isset($request->status))
        {
        	$merchant->status = 1;
        }else{
        	$merchant->status = 0;
        }
        $merchant->name = $request->name;
        $merchant->user = $request->user;
        $merchant->partner_id = $request->partner_id;
        $merchant->partner_key  = $request->partner_key;
        $merchant->wallet_num  = $request->wallet_num;
        if(isset($request->ips))
        {
            $merchant->ips = trim($request->ips);
        }else{
            $merchant->ips = null;
        }
        $merchant->callback  = $request->callback;
        $merchant->callback_type  = $request->callback_type;
        $merchant->description  = $request->description;
        $merchant->created_at  = now();
        $merchant->updated_at  = now();
        $merchant->save();
        return redirect()->route('merchants.index')
                        ->with('success','Sửa đối tác API thành công!');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
        	Merchant::find($id)->delete();
            return redirect()->route('merchants.index')
                        ->with('success','Xóa đối tác API thành công');
        }else{
            return redirect()->route('merchants.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

}