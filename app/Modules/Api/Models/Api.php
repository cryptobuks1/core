<?php

namespace App\Modules\Api\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_old';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'balance_decode',

    ];

    public static function error_code($error_code)
    {
        $err = null;
        switch ($error_code) {

            case 0:
                $err = 'success';
                break;
            case 600:
                $err = 'Lệnh không chính xác';
                break;
            case 601:
                $err = 'Du lieu gui len thieu chu ky';
                break;
            case 602:
                $err = 'Thieu du lieu mob_key';
                break;
            case 603:
                $err = 'Chu ky khong dung';
                break;
            case 604:
                $err = 'Nhập thiếu dữ liệu đăng nhập';
                break;
            case 605:
                $err = 'Token khong dung';
                break;
            case 606:
                $err = 'Thieu user_id';
                break;
            case 607:
                $err = 'Khai thiếu mật khẩu';
                break;
            case 608:
                $err = 'Đội dài mật khẩu mới phải lớn hơn 8 ký tự';
                break;
            case 609:
                $err = 'Mật khẩu cũ không chính xác';
                break;
            case 610:
                $err = 'Số điện thoại không đúng';
                break;
            case 611:
                $err = 'Email không hợp lệ';
                break;
            case 612:
                $err = 'Số điện thoại đã tồn tại';
                break;
            case 613:
                $err = 'Email đã tồn tại';
                break;
            case 614:
                $err = 'Thiếu dữ liệu email hoặc số điện thoại';
                break;
            case 615:
                $err = 'Mật khẩu không hợp lệ, tối thiểu 6 ký tự';
                break;
            case 616:
                $err = 'Vui lòng điền đầy đủ dữ liệu';
                break;
            case 617:
                $err = 'Tên đăng nhập đã tồn tại';
                break;
            case 618:
                $err = 'Vui lòng cập nhật số điện thoại';
                break;
            case 619:
                $err = 'Vui lòng cập nhật email';
                break;
            case 620:
                $err = 'Vui lòng cập nhật số tên đăng nhập';
                break;
            case 621:
                $err = 'Trường này không được phép cập nhật';
                break;
            case 622:
                $err = 'Thiếu mã ví walletId';
                break;
            case 623:
                $err = 'Gửi thiếu dữ liệu thành viên';
                break;
            case 624:
                $err = 'Số tiền muốn chuyển không hợp lệ';
                break;
            case 625:
                $err = 'Bạn chưa khai báo nội dung chuyển tiền';
                break;
            case 626:
                $err = 'Bạn chưa khai báo người nhận tiền';
                break;
            case 627:
                $err = 'Không lấy được tên người nhận';
                break;
            case 628:
                $err = 'Người nhận không tồn tại hoặc bị khóa';
                break;
            case 629:
                $err = 'Ví của người nhận không tồn tại hoặc bị khóa';
                break;
            case 630:
                $err = 'Chức năng chuyển tiền đang bảo trì';
                break;
            case 631:
                $err = 'Ví gửi và ví nhận giống nhau';
                break;
            case 632:
                $err = 'Số tiền không đủ để thực hiện giao dịch (bao gồm phí)';
                break;
            case 633:
                $err = 'Website đang bảo trì. Vui lòng trở lại sau!';
                break;



        }

        return $err;
    }

}