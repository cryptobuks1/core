<?php

namespace App\Modules\Giftcode\Vendors\Movie;

use DB;
use Auth;
use Log;

class Movie
{
    public function chargecode(){

        if(Auth::check()){
            $user_id = Auth::user()->id;
            $Code = $request->code;
            $Carbon = Carbon::now();
            // Kiểm tra Giftcode
            $checkGiftCode = Giftcode::where('code',$request->code)
                ->orderBy('id','DESC')->first();
            if($checkGiftCode){
                // Kiểm tra giftcode đã được sử dụng hay chưa
                $checkUsingGiftCode = DB::table('giftcode_logs')
                    ->where('code', $request->code)->where('status','used')->count();
                if($checkUsingGiftCode > 0){
                    return redirect()->back()->withErrors("Gift code has been used!");
                }
                // Tính tiền cho gói phim
                $Movie_Order = MoviePackageOrder::where('order_code',$request->order_code)
                    ->select('id','price','plan_id','order_code')->first();
                if($Movie_Order){
                    // Kiem tra xem Giftcode co đúng với gói người dùng muốn hay không.
                    $checkPackage = $this->checkSKU($Movie_Order->plan_id, $checkGiftCode->sku);
                    if($checkPackage == "ok"){
                        //  * $Movie_Order->price
                        $Price =  $Movie_Order->price - (($Movie_Order->price * 10) / 100);
                        // Cập nhật lại Order
                        $updateOrder = $this->updateOrder($Movie_Order->order_code,$request->token, $Price);
                        if($updateOrder === "ok"){
                            // Insert log giftcode
                            $this->insertLogs($user_id,$request->code, $checkGiftCode->sku, $checkGiftCode->type);
                            return redirect()->back()->withErrors("You have used a giftcode successfully");
                        }else{
                            return redirect()->back()->withErrors("Errors system, please check again!");
                        }
                    }else{
                        return redirect()->back()->withErrors("Gift code is not used for this package!");
                    }
                }else{
                    return response()->json(["errors","Has find order not found."]);
                }
            }else{
                return redirect()->back()->withErrors("Gift code you entered is incorrect!");
            }
        }else{
            return redirect()->back()->withErrors("Error processing login, please login your account first.");
        }
    }

    private function checkSKU($idPackage, $sku){
        $Package = DB::table('movie_package')->where('id',$idPackage)->where('sku',$sku)
            ->where('status',1)->first();
        if($Package){
            return "ok";
        }else{
            return "no";
        }
    }
    private function updateOrder($OrderCode, $token, $Price){
        $updateOrder = DB::table('orders')->where('order_code', $OrderCode)
            ->where('token',$token)->where('status','none')->update([
                'net_amount'=>$Price,
                'pay_amount'=>$Price
            ]);
        $updateMovieOrder = DB::table('movie_order')->where('order_code',$OrderCode)
            ->where('payment','none')->update([
                'price'=>$Price
            ]);
        if($updateOrder && $updateMovieOrder){
            return "ok";
        }else{
            return "no";
        }
    }

    protected function insertLogs($user_id,$code,$sku, $type){
        $Carbon = new Carbon();

        $checkCode = DB::table('giftcode_logs')
            ->where('user_id','=',$user_id)
            ->where('status','=','unused')->count();

        if($checkCode > 0){
            return "no";
        }
        $GiftCodeLogsDC = DB::table('giftcode_logs')->insert([
            'code'=>$code,
            'user_id'=>$user_id,
            'model'=>'Movie',
            'checksum'=>$type . md5($code . $sku . $user_id),
            'logs'=>'Đã sử dụng gift code: ' . $code . ' vào lúc' . $Carbon,
            'sku'=> $sku,
            'status'=>'unused'
        ]);
        if($GiftCodeLogsDC){
            return "ok";
        }else{
            return "no";
        }
    }


}