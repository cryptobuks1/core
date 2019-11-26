<?php
namespace App\Modules\Group\Controllers;

use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use App\Modules\Group\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Auth;
use Validator;
use Hash;
use View;
use DB;

class GroupController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $title = 'GroupProject Management';
        View::share ('title', $title );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::orderBy('id','DESC')->paginate(10);
        if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $users = Group::where('name', 'LIKE', '%'.$keyword.'%')->where('description', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(10);
        }
        return view('GroupProject::index',compact('title','groups'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            return view('GroupProject::create');
        }else{
            echo 'Not Access';
            return ;
        }
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
            'name' => 'required|unique:groups,name'
        ]);
        $input = $request->all();
        if(isset($input['status']))
        {
            $input['status'] = 1;
        }else{
            $input['status'] = 0;
        }

        if(isset($input['hideit']))
        {
            $input['hideit'] = 1;
        }else{
            $input['hideit'] = 0;
        }

        Group::create($input);
        return redirect()->route('groups.index')
                        ->with('success','Thêm nhóm thành công');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('User::show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if( auth()->user()->hasRole('SUPER_ADMIN|BACKEND') )
        {
            $group  = Group::find($id);
            return view('GroupProject::edit', compact('group'));
        }else{
            echo 'Not Access';
            return ;
        }
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
            'name' => 'required|unique:groups,name,'.$id,
        ]);

        $group = Group::find($id);
        if(isset($request->status))
        {
            $group->status = 1;
        }else{
            $group->status = 0;
        }

        if(isset($request->hideit))
        {
            $group->hideit = 1;
        }else{
            $group->hideit = 0;
        }

        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();
        return redirect()->route('groups.index')
                        ->with('success','Cập nhật nhóm thành công');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $group = Group::find($id);
            if( $group->name == 'DEFAULT' || $group->name == 'default' )
            {
                return redirect()->route('groups.index')->withErrors(['Groups default can not delete']);
            }else{
                $group->delete();
                return redirect()->route('groups.index')
                    ->with('success','Groups deleted successfully');
            }

        }else{
            return redirect()->route('groups.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

     public function actions(Request $request)
    {
        $val    = $request->check;
        $action = $request->action;
        if(empty($val)){
            return redirect()->route('groups.index')->withErrors(['message' =>'Không có mục nào được chọn.']);
        }

        foreach ($val as $value) {
            $user = Group::find($value);
            $this->_runAction($value, $action);
        }
        return redirect()->route('groups.index')->with('success','GroupProject  '.$action.' successfully');
    }

    private function updateStatus($id, $status)
    {
        $group = Group::find($id);
        ( $status == 'status_on' ) ? $group->status = 1: $group->status = 0;
        $group->save();
        return redirect()->route('groups.index')
                        ->with('success','Groups update status successfully');
    }
    private function _runAction($id, $action)
    {
        switch ($action) {
            case 'delete':
                $this->destroy($id);
                break;
            case 'status_on':
                $this->updateStatus($id, $action);
                break;
            case 'status_off':
                $this->updateStatus($id, $action);
                break;
            default:
                break;
        }
        return null;
    }

}
