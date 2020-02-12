<?php
namespace App\Modules\User\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Modules\Group\Models\Group;
use Kalnoy\Nestedset\NodeTrait;


class User extends Authenticatable {
  use Notifiable;
  use HasRoles;
  use NodeTrait;


  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
          'username',
          'name',
          'email',
          'phone',
          'country_code',
          'gender',
          'group',
          'password',
          'remember_token',
          'api_token',
          'api_token_created',
          'provider',
          'provider_id',
          'mkc2',
          'tmp',
          'tmp_token',
          'status',
          'parent_id',
          '_lft',
          '_rgt',
          'currency_id',
          'language',
          'twofactor',
          'twofactor_secret',
          'ip',
          'ref',
          'failed',
          'failed_reason',
          'verify_phone',
          'verify_email',
          'verify_document',
          'birthday',
  ];


  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
          'password', 'remember_token',
  ];

  public function getGroupName($id) {
    $group = Group::find($id);
    return $group['name'];
  }
    public static function nodeFixTree(){
        $data = Node::fixTree();
        return $data;
    }

  public static function getName($id) {
    $user = User::find($id);
    if ($user) {
      $info = $user->name;
    } else {
      $info = '';
    }
    return $info;
  }

  public function checkUserActive($id) {
    $user = User::select('status')->where('id', $id)->first();
    if ($user->status == 1) {
      return true;
    }
    return false;
  }

  public static function getUserInfo($id) {
    $user = User::find($id);
    if ($user) {
      $url = url('/' . env('BACKEND_URI')) . '/users?type=id&keyword=' . $user->id;
      $a = '<a href=' . "$url" . ' target=' . "_blank" . '>Xem</a>';
      $info = 'ID:' . $user->id . " --- " . $a . " <br>" . $user->name . '<br>' . $user->email . '<br>' . $user->phone;
    } else {
      $info = '';
    }
    return $info;
  }


  public static function getUserInfoWithID($id) {
    $user = User::find($id);
    if ($user) {
      $info = 'ID:' . $user->id . '<br><b>' . $user->name . '</b><br>' . $user->email . '<br>' . $user->phone;
    } else {
      $info = '';
    }
    return $info;
  }

  public static function getUserInfoJson($id,$phone = false) {
    $user = User::find($id);
    if ($user) {
      $info = array();
      $info['name'] = $user->name;
      if($user->email){
        $info['email'] = $user->email;
      }
      if($user->phone && $phone){
        $info['phone'] = $user->phone;
      }
        return $info;
    } else {
      $info = null;
    }
    return $info;
  }

}
