<?php

namespace App\Modules\Sliders\Controllers;

use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use View;
use App\Modules\Sliders\Models\Sliders;
use Storage;

class SlidersController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'Sliders List';
        View::share ('title', $title );
    }

	public function index(Request $request)
	{
		$sliders = Sliders::orderBy('id','DESC')->paginate(10);
		if($request->input('keyword')!='')
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $typeSearch = $request->input('type');
            $title  = "Search: ";
            if($typeSearch!==''){
                switch ($typeSearch) {
                    case 'slider_text':
                        $title .= 'Text = ';
                        break;
                    case 'status':
                        $title .= 'Status = ';
                        break;
                    default:
                        $title .= 'Name = ';
                        break;
                }
                if($typeSearch=='status')
                    $sliders = Sliders::where($typeSearch, $keyword)->orderBy('id','DESC')->paginate(10);
                else
                    $sliders = Sliders::where($typeSearch, 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(10);
            }else{
                $sliders = Sliders::where('slider_name', 'LIKE', '%'.$keyword.'%')
                                ->orWhere('slider_text', 'LIKE', '%'.$keyword.'%')
                                ->paginate(10);
            }
            $title .= $keyword;
        }
		return view("Sliders::index", compact('sliders'));
	}

	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            return view('Sliders::create');
        }else{
            echo 'Not Access';
            return ;
        }
	}

    public function store(Request $request)
    {
        $this->validate($request, [
            'slider_name' => 'required|max:255',
            'slider_image' => 'required'
        ]);
        $input = $request->all();

        if($request->slider_image){

            $imagelink = explode('storage',$request->slider_image);
            $input['slider_image'] = '/storage'.$imagelink[1];
        }


        Sliders::create($input);

        return redirect()->route('sliders.index')
        				->with('success','Slider created successfully');
    }

    public function edit($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $slider = Sliders::find($id);
            return view('Sliders::edit',compact('slider'));
        }else{
            echo 'Not Access';
            return ;
        }
    }

	public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'slider_name' => 'required|max:255'
        ]);

        /* update Slider Data */
        $slider = Sliders::find($id);
        $slider->slider_name = $request->slider_name;

        if($request->slider_image){
            $imagelink = explode('storage',$request->slider_image);

            $slider->slider_image = '/storage'.$imagelink[1];
        }

        $slider->slider_text = $request->slider_text;
        $slider->slider_btn_text = $request->slider_btn_text;
        $slider->slider_btn_url = $request->slider_btn_url;
        $slider->sort_order = $request->sort_order;
        $slider->status = $request->status;
        $slider->save();

        return redirect()->route('sliders.index')
                        ->with('success','Slider updated successfully');
    }

    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            /* delete sliders */
            Sliders::find($id)->delete();

            return redirect()->route('sliders.index')
                        ->with('success','Slider deleted successfully');
        }else{
            echo 'Not Access';
            return ;
        }
    }

	public function actions(Request $request)
    {
        $val    = $request->check;
        $action = $request->action;
        if(empty($val)){
            return redirect()->route('sliders.index')->withErrors(['message' =>'Không có mục nào được chọn.']);
        }

        foreach ($val as $value) {
            $sliders = Sliders::find($value);
            $this->_runAction($value, $action);
        }
        return redirect()->route('sliders.index')->with('success','Slider '.$action.' successfully');
    }

    private function _runAction($id, $action)
    {
        switch ($action) {
            case 'delete':
                $this->destroy($id);
                break;
            
            default:
                break;
        }
        return null;
    }

}