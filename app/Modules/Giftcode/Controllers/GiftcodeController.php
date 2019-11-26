<?php

namespace App\Modules\Giftcode\Controllers;

use App\Modules\Currency\Models\Currencies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Auth;
use App\Modules\Giftcode\Models\Giftcode;
use DB;
use File;


class GiftcodeController extends BackendController
{

	public function index(Request $request)
	{
		$title    = "Quản lý mã quà tặng";
        $giftcodes = Giftcode::orderBy('id','DESC')->paginate(40);
		if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $giftcodes = Giftcode::where('code', $keyword)->orderBy('id','DESC')->paginate(40);
        }

        foreach ($giftcodes as $gc){
            $current = Carbon::today();
            $remain = $current->diffInDays(Carbon::parse($gc->expired_at));
            $gc->remain = $remain;
        }

		return view("Giftcode::index", compact('title','giftcodes'));
	}

	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN') )
        {
        	$title    = "Thêm mới Giftcode";
        	$currency = Currencies::where('status', 1)->where('fiat', 1)->get();
        	$model = ['MoviePackage', 'Filehost', 'Course'];

            $listvendors = $this->getlistvendor();

            return view('Giftcode::create',compact('title', 'currency', 'model', 'listvendors'));
        }else{
            echo 'Not Access';
        }
	}

	public function deposit(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'qty' => 'required|numeric',
            'currency' => 'required',
            'value' => 'required|numeric',
            'expired_at' => 'required|numeric',
        ]);

        $qty = $request->qty;
        if($qty > 0){
            $t = 0;
            for ($i = 0; $i < $qty ; $i++){
                try{
                    $currency = Currencies::find($request->currency);

                    $code = 'GCP'.mt_rand(100000000000,999999999999);

                    $input = new Giftcode;
                    $input->name = $request->name;
                    $input->prefix = 'GCP';
                    $input->type = 'deposit';
                    $input->code = $code;
                    $input->model = 'AddFund';
                    $input->currency_id = $request->currency;
                    $input->currency_code = $currency->code;
                    $input->value = abs($request->value);
                    $input->discount = null;
                    $input->status = 1;
                    $input->used_time = 1;
                    $input->premiumday = null;
                    $input->expired_at = Carbon::now()->addDays(intval($request->expired_at));
                    $input->save();
                    $t++;
                }catch (\Exception $e){
                    continue;
                }

            }
            return redirect()->route('giftcode.index')->with('success', 'Thêm thành công '. $t .' mã nạp tiền');
        }else{
            return redirect()->route('giftcode.index')->withErrors(['error', 'Không đúng số lượng']);
        }

    }


    public function discount(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'qty' => 'required|numeric',
            'discount' => 'required',
            'model' => 'required',
            'expired_at' => 'required|numeric',
        ]);

        $qty = $request->qty;
        if($qty > 0){

            $t = 0;
            for ($i = 0; $i < $qty ; $i++){

                try{
                    $code = 'GCD'.mt_rand(100000000000,999999999999);
                    $input = new Giftcode;
                    $input->name = $request->name;
                    $input->prefix = 'GCD';
                    $input->type = 'discount';
                    $input->code = $code;
                    $input->model = $request->model;
                    $input->currency_id = null;
                    $input->currency_code = null;
                    $input->value = null;
                    $input->discount = abs($request->discount);
                    $input->status = 1;
                    $input->used_time = $request->usetime;
                    $input->premiumday = null;
                    $input->expired_at = Carbon::now()->addDays(intval($request->expired_at));
                    $input->sku = $request->sku;
                    $input->save();
                    $t++;
                }catch (\Exception $e){
                    continue;
                }

            }

            return redirect()->route('giftcode.index')->with('success', 'Thêm thành công '. $t .' mã giảm giá');
        }else{
            return redirect()->route('giftcode.index')->withErrors(['error', 'Không đúng số lượng']);
        }

    }

    public function renewal(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'qty' => 'required|numeric',
            'model' => 'required',
            'sku' => 'required',
            'expired_at' => 'required|numeric',
        ]);

        $qty = $request->qty;
        if($qty > 0){

            $t = 0;
            for ($i = 0; $i < $qty ; $i++){

                try{
                    $code = 'GCR'.mt_rand(100000000000,999999999999);

                    $input = new Giftcode;
                    $input->name = $request->name;
                    $input->prefix = 'GCR';
                    $input->type = 'renewal';
                    $input->code = $code;
                    $input->model = $request->model;
                    $input->sku = $request->sku;
                    $input->currency_id = null;
                    $input->currency_code = null;
                    $input->value = null;
                    $input->discount = null;
                    $input->status = 1;
                    $input->used_time = 1;
                    $input->premiumday = $request->premiumday;
                    $input->expired_at = Carbon::now()->addDays(intval($request->expired_at));;
                    $input->save();
                    $t++;
                }catch (\Exception $e){
                    continue;
                }

            }

            return redirect()->route('giftcode.index')->with('success', 'Thêm thành công '. $t .' mã gia hạn');
        }else{
            return redirect()->route('giftcode.index')->withErrors(['error', 'Không đúng số lượng']);
        }
    }

    public function purchase(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'qty' => 'required|numeric',
            'model' => 'required',
            'sku' => 'required',
            'expired_at' => 'required|numeric',
        ]);

        $qty = $request->qty;
        if($qty > 0){

            $t = 0;
            for ($i = 0; $i < $qty ; $i++){

                try{
                    $code = 'GCB'.mt_rand(100000000000,999999999999);

                    $input = new Giftcode;
                    $input->name = $request->name;
                    $input->prefix = 'GCB';
                    $input->type = 'purchase';
                    $input->code = $code;
                    $input->model = $request->model;
                    $input->sku = $request->sku;
                    $input->currency_id = null;
                    $input->currency_code = null;
                    $input->value = null;
                    $input->discount = null;
                    $input->status = 1;
                    $input->used_time = 0;
                    $input->premiumday = null;
                    $input->expired_at = Carbon::now()->addDays(intval($request->expired_at));
                    $input->save();
                    $t++;
                }catch (\Exception $e){
                    continue;
                }

            }

            return redirect()->route('giftcode.index')->with('success', 'Thêm thành công '. $t .' mã mua dịch vụ');
        }else{
            return redirect()->route('giftcode.index')->withErrors(['error', 'Không đúng số lượng']);
        }
    }


    public function getlistvendor(){

	    try{
            $path = app_path('Modules//Giftcode//Vendors');
            $lists = array_map('basename', File::directories($path));
        }catch (\Exception $e){
            $lists = null;
        }

        return $lists;
    }


    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {

            $title    = "Trao đổi Banner";
        	$weblink  = Weblink::find($id);
            return view('Giftcode::edit',compact('title','weblink'));
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
                        ->with('success','Giftcode updates successfully');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            Giftcode::find($id)->delete();
            return redirect('/adminnc/giftcode')
                        ->with('success','Giftcode deleted successfully');
        }else{
            return redirect('/adminnc/giftcode')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

    public function fillterSKU(Request $request){

        $title = "Gift list with SKU code is: ".$request->keyword;

        $giftcodes = Giftcode::where('sku','=',$request->keyword)->orderBy('id','DESC')->paginate(40);
		if($giftcodes){
            foreach ($giftcodes as $gc){
                $current = Carbon::now();
                $remain = $current->diffInDays(Carbon::parse($gc->expired_at));
                $gc->remain = $remain;
            }
        }else{
            return redirect('/adminnc/giftcode')->withErrors('SKU code incorrect');
        }
       
		return view("Giftcode::index", compact('title','giftcodes'));
    }

    public function exportCode(Request $request){
        $title = "Danh sách gift code của mã sẩn phẩm: " .$request->keyword;
        $giftcodes = Giftcode::where('sku','=',$request->keyword)->where('status',1)->orderBy('id','DESC')->get();
        $arrayCode = array();
        if($giftcodes){
            foreach($giftcodes as $value){
                array_push($arrayCode, $value->code);
            }
        }else{
            return redirect('/adminnc/giftcode')->withErrors('SKU code incorrect');
        }

        return view("Giftcode::exportCode", compact('title','arrayCode'));
    }

}