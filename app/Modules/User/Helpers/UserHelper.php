<?php
namespace App\Modules\User\Helpers;

use App\Modules\Sendmail\Controllers\SendmailController;
use App\Modules\Wallet\Controllers\WalletController;
use Illuminate\Support\Facades\Hash;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\User\Models\User as UserModel;
use Illuminate\Support\Str;
use DB;
use Log;
use Auth;
use Cookie;

class UserHelper {
  public static function createUser($userdata,$parent) {
    DB::beginTransaction();
    try {

//      $user = new UserModel;
//      $user->username = $userdata['username'];
//      $user->name = $userdata['name'];
//      $user->email = $userdata['email'];
//      $user->phone = $userdata['phone'];
//      $user->password = $userdata['password'];
//      $user->group = $userdata['group'];
//      $user->country_code = $userdata['country_code'];
//      $user->parent_id = $userdata['parent_id'];
//      $user->ip = $userdata['ip'];
//      $user->ref = $userdata['ref'];
//      $user->status = $userdata['status'];
//      $user->save();
        $input['name'] = $userdata['name'];
        $input['email'] = $userdata['email'];
        $input['username'] = $userdata['username'];
        $input['phone'] = $userdata['phone'];
        $input['password'] = $userdata['password'];
        $input['group'] = $userdata['group'];
        $input['country_code'] = $userdata['country_code'];
        $input['ref'] = $userdata['ref'];
        $input['ip'] = $userdata['ip'];
        $input['status'] = $userdata['status'];
        $user = UserModel::create($input,$parent);
        $nodes = UserModel::all();
        $count = [];
        foreach ($nodes as $node){
            array_push($count,count($node->ancestors));
        }
        if((max($count) + 1) > 5){
            UserModel::destroy($user->id);
        }
      /// Tạo role USER
      DB::table('model_has_roles')->insert(
              ['role_id' => 5, 'model_type' => 'App\User', 'model_id' => $user->id]
      );
      /// Tạo ví
      WalletController::makeWalletFromUserId($user->id);
      DB::commit();
      return $user;

    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }

  }


  public static function user_login($data = array()) {
    if (!isset($data['username']) || !isset($data['password'])) {
      return null;
    }
    if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
      $login = 'email';
      $temp_user = UserModel::where('email', $data['username'])->where('status', 1)->first();

    } else {
      $temp_user = UserModel::where('phone', $data['username'])->where('status', 1)->first();
      if (is_numeric($data['username']) && $temp_user) {
        $login = 'phone';

      } else {
        $temp_user = UserModel::where('username', $data['username'])->where('status', 1)->first();
        $login = 'username';
      }
    }
    if (!$temp_user) {
      return null;
    }
    $remember = ($data['remember']) ? true : false;
    ///Thông tin gửi lên
    $user_login[$login] = $data['username'];
    $user_login['password'] = $data['password'];
    if (Auth::attempt($user_login, $remember)) {
      /// Ghi log
      $input = array();
      $input['user_id'] = auth()->user()->id;
      $input['phone'] = (auth()->user()->phone) ? auth()->user()->phone : null;
      $input['email'] = (auth()->user()->email) ? auth()->user()->email : null;
      $input['ip'] = getIpClient();
      $input['twofactor'] = null;
      $input['user_agent'] = request()->server('HTTP_USER_AGENT');
      $input['created_at'] = now();
      $input['updated_at'] = now();
      DB::table('auth_logs')->insert($input);
      if (Auth::check()) {
        $logged_user = UserModel::find(Auth::user()->id);
        if (Auth::user()->hasRole('BACKEND')) {
          $logged_user->api_token = null;
          $logged_user->api_token_created = null;
          $logged_user->update();
          Auth::logout();
          return null;
        } else {
          $token = Str::random(60) . Auth::user()->id;
          $logged_user->api_token = hash('sha256', $token);
          $logged_user->api_token_created = now();
          $logged_user->update();
          return $logged_user;
        }

      }

    } else {
      return null;
    }

  }

  ///Hàm này viết sau, dùng để xóa token hết hạn
  public static function autoRemoveToken() {

  }

  ///Trả về các trường có thể update dữ liệu
  public static function UserUpdateCheck() {
    if (Auth::check()) {
      $user = UserModel::find(Auth::user()->id);
      $response = [];
      $response['gender'] = ['title' => 'Giới tính', 'key' => 'gender'];
      $response['birthday'] = ['title' => 'Ngày sinh', 'key' => 'birthday'];
      $response['country_code'] = ['title' => 'Quốc gia', 'key' => 'country_code'];
      $response['mkc2'] = ['title' => 'Mật khẩu cấp 2', 'key' => 'mkc2'];

      if ($user->username == null) {
        $response['username'] = ['title' => 'Tên đăng nhập', 'key' => 'username'];
      }
      if ($user->name == null) {
        $response['name'] = ['title' => 'Họ và tên', 'key' => 'name'];
      }
      if ($user->phone == null) {
        $response['phone'] = ['title' => 'Số điện thoại', 'key' => 'phone'];
      }
      if ($user->email == null) {
        $response['email'] = ['title' => 'Email', 'key' => 'email'];
      }
      return $response;
    }
  }


  public static function getName($username) {
    $info = UserModel::where('username', $username)->first();
    if ($info) {
      return $info->name;
    } else {
      return null;
    }

  }

  ///Hàm để chống trùng thông tin user, ví dụ sđt của người A không thể là username của người B. Chống chuyển nhầm tiền
  public static function checkDuplicateInfo($user_nick) {
    ///Check username
    $info_username = UserModel::where('username', $user_nick)->get();
    ///Check email
    $info_email = UserModel::where('email', $user_nick)->get();
    ///Check phone
    $info_phone = UserModel::where('phone', $user_nick)->get();
    if (count($info_username) > 0 || count($info_email) > 0 || count($info_phone) > 0) {
      return null;
    } else {
      return 'available';
    }
  }

  ///Xác định thông tin là username, email hay phone
  public static function defineUserInfo($input) {
    $info = null;
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
      $info = 'email';
    } else {
      if (is_numeric($input) && substr($input, 0, 1) == '0' && strlen($input) > 9) {
        $info = 'phone';
      } else {
        $info = 'username';
      }
    }
    if ($info) {
      $temp_user = UserModel::where($info, $input)->where('status', 1)->select('id', 'name', 'username', 'email', 'phone', 'group')->first();
      if ($temp_user) {
        return $temp_user;
      } else {
        return null;
      }

    } else {
      return null;
    }

  }


  public static function defineUserLoginMethod($input) {
    $info = null;
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
      $info = 'email';
    } else {
      if (is_numeric($input) && substr($input, 0, 1) == '0' && strlen($input) > 9) {
        $info = 'phone';
      } else {
        $info = 'username';
      }
    }
    if ($info) {
      return $info;
    } else {
      return null;
    }
  }

}
