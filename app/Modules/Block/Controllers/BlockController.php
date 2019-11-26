<?php

namespace App\Modules\Block\Controllers;

use App\Modules\Block\Models\BlockContent;
use App\Modules\Language\Models\Language;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use File;
use App\User;
use App\Modules\Block\Models\Block;


class BlockController extends BackendController
{

	public function index(Request $request)
	{
		$title    = "Quản lý khối dữ liệu";
		$blocks = Block::orderBy('id','DESC')->paginate(20);
		if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $blocks = Block::where('name', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(20);
        }
		return view("Block::index", compact('title','blocks'));
	}

	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|BACKEND') )
        {
        	$title    = "Quản lý khối dữ liệu";
            $langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();

            $path = app_path('Modules//Block//Widgets');
            $list_widgets = File::allFiles($path);
            foreach ($list_widgets as $wg){
                $widgets[] = str_replace(".php","", pathinfo($wg)['basename']);
            }

            return view('Block::create',compact('title', 'langs', 'widgets'));
        }else{
            return 'Not Access';
        }
	}

	public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'widget' => 'required',
            'key' => 'required|unique:blocks,key',
        ]);

        $input = $request->all();
        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;
        ( isset($input['require_login']) ) ? $input['require_login'] = 1 : $input['require_login'] = 0;

        Block::create($input);
        return redirect()->route('blocks.index')
                        ->with('success','Thêm khối thành công');
    }

    public function edit($id)
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|BACKEND') )
        {

            $title    = "Sửa ngân hàng";
        	$localbank  = Block::find($id);
            return view('Block::edit',compact('title','localbank'));
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

        $localbank = Block::find($id);
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
        if( allow('delete') === true )
        {
            $blockcontent = BlockContent::where('block', $id)->get();
            if(count($blockcontent) == 0){
                Block::find($id)->delete();
                return redirect()->route('blocks.index')
                    ->with('success','Khối được xóa');
            }else{
                return redirect()->route('blocks.index')
                    ->withErrors(['message' =>'Không thể xóa khối khi vẫn còn nội dung']);
            }

        }else{
            return redirect()->route('blocks.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

    public function blockContent($id){
        $block = Block::find($id);

        if($block) {
            $title = 'Nội dung: '.$block->name;
            $contents = BlockContent::where('block', $id)->get();
            return view('Block::blockcontent',compact('title','contents','block'));
        }else{
            return redirect()->route('blocks.index')
                ->withErrors(['message' =>'Khối không tồn tại']);
        }

    }

    public function createContent(Request $request){

        if(!isset($request->block)){
            return redirect()->route('blocks.index')
                ->withErrors(['message' =>'Không xác định được khối cần tạo nội dung']);
        }
        $block = Block::find($request->block);
        if($block){
            $title = 'Thêm nội dung cho khối';
            $classPath = '\App\Modules\Block\Widgets\\' . $block->widget;
            $obj = new $classPath;
            $bcontent = null;
            $content = $obj->showform($block->name, $bcontent);

            return view('Block::createcontent',compact('title', 'content', 'block'));

        }else{
            return redirect()->route('blocks.index')
                ->withErrors(['message' =>'Khối không tồn tại']);
        }

    }

    public function postContent(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'lang' => 'required',
            'block' => 'required',
        ]);

        $input = $request->all();

        if($request->image){
            $imagelink = explode('storage',$request->image);
            $input['image'] = '/storage'.$imagelink[1];
        }
        $input['block'] = $request->block;
        $input['lang'] = $request->lang;

        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;

        BlockContent::create($input);
        return redirect()->route('admin.blocks.content.index', $input['block'])
            ->with('success','Thêm nội dung thành công');
    }

    public function destroyContent($id)
    {
        if( allow('delete') === true )
        {
            $blockcontent = BlockContent::where('block', $id)->first();
            if($blockcontent){
                $blockcontent->delete();
                return redirect()->back()
                    ->with('success','Xóa nội dung thành công');
            }else{
                return redirect()->back()
                    ->withErrors(['message' =>'Không thể xóa khối khi vẫn còn nội dung']);
            }

        }else{
            return redirect()->back()
                ->withErrors(['message' =>'Not access.']);
        }
    }


}