<?php

namespace App\Modules\Downloads\Controllers;
use App\Modules\Currency\Models\Currencies;
use App\Modules\Frontend\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Modules\Downloads\Models\Downloads;
use App\Modules\Downloads\Models\DownloadCat;
use App\Modules\Downloads\Models\DownloadFiles;
use Auth;
use Gloudemans\Shoppingcart\Facades\Cart as Cart;

class CartController extends FrontendController
{
    public function getAddCart($id){
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        $product=Downloads::find($id);
        Cart::add([
            'id'=>$id,
            'name'=>$product->name,
            'qty'=>1,
            'price'=>(int)$product->price['VND'],
            'options'=>['img'=>$product->img]
        ]);
        return redirect()->route('cart.index');
    }

    public function index(){
        $items=Cart::content();
        $total=Cart::total();
        return theme_view('downloads.cart',compact('items','total'));
    }
    public function delete($rowId){

        if($rowId=='all'){
            Cart::destroy();
        }
        else {
            Cart::remove($rowId);
        }
        return back();
    }

    public function update(Request $request){
        Cart::update($request->rowId,$request->qty);
    }
}
