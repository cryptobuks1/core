<?php

function theme_view($path, $values = array())
{
    $theme = (env('THEME'))? env('THEME') : 'default';
    $full_path = 'frontend.' . $theme . '.' . $path;

    return view($full_path, $values);
}

function theme_asset($path)
{
    $theme = (env('THEME'))? env('THEME') : 'default';
    $file_path = 'assets/' . $theme . '/' . $path;

    return asset($file_path);
}

function theme_include($path, $values = array())
{
    $theme = (env('THEME'))? env('THEME') : 'default';
    $full_path = 'frontend.' . $theme . '.' . $path;

    return view($full_path, $values);
}

function getIpClient()
{
    try{
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    }catch (\Exception $e){
        $ip = null;
    }

    return $ip;
}

/// convert ip từ chuỗi về mảng để tiện so sánh
function explodeIP($ips){
    $ips = trim($ips);
    $ip_arr = false;
    if(strpos($ips, ',') !== false){
        $arrayip = explode(',', $ips);

        foreach ($arrayip as $key=> $newarray){

            if($newarray){
                $ip_arr[$key] = trim($newarray);
            }else{
                continue;
            }

        }
    }else{
        $ip_arr[0] = $ips;
    }

    return $ip_arr;
}

function convertCurrency($amount, $order_currency_id, $paygate_currency_id){

    $amount = floatval($amount);
    $order_cur_obj = \App\Modules\Currency\Models\Currencies::find($order_currency_id);
    $paygate_cur_obj = \App\Modules\Currency\Models\Currencies::find($paygate_currency_id);

    if($paygate_cur_obj){

        if($order_cur_obj->id == $paygate_cur_obj->id){

            $pay_amount = number_format($amount, $paygate_cur_obj->decimal);

        }else{

            $value1 = $order_cur_obj->value;
            $value2 = $paygate_cur_obj->value;
            $converted_value = ($amount*$value2)/$value1;
            $pay_amount = number_format($converted_value, $paygate_cur_obj->decimal);
        }

        return $pay_amount;

    }else{
        return false;
    }

}

function userinfo(){

    if(auth()->check()){
        $user = auth()->user();
        $user_wallet = \App\Modules\Wallet\Models\Wallet::where(['user'=>$user->id, 'currency_id' => session()->get('currency')->id])->select('balance_decode', 'currency_id')->first();
        $balance = 0;
        if($user_wallet){
            $balance_number = number_format($user_wallet->balance_decode);
            $symbol = (session()->get('currency')->symbol_left) ? session()->get('currency')->symbol_left : session()->get('currency')->symbol_right;
            $balance = $balance_number.$symbol;
        }
        $user->balance = $balance;
    }else{
        $user = null;
    }
    return $user;
}

function getlang($lang_key){

    $code = app()->getLocale();
    $langcache = cache()->remember('langcache_'.$code, 1440, function() use($code) {
        return \App\Modules\Language\Models\Translation::where('lang_code', $code)->pluck('content','lang_key');
    });

    if(isset($langcache[$lang_key])){
        $value = $langcache[$lang_key];
    }else{
        $value = __($lang_key);
    }

    return $value;
}

/////ví dụ: create, list, edit...
function allow($name_of_permission){

    if(auth()->user()->hasPermissionTo($name_of_permission)){
        return true;
    }else{
        return false;
    }
}

function error_code($status)
{

    switch ($status) {

        case 1:
            $err = 'Thành công';
            break;
        case 2:
            $err = 'Sai mệnh giá';
            break;
        case 3:
            $err = 'Thất bại';
            break;

        case 4:
            $err = 'Bảo trì';
            break;

        case 99:
            $err = 'Chờ xử lý';
            break;

        ////Ví điện tử
        case 300:
            $err = 'Lỗi tạo lặp đơn hàng, vui lòng đợi 1 phút rồi thực hiện lại!';
            break;
        case 301:
            $err = 'Đơn hàng đã được thanh toán trước đó!';
            break;
        case 302:
            $err = 'Ví người dùng không tồn tại!';
            break;
        case 303:
            $err = 'Số dư bị tác động từ bên ngoài!';
            break;
        case 304:
            $err = 'Ví không hoạt động!';
            break;
        case 305:
            $err = 'Số dư không đủ để thực hiện giao dịch!';
            break;
        case 306:
            $err = 'Chống thanh toán lặp được kích hoạt!';
            break;

        /////Charging

        case 307:
            $err = 'Thẻ đã tồn tại trong hệ thống!';
            break;
        case 308:
            $err = 'Lỗi cú pháp Exception!';
            break;
        case 309:
            $err = 'Loại thẻ không tồn tại hoặc đang bị tắt!';
            break;

        case 310:
            $err = 'Lỗi nạp thẻ không rõ trạng thái!';
            break;
        case 311:
            $err = 'Thẻ sai định dạng!';
            break;
        case 312:
            $err = 'Xử lý thẻ thất bại (xulytheAPI)!';
            break;
        case 313:
            $err = 'Nhà cung cấp đổi thẻ không trả kết quả (FALSE)!';
            break;
        case 314:
            $err = 'Nhà cung cấp đổi thẻ không có file cứng!';
            break;
        case 315:
            $err = 'Nhà cung cấp đổi thẻ không tồn tại hoặc bị tắt!';
            break;
        case 317:
            $err = 'Mệnh giá thẻ không đúng';
            break;
        case 318:
            $err = 'Khong nhan duoc phan hoi tu nha mang! (code: 318)';
            break;
        case 319:
            $err = 'Lỗi thêm dữ liệu tại NCC!';
            break;
        case 320:
            $err = 'Dữ liệu gửi lên không đủ';
            break;
        case 321:
            $err = 'Merchant không tồn tại hoặc không hoạt động';
            break;
        case 322:
            $err = 'Dữ liệu gửi lên rỗng!';
            break;
        case 323:
            $err = 'Sai chữ ký!';
            break;
        case 324:
            $err = 'Merchant sai IP đăng ký!';
            break;
        case 325:
            $err = 'Tài khoản thành viên không hoạt động (code: 325)';
            break;
        case 326:
            $err = 'Thẻ không có trên hệ thống (code: 326)';
            break;
        case 328:
            $err = 'Lỗi tạo đơn hàng do tham số tạo không đúng (code: 328)';
            break;
        case 329:
            $err = 'Thiếu dữ liệu mệnh giá (code: 329)';
            break;
        case 330:
            $err = 'Không nhận được phản hồi từ nhà cung cấp (code: 330)';
            break;
        case 331:
            $err = 'Không lưu được dữ liệu tẩy thẻ vào database (code: 331)';
            break;
        case 332:
            $err = 'Không tồn tại thẻ này';
            break;
        default:
            $err = 'Lỗi trong quá trình xử lý!';
    }

    return $err;
}

///id là id của bảng seo, nó nằm trong news->seo
function render_seo($blade, $id=null){
    $seo = \App\Modules\Seo\Models\Seo::getMeta($id);
    return theme_view('widgets.'.$blade, compact('seo'))->render();
}


///Hàm mã hóa RSA
function encryptcode($key, $string)
{
    $newEncrypter = new \Illuminate\Encryption\Encrypter(base64_decode($key), 'AES-256-CBC');
    return $newEncrypter->encrypt($string);
}

//Hàm Giải mã RSA
function decryptcode($key, $string)
{
    $newEncrypter = new \Illuminate\Encryption\Encrypter(base64_decode($key), 'AES-256-CBC');
    return $newEncrypter->decrypt($string);
}
