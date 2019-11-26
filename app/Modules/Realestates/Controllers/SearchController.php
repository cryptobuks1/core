<?php

namespace App\Modules\Realestates\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\Search;
use Auth;

class SearchController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Search::where('module','Realestates')->paginate(20);
        return view('Realestates::search',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Realestates::search_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=new  Search;
        $data->type=$request->type;
        $data->name=$request->name;
        $data->module='Realestates';
        $data->start=$request->start;
        $data->end=$request->end;
        $data->code=$request->code;
        $data->status=$request->status;
        $data->save();
        return redirect()->route('search.index')->with('success','Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Search::find($id);
        return view('Realestates::search_edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'end' => 'required',
            'start' => 'required',
        ]);
        $data=Search::find($id);
        $data->type=$request->type;
        $data->name=$request->name;
        $data->module='Realestates';
        $data->start=$request->start;
        $data->end=$request->end;
        $data->code=$request->code;
        $data->status=$request->status;
        $data->save();
        return redirect()->route('search.index')->with('success','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RealestatesType::destroy($id);
        return back()->with('success','Xóa thành công');
    }

}
