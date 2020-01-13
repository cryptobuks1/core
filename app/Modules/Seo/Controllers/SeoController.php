<?php

namespace App\Modules\Seo\Controllers;

use App\Modules\Api\Models\Api;
use App\Modules\Language\Models\Language;
use App\Modules\Seo\Models\Seo;
use App\Modules\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use App\Modules\Charging\Models\ChargingProvider;
use \App\User;
use App\Modules\Wallet\Controllers\WalletController;
use App\Modules\Sms\Controllers\SmsController;
use Schema;

class SeoController extends BackendController
{
    public function index(Request $request)
    {
        $title    = "Seo Onpage";
        $seos = Seo::orderBy('id','DESC')->paginate(25);
        if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $seos = Seo::where('link', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(25);
        }
        return view("Seo::index", compact('title','seos'));
    }

    public function create()
    {

        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $title    = "Tạo Seo link";
            $langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();

            return view('Seo::create',compact('title', 'langs'));
        }else{
            echo 'Not Access';
            return ;
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'link' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);
        $input = $request->all();
        $link = $request->link;
        if(!starts_with($link, 'http')){
            return back()->withErrors(['error' => 'Đường dẫn phải bắt đầu bằng http']);
        }
        $url = url('/');
        $input['link'] = str_replace($url, '', $link);
        $input['checksum'] = md5($input['link']);

        $avatar = $request->avatar;
        $input['avatar'] = str_replace($url, '', $avatar);

        Seo::create($input);
        return redirect()->route('seo.index')
            ->with('success','Seo meta được tạo thành công');
    }

    public function edit($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $title    = "Sửa Seo meta";
            $langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();
            $seo  = Seo::find($id);
            return view('Seo::edit',compact('title','seo', 'langs'));
        }else{
            echo 'Not Access';
            return ;
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $seo = Seo::find($id);
        $seo->title = $request->title;
        $seo->description = $request->description;
        if($request->avatar){
            $url = url('/');
            $avatar = $request->avatar;
            $seo->avatar  = str_replace($url, '', $avatar);

        }
        $seo->language = $request->language;
        $seo->h1 = $request->h1;
        $seo->noindex = $request->noindex;
        $seo->save();
        return redirect()->route('seo.index')
            ->with('success','Cập nhật thành công');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            Seo::find($id)->delete();
            return redirect()->route('seo.index')
                ->with('success','Xóa thành công');
        }else{
            return redirect()->route('seo.index')
                ->withErrors(['message' =>'Not access.']);
        }
    }
}
