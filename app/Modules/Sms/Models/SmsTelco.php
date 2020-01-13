<?php

namespace App\Modules\Sms\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\User;

class SmsTelco extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sms_telco';
    protected $fillable = [
        'name', 'country_code','dial_code','status','key','price','number_format','description'
    ];
    protected $casts = [
        'price' => 'array',
    ];

    public static function getPrice($user_id, $telco_id, $currency_code){
        $user = User::find($user_id);
        $telco = SmsTelco::where('id',$telco_id)->first();
        if ($telco && $user){
            if(isset($telco->price[$user->group][$currency_code]))
            return $telco->price[$user->group][$currency_code];
        }
        return null;
    }
    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


}
