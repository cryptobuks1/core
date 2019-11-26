<?php

namespace App\Modules\Localbank\Controllers;

use App\Modules\Localbank\Models\LocalbankUser;
use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use App\User;
use App\Modules\Localbank\Models\Localbank;


class LocalbankController extends BackendController
{

	public function index(Request $request)
	{
		$title    = "Quản lý ngân hàng nội địa";
		$localbanks = Localbank::orderBy('id','DESC')->paginate(20);
		if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $localbanks = Localbank::where('name', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(20);
        }
		return view("Localbank::index", compact('title','localbanks'));
	}

	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
        	$title    = "Quản lý ngân hàng nội địa";
            return view('Localbank::create',compact('title'));
        }else{
            echo 'Not Access';
            return ;
        }
	}

	public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'sort' => 'numeric',
            'icon' => 'required',
        ]);

        $input = $request->all();
        $input['paygate_code'] = 'Localbank_'.$request->code;
        $input['paygate'] = 'Localbank';

        if($request->has('icon')){
            $imagelink = explode('storage',$request->icon);
            $input['icon'] = '/storage'.$imagelink[1];
        }


        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;
        ( isset($input['deposit']) ) ? $input['deposit'] = 1 : $input['deposit'] = 0;
        ( isset($input['withdraw']) ) ? $input['withdraw'] = 1 : $input['withdraw'] = 0;

        Localbank::create($input);
        return redirect()->route('localbank.index')
                        ->with('success','Thêm ngân hàng thành công');
    }

    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {

            $title    = "Sửa ngân hàng";
        	$localbank  = Localbank::find($id);
            return view('Localbank::edit',compact('title','localbank'));
        }else{
            echo 'Not Access';
            return ;
        }
	}

	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'sort' => 'numeric'
        ]);

        $localbank = Localbank::find($id);
        if(isset($request->deposit))
        {
        	$localbank->deposit = 1;
        }else{
            $localbank->deposit = 0;
        }
        if(isset($request->withdraw))
        {
            $localbank->withdraw = 1;
        }else{
            $localbank->withdraw = 0;
        }
        if(isset($request->status))
        {
            $localbank->status = 1;
        }else{
            $localbank->status = 0;
        }
        $localbank->code = $request->code;
        $localbank->name = $request->name;
        $localbank->paygate_code = 'Localbank_'.$request->code;
        $localbank->paygate = 'Localbank';
        $localbank->acc_num = $request->acc_num;
        $localbank->card_num = $request->card_num;
        $localbank->acc_name = $request->acc_name;
        $localbank->branch = $request->branch;
        $localbank->link = $request->link;
        $localbank->info = $request->info;

        if($request->has('icon')){
            $imagelink = explode('storage',$request->icon);
            $localbank->icon = '/storage'.$imagelink[1];
        }

        $localbank->sort = $request->sort;
        $localbank->save();
        return redirect()->route('localbank.index')
                        ->with('success','Cập nhật ngân hàng thành công');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
        	Localbank::find($id)->delete();
            return redirect()->route('localbank.index')
                        ->with('success','Ngân hàng đã được xóa');
        }else{
            return redirect()->route('localbank.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

    public function localbankuser(Request $request) {

        $title    = "Ngân hàng của khách hàng";

        $list_user_banks = DB::table('localbanks_user')
            ->leftJoin('localbanks', 'localbanks_user.code', '=', 'localbanks.code')
            ->select('localbanks.name', 'localbanks_user.*')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $type = $request->type;
        $keyword = $request->keyword;

        if($type == 'username' && $keyword){
            $user = User::where('username', $keyword)->first();
            if(!$user){
                return redirect()->back()->withErrors(['error' => 'Không có kết quả!']);
            }

            $list_user_banks = DB::table('localbanks_user')
                ->leftJoin('localbanks', 'localbanks_user.code', '=', 'localbanks.code')
                ->select('localbanks.name', 'localbanks_user.*')
                ->where('user_id', $user->id)
                ->paginate(20);

        }

        return view("Localbank::userbanks", compact('title','list_user_banks'));

    }

    public function delbankuser(Request $request){

        $localbankuser = LocalbankUser::find($request->id);

        if($localbankuser && $request->input('_method') =='delete'){
            $localbankuser->delete();
            return redirect()->route('backend.localbank.user')->with('success', 'Xóa thành công ngân hàng của thành viên');
        }else {

            return redirect()->route('backend.localbank.user')->withErrors(['error' => 'Lỗi: Không thể xóa ngân hàng']);
        }

    }


}