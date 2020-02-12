<?php

namespace App\Modules\User\Controllers;

use App\Helpers\CurlHelper;
use App\Modules\Order\Models\Order;
use App\Modules\User\Models\UserImage;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use App\Modules\Wallet\Controllers\WalletController;
use Auth;
use Validator;
use Hash;
use File;
use App\User;
use View;
use DB;
use App\Modules\Group\Models\Group;
use App\Modules\Wallet\Models\Wallet;

class UserController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $title = 'Danh sách khách hàng';
        View::share('title', $title);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "Danh sách thành viên";
        $users = User::role("USER");
        $group_user = Group::where('status',1)->get();

        if ($request->input('type') != '') {
            $type = $request->input('type');
            if ($request->input('keyword') != '') {
                $keyword = $request->input('keyword');
                if ($type == 'id' && $keyword) {
                    $users = $users->where('id', $keyword);
                }

                if ($type == 'username' && $keyword) {
                    $users = $users->where('username', $keyword);
                }
                if ($type == 'name' && $keyword) {
                    $users = $users->where('name', 'LIKE', '%' . $keyword . '%');
                }

                if ($type == 'email' && $keyword) {
                    $users = $users->where('email', 'LIKE', '%' . $keyword . '%');
                }
                if ($type == 'phone' && $keyword) {
                    $users = $users->where('phone', 'LIKE', '%' . $keyword . '%');
                }
            }
        }
        if ($request->status){
            if ($request->status == "status0"){
                $users = $users->where('status', 0);
            }

            if($request->status == "status1"){
                $users = $users->where('status', 1);
            }

            if($request->status == "verifydoc"){
            $users = $users->where('verify_document', 2);
            }

        }
        if ($request->group_user){
            $users = $users->where('group', $request->group_user);
        }

        $users = $users->orderBy('id', 'desc');
        $users = $users->paginate(25);

        /// Tạo key đăng nhập vào tk user
        foreach ($users as $user) {
            $wallets = Wallet::where('user', $user->id)->select('number','balance_decode', 'currency_code')->get();
            $key = env('APP_KEY');
            $ip = getIpClient();
            $token = sha1($user->id . $user->email . $user->phone . $user->password . $user->mkc2 . $key . $ip);
            $user->token = $token;
            $user->wallets = $wallets;
        }

        return view('User::index', compact('title', 'users', 'group_user'));
    }


    public function admins(Request $request)
    {
        $type = "BACKEND";
        $loginId = auth()->user()->id;
        $users = User::orderBy('id','DESC')->role("BACKEND")->paginate(30);

        $group_user = Group::where('status',1)->get();
        if($request->input('keyword')!='')
        {
            $keyword = $request->input('keyword');
            $typeSearch = $request->input('type');
            $title  = "Search: ";
            if($typeSearch!==''){
                switch ($typeSearch) {
                    case 'phone':
                        $title .= 'Phone = ';
                        break;
                    case 'email':
                        $title .= 'Email = ';
                        break;
                    case 'status':
                        $title .= 'Status = ';
                        break;
                    default:
                        $title .= 'Name = ';
                        break;
                }
                if($typeSearch=='status')
                    $users = User::where('id','!=',$loginId)
                        ->where($typeSearch, $keyword)
                        ->orderBy('id','DESC')->role("BACKEND")
                        ->paginate(10);
                else
                    $users = User::where('id','!=',$loginId)
                        ->where($typeSearch, 'LIKE', '%'.$keyword.'%')
                        ->orderBy('id','DESC')->role("BACKEND")
                        ->paginate(10);
            }else{
                $users = User::where('id','!=',$loginId)
                    ->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('email', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('phone', 'LIKE', '%'.$keyword.'%')
                    ->orderBy('id','DESC')->role("BACKEND")
                    ->paginate(10);
            }
            $title .= $keyword;
        }

        foreach ($users as $user) {
            $wallets = Wallet::where('user', $user->id)->where('balance_decode','>', 0)->select('balance_decode', 'currency_code')->get();
            $key = env('APP_KEY');
            $ip = getIpClient();
            $token = sha1($user->id . $user->email . $user->phone . $user->password . $user->mkc2 . $key . $ip);
            $user->token = $token;
            $user->wallets = $wallets;
        }

        return view('User::index',compact('title','users','type', 'group_user'));
    }



    /**
     * Phương thức upgrate người dùng
     * */
    public function upgrade(Request $request)
    {
        $loginId = auth()->user()->id;
        $users = User::orderBy('id', 'DESC')->role("USER")->paginate(30);

        if ($request->input('keyword') != '') {
            $keyword = $request->input('keyword');
            $title = "Search: " . $keyword;
            $typeSearch = $request->input('type');
            $title = "Search: ";
            if ($typeSearch !== '') {
                switch ($typeSearch) {
                    case 'phone':
                        $title .= 'Phone = ';
                        break;
                    case 'email':
                        $title .= 'Email = ';
                        break;
                    case 'status':
                        $title .= 'Status = ';
                        break;
                    default:
                        $title .= 'Name = ';
                        break;
                }
                if ($typeSearch == 'status')
                    $users = User::where('id', '!=', $loginId)
                        ->where($typeSearch, $keyword)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
                else
                    $users = User::where('id', '!=', $loginId)
                        ->where($typeSearch, 'LIKE', '%' . $keyword . '%')
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
            } else {
                $users = User::where('id', '!=', $loginId)
                    ->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $keyword . '%')
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
            }
            $title .= $keyword;
        }
        $wallet = Wallet::all();
        $sodu = array();
        foreach ($wallet as $key => $value) {
            $sodu[$value->user][$value->currency_code] = (float)$value->balance_decode;
        }
        return view('User::upgrade', compact('title', 'users', 'sodu'));
    }

    public function upgradeUser(Request $request, $id)
    {
        $roles = Role::all();
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $groups = Group::get();
        foreach ($groups as $group) {
            $lsGroup[$group->id] = $group->name;
        }
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('User::upgradeUser', compact('user', 'roles', 'userRole', 'lsGroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (auth()->user()->hasRole('SUPER_ADMIN|BACKEND')) {
            $groups = Group::get();
            foreach ($groups as $group) {
                $lsGroup[$group->id] = $group->name;
            }
            $roles = Role::pluck('name', 'name')->all();
            return view('User::create', compact('roles', 'lsGroup'));
        } else {
            echo 'Not Access';
            return;
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'gender' => 'required',
            'password' => 'required|confirmed|min:6',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        if (auth()->user()->hasRole('SUPER_ADMIN|ADMIN')) {
            $user->assignRole($request->input('roles'));
        } else {
            $input['roles'] = 'USER';
            $user->assignRole($input['roles']);
        }

        WalletController::makeWalletFromUserId($user->id);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('User::show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($id == 1 && Auth::user()->id !== 1){
            return redirect()->back()->withErrors(['Bạn không thể sửa tài khoản này']);
        }
        $user = User::find($id);

        if($id == 1){
            $roles = ["SUPER_ADMIN" => "SUPER_ADMIN", "BACKEND"=>"BACKEND"];
        }else{
            $roles = Role::where('name','!=','SUPER_ADMIN')->pluck('name', 'name')->all();
        }

        $groups = Group::get();
        foreach ($groups as $group) {
            $lsGroup[$group->id] = $group->name;
        }
        $userRole = $user->roles->pluck('name', 'name')->all();

        $verify_documents = UserImage::where('user_id', $id)->get();

        return view('User::edit', compact('user', 'roles', 'userRole', 'lsGroup','verify_documents'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $data = [];
        $data['name'] = 'required';


        $data['gender'] = 'required';
        $data['roles'] = 'required';

        if ($request->input('phone') && $request->input('phone') !== $user->phone) {
            $data['phone'] = 'unique:users,phone|regex:/(0)[0-9]{9}/';
        }

        if ($request->input('email') && $request->input('email') !== $user->email) {
            $data['email'] = 'email|unique:users,email,' . $id;
        }

        if ($request->input('username') && $request->input('username') !== $user->username) {
            $data['username'] = 'unique:users|min:6';
        }


        if (!$request->input('email') && !$request->input('phone')) {

            return redirect(url(config('backend.backendRoute') . '/users'))->withErrors(['error' => 'Bạn phải có ít nhất email hoặc số điện thoại']);
        }

        if ($request->input('password')) {
            $data['password'] = 'required|min:6';

            $user->password = Hash::make($request->input('password'));
        }

        if ($request->input('mkc2')) {
            $data['mkc2'] = 'required';

            $user->mkc2 = sha1($request->input('mkc2'));
        }

        $validatedData = Validator::make($request->all(), $data);


        if ($validatedData->fails()) {
            return redirect(url(config('backend.backendRoute') . '/users/' . $id . '/edit'))->withErrors($validatedData)->withInput();
        }

        if ($request->input('mkc2')) {
            $user->mkc2 = sha1($request->input('mkc2'));
        }

        if ($request->input('verify_document')) {

            if($request->input('verify_document') == 'accept'){
                $user->verify_document = 1;
            }elseif($request->input('verify_document') == 'blockacc'){
                $user->verify_document = null;
                $user->status = 0;

            }else{
                $user->verify_document = null;
                $images = UserImage::where('user_id', $id)->get();
                if(count($images) > 0){
                  foreach ($images as $img){
                    if($img->image){
                      $b_file = explode("/", $img->image);
                      $ffile = end($b_file);
                      File::delete(storage_path('app/public/verify/'.$ffile));
                      $img->delete();
                    }
                  }
                }
            }
        }

        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->input('name') && $request->input('name') !== $user->name) {
            $user->name = $request->name;
        }

        if ($request->input('gender') && $request->input('gender') !== $user->gender) {
            $user->gender = $request->gender;
        }

        if ($request->input('group') && $request->input('group') !== $user->group) {
            $user->group = $request->group;
        }

        $user->update();

        if (auth()->user()->hasRole('SUPER_ADMIN')) {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
        }
        return redirect()->back()
            ->with('success', 'Cập nhật thông tin thành viên thành công!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            return redirect()->route('users.index')
                ->withErrors(['message' => 'Không thể xóa tài khoản này!!!']);
        }

        if (auth()->user()->hasRole('SUPER_ADMIN')) {
            if (auth()->user()->id == $id) {
                return redirect()->route('users.index')
                    ->withErrors(['message' => 'Bạn không thể xóa tài khoản của chính bạn!.']);
            }

            $trans = Order::where('payer_id', $id)->get();

            if (count($trans) > 0) {
                return redirect()->route('users.index')
                    ->withErrors(['message' => 'Bạn không thể xóa tài khoản này vì đã phát sinh giao dịch!.']);
            }

            $money = Wallet::where('user', $id)->first();
            if ($money && $money->balance_decode > 0) {
                return redirect()->route('users.index')
                    ->withErrors(['message' => 'Bạn không thể xóa tài khoản này vì đang còn số dư!']);
            }

            DB::beginTransaction();
            try{
                User::find($id)->delete();
                Wallet::where('user', $id)->delete();
                DB::table('model_has_roles')->where('model_id', $id)->delete();
                DB::commit();
                return redirect()->route('users.index')
                    ->with('success', 'Xóa thành viên thành công!');
            }catch (\Exception $e){
                DB::rollback();
                return redirect()->route('users.index')->withErrors(['message' => 'Xóa thất bại.']);
            }

        } else {
            return redirect()->route('users.index')
                ->withErrors(['message' => 'Not access.']);
        }
    }

    public function actions(Request $request)
    {
        $ids = $request->check;
        $action = $request->action;
        if (empty($ids) || empty($action)) {
            return redirect()->route('users.index')->withErrors(['message' => 'Dữ liệu không chính xác.']);
        }

        foreach ($ids as $id) {
            $this->_runAction($id, $action);
        }
        return redirect()->route('users.index')->with('success', 'User  ' . $action . ' successfully');
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

    public function verifydocument(){

    }


}
