<?php

namespace App\Modules\Realestates\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use App\Modules\Group\Models\Group;
use App\Modules\Realestates\Models\Provinces;
use App\Modules\Realestates\Models\RealestatesImg;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\Project;
use App\Modules\Realestates\Models\GroupProject;
use App\Modules\Realestates\Models\Cities;
use Auth;

class ProjectController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Project::orderBy('id','asc')->paginate(20);
        $group=GroupProject::where('status',1)->get();
        return view('Realestates::project',compact('data','group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=GroupProject::all();
        $cities=Cities::all();
        return view('Realestates::project_create',compact('data','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'name' => 'required',
            'city' => 'required',
            'description' => 'required',
            'province' => 'required',
            'image' => 'required',
        ]);
        $data=new  Project;
        $user_id=Auth::user()->id;
        $data->name=$request->name;
        $data->slug=str_slug($request->name.'-'.$data->id);
        $data->group2=$request->group;
        $data->module='Realestates';
        $data->user_id=$user_id;
        $data->description=$request->description;
        $data->city=$request->city;
        $data->province=$request->province;
        $data->price=$request->price;
        $data->acreage=$request->acreage;
        $data->address=$request->address;
        $data->investor=$request->investor;
        $data->process=$request->process;
        $data->status=$request->status;
        $data->featured=$request->featured;
        $data->status=$request->status;
        if($request->image){
            $imagelink = explode('storage',$request->image);
            $data->image = '/storage'.$imagelink[1];
        }
        $data->save();
        if($request->hasFile('images')) {
            foreach($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new RealestatesImg([
                    'project_id' => $data->id,
                    'img' => $filename
                ]);
                $file->save();
            }
        }
        $data->save();
        return redirect()->route('project.index')->with('success','Thêm thành công');
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
        $data=Project::find($id);
        $cities=Cities::all();
        $group=GroupProject::all();
        $file=RealestatesImg::where('project_id',$id)->get();
        return view('Realestates::project_edit',compact('data','group','cities','file'));
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
            'group' => 'required',
            'name' => 'required',
            'city' => 'required',
            'description' => 'required',
            'province' => 'required',
        ]);
        $data=Project::find($id);
        $user_id=Auth::user()->id;
        $data->name=$request->name;
        $data->module='Realestates';
        $data->slug=str_slug($request->name.'-'.$data->id);
        $data->group2=$request->group;
        $data->user_id=$user_id;
        $data->description=$request->description;
        $data->city=$request->city;
        $data->province=$request->province;
        $data->price=$request->price;
        $data->acreage=$request->acreage;
        $data->address=$request->address;
        $data->investor=$request->investor;
        $data->process=$request->process;
        $data->status=$request->status;
        $data->featured=$request->featured;
        $data->status=$request->status;
        if($request->image){
            $imagelink = explode('storage',$request->image);
            $data->image = '/storage'.$imagelink[1];
        }
        $data->save();
        if($request->hasFile('images')) {
            foreach($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new RealestatesImg([
                    'project_id' => $id,
                    'img' => $filename
                ]);
                $file->save();
            }
        }
        $data->save();
        return redirect()->route('project.index')->with('success','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Project::destroy($id);
        return back()->with('success','Xóa thành công');
    }

    public function delete($id){
        RealestatesImg::destroy($id);
        return back();
    }

}
