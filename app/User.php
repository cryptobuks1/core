<?php


namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Modules\Group\Models\Group;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'username','name', 'email', 'phone','gender', 'password', 'group', 'twofactor', 'mkc2', 'status', 'provider', 'provider_id', 'remember_token', 'tmp', 'tmp_token'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getGroupName($id)
    {
        $group = Group::find($id);
        return $group['name'];
    }

    public static function getName($id)
    {
        $user = User::find($id);
        if($user){
            $info = $user->name;
        }else{
            $info = '';
        }
        return $info;
    }

    public function checkUserActive($id)
    {
        $user = User::select('status')->where('id',$id)->first();
        if( $user->status ==  1 )
        {
            return true;
        }
        return false;
    }

    public static function getUserInfo($id){
        $user = User::find($id);

        if($user){

            $url= url('/'.env('BACKEND_URI')).'/users?type=id&keyword='.$user->id;

            $a = '<a href='."$url".' target='."_blank".'>Xem</a>';

            $info = 'ID:'.$user->id." --- ".$a." <br>" .$user->name.'<br>'.$user->email.'<br>'.$user->phone;
        }else{
            $info = '';
        }
        return $info;
    }


    public static function getUserInfoWithID($id){
        $user = User::find($id);

        if($user){
            $info = 'ID:'.$user->id.'<br><b>'.$user->name.'</b><br>'.$user->email.'<br>'.$user->phone;
        }else{
            $info = '';
        }
        return $info;
    }
}
