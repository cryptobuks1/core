<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Frontend\Controllers\FrontendController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App;
use View;
use DB;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductOrder;
use App\Modules\Product\Models\ProductGallery;
use App\Modules\Product\Models\ProductOptionValue;
use Cookie;
use Cart;
use Lang;
use Hash;
use GeoIp2\Database\Reader;
use App\Modules\User\Models\User as UserModel;
use App\Modules\Product\Models\ProductPrice;
use App\Modules\Paygate\Controllers\PaygateFrontController;
use App\Modules\Order\Helpers\OrderHelper;
use App\Modules\Vote\Models\VoteProduct;

class ProductFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function (Request $request, $next) {
            $current_lang = Lang::locale();
            $current_currency = session()->get('currency')->code;

            $current_group = 1;
            if (Auth::check()) {
                $current_group = Auth::user()->group;
            }
            View::share(['current_lang' => $current_lang,'current_currency'=>$current_currency,'current_group'=>$current_group]);
            return $next($request);
        });

    }

    public function viewProduct(Request $request)
    {

        if ($request->product_slug) {
            $product = Product::where(['product_slug' => $request->product_slug])
                ->where('status', 1)->first();

            if ($product) {

                $current_lang = Lang::locale();
                $current_currency = session()->get('currency')->code;

                $current_group = 1;
                if (Auth::check()) {
                    $current_group = Auth::user()->group;
                }


                if ($product->custom_layout) {
                    $layout = $product->custom_layout;
                } else {
                    $layout = 'default';
                }
                $cate = App\Modules\Categories\Models\Categories::where('url_key', $product->product_uri)->first();
                $gallery = Product::find($product->id)->gallery()
                    ->where('product_type', Product::PRODUCT_TYPE_DEFAULT)
                    ->orderBy('sort_order', 'ASC')
                    ->get();

                //View::share('title', $product->name);

                $page_body_class = 'detail page';

                if ($product->product_uri) {
                    $product->link = url('/') . '/' . $product->product_uri . '/' . $product->product_slug;
                }

                $relates = Product::where('product_uri', $product->product_uri)->where('product_branded', $product->product_branded)
                    ->where('id', '!=', $product->id)->limit(8)->get();
                $Brand = new App\Modules\Product\Models\ProductBrand();
                $Price = new App\Modules\Product\Models\ProductPrice();
                $Gallery = new ProductGallery();
                $product_old = Cookie::get('product_user');

                if ($product_old) {
                    $idarr = json_decode($product_old);
                    if (!in_array($product->id, $idarr)) {
                        array_push($idarr, $product->id);
                    }
                } else {
                    $idarr = array();
                    array_push($idarr, $product->id);
                }
                $seo_advanced = render_seo('seo_advanced');
                Cookie::queue(Cookie('product_user', json_encode($idarr)));
                //đánh giá
                $votes = App\Modules\Vote\Models\Votes::where('model_id',$product->id)->paginate(10);
                $precent_vote = App\Modules\Vote\Models\VoteProduct::where('model_id',$product->id)->where('module','Product')->first();
                if ($votes->count()){
                    foreach ($votes as $key => $vote){
                        $votes[$key]->replys = App\Modules\Vote\Models\ReplyComment::where('model_id',$product->id)->where('comment_id',$vote->id)->get();
                    }
                }
                //options value
                $options = ProductOptionValue::where('product_id', $product->id)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')->get()
                    ->groupBy('option_name');


                return theme_view('product.view', compact('cate', 'Gallery',
                    'Price', 'Brand', 'product', 'layout', 'gallery',
                    'options', 'page_body_class', 'relates', 'seo_advanced',
                    'current_currency', 'current_group', 'current_lang','votes','precent_vote'));
            } else {
                return abort(404);
            }

        }


    }

    public static function renderProductOption($product)
    {
        $result = '';
        $options = $product->options()->get();
        if ($options->count()) {
            foreach ($options as $option) {
                $values = ProductOptionValue::where('option_id', $option->id)
                    ->orderBy('sort_order', 'ASC')
                    ->get();
                $option->values = $values;
                $result .= theme_view('product.widgets.option', compact('option'))->render();
            }
        }
        return $result;
    }

    public static function getMostViewProducts()
    {
        $products = Product::where('status', 1)
            // ->orderBy('view_count','desc')
            ->limit(8)
            ->get();
        return $products;
    }

    public static function getPopularProducts()
    {
        $products = Product::where('status', 1)
            // ->orderBy('view_count','desc')
            ->limit(5)
            ->get();
        return $products;
    }

    public function ProductCatView(Request $request)
    {

        $current_lang = Lang::locale();
        $current_currency = session()->get('currency')->code;

        $current_group = 1;
        if (Auth::check()) {
            $current_group = Auth::user()->group;
        }

        if (!isset($request->product_uri)) {
            return redirect()->route('home');
        }

        $cate = App\Modules\Categories\Models\Categories::where('url_key', $request->product_uri)->first();
        if (!$cate) {
            return redirect()->route('home')->withErrors(['error' => 'Đường dẫn không tồn tại']);
        }

        $blocks = App\Modules\Block\Models\Block::where('key', 'chinh-sach-san-pham')->first();
        $blocks->items = App\Modules\Block\Models\BlockContent::where('block', $blocks->id)->get();

        ///hơi bị khó chỗ này...^^
        $arr_cat = ["$cate->id"];
        $arr_cat = (string)json_encode($arr_cat);
        $arr_cat = "'" . $arr_cat . "'";
        $products = Product::whereRaw('JSON_CONTAINS(cats,' . $arr_cat . ')')->where('status', 1);

        if (isset($request->brand) && $request->brand) {
            $brand = App\Modules\Product\Models\ProductBrand::where('slug', $request->brand)->first();
            if ($brand) {
                $products = $products->where('product_branded', $brand->id);
            }
        }
        if (isset($request->min) && $request->min) {
            $products = $products->where('price', '>', $request->min);
        }
        if (isset($request->max) && $request->max) {
            $products = $products->where('price', '<', $request->max);
        }
        $products = $products->paginate(20);
        if ($products->count()){
            foreach ($products as $pro => $product){
                $vote = VoteProduct::where('module','Product')->where('model_id',$product->id)->first();
                if ($vote){
                    $product->votes = $vote->score_avg;
                }

            }
        }
        $Price = new App\Modules\Product\Models\ProductPrice();
        $Gallery = new ProductGallery();
        $cates = App\Modules\Categories\Models\Categories::where('status', 1)->where('parent_id', 0)->orderBy('sort_order')->limit(10)->get();
        $brands = App\Modules\Product\Models\ProductBrand::where('status', 1)->limit(10)->get();
        return theme_view('pages.productcate', compact('cate', 'blocks', 'Gallery',
            'Price', 'products', 'cates', 'brands','VoteHelper'));
    }

    public function SearchProduct(Request $request)
    {
        if ($request->search) {
            $search_old = Cookie::get('search_old');
            if ($search_old) {
                $idarr = json_decode($search_old);
                if (!in_array($request->search, $idarr)) {
                    array_push($idarr, $request->search);
                }
            } else {
                $idarr = array();

                array_push($idarr, $request->search);
            }
            Cookie::queue(Cookie('search_old', json_encode($idarr), 1000));
            return redirect()->to(url('search/' . $request->search));
        }
        return redirect()->back();
    }

    public function viewSearchProduct(Request $request)
    {

        $blocks = App\Modules\Block\Models\Block::where('key', 'chinh-sach-san-pham')->first();
        $blocks->items = App\Modules\Block\Models\BlockContent::where('block', $blocks->id)->get();
        $products = Product::where('name', 'like', '%' . $request->search . '%')->orderBy('id', 'DESC');
        $search = $request->search;
        View::share('search', $search);

        if (isset($request->brand) && $request->brand) {
            $brand = App\Modules\Product\Models\ProductBrand::where('slug', $request->brand)->first();
            if ($brand) {
                $products = $products->where('product_branded', $brand->id);
            }
        }
        if (isset($request->min) && $request->min) {
            $products = $products->where('price', '>', $request->min);
        }
        if (isset($request->max) && $request->max) {
            $products = $products->where('price', '<', $request->max);
        }

        $products = $products->paginate(20);
        if ($products->count()){
            foreach ($products as $pro => $product){
                $vote = VoteProduct::where('module','Product')->where('model_id',$product->id)->first();
                if ($vote){
                    $product->votes = $vote->score_avg;
                }

            }
        }
        $Brand = new App\Modules\Product\Models\ProductBrand();
        $Price = new App\Modules\Product\Models\ProductPrice();
        $Gallery = new ProductGallery();
        $cates = App\Modules\Categories\Models\Categories::where('status', 1)->where('parent_id', 0)->orderBy('sort_order')->limit(10)->get();
        $brands = App\Modules\Product\Models\ProductBrand::where('status', 1)->limit(10)->get();
        return theme_view('pages.search', compact('search', 'cate', 'blocks', 'Gallery', 'Price', 'products', 'cates', 'brands'));

    }

    public function viewAllProduct(Request $request)
    {
        $blocks = App\Modules\Block\Models\Block::where('key', 'chinh-sach-san-pham')->first();
        $blocks->items = App\Modules\Block\Models\BlockContent::where('block', $blocks->id)->get();
        $products = Product::where('status', 1)->orderBy('id', 'DESC');
        if (isset($request->hot) && $request->hot) {
            $products = $products->where('hotdeal', 1);
        }
        if (isset($request->new) && $request->new) {
            $products = $products->where('new', 1);
        }
        if (isset($request->sale) && $request->sale) {
            $products = $products->where('bestsales', 1);
        }
        if (isset($request->brand) && $request->brand) {
            $brand = App\Modules\Product\Models\ProductBrand::where('slug', $request->brand)->first();
            if ($brand) {
                $products = $products->where('product_branded', $brand->id);
            }
        }
        if (isset($request->min) && $request->min) {
            $products = $products->where('price', '>', $request->min);
        }
        if (isset($request->max) && $request->max) {
            $products = $products->where('price', '<', $request->max);
        }
        $products = $products->paginate(20);
        if ($products->count()){
            foreach ($products as $pro => $product){
                $vote = VoteProduct::where('module','Product')->where('model_id',$product->id)->first();
                if ($vote){
                    $product->votes = $vote->score_avg;
                }

            }
        }
        $Price = new App\Modules\Product\Models\ProductPrice();
        $Gallery = new ProductGallery();
        $cates = App\Modules\Categories\Models\Categories::where('status', 1)->where('parent_id', 0)->orderBy('sort_order')->limit(10)->get();
        $brands = App\Modules\Product\Models\ProductBrand::where('status', 1)->limit(10)->get();
        return theme_view('pages.product', compact('blocks', 'Gallery', 'Price', 'products', 'cates', 'brands', 'current_group', 'current_currency'));

    }

    public function quickBuy(Request $request)
    {

        $current = $this->getCurrentValue();

        if (isset($request->item) && is_numeric($request->item)) {
            $id = strip_tags($request->item);
            $product = Product::where('id', $id)->where('status', 1)->first();
            if ($product) {

                $price = $product->price[$current['currency_code']][$current['group_id']];
                if ($price && $price >= 0) {

                    $listedprice = $product->listedprice[$current['currency_code']];
                    if ($listedprice && $listedprice > 0) {
                        $discount = (($listedprice - $price) / $listedprice) * 100;

                    } else {
                        $discount = 0;
                    }

                    Cart::instance('Product')->add([
                        'id' => $product->id,
                        'name' => $product->name,
                        'qty' => 1,
                        'price' => $price,
                        'options' => [
                            'discount' => $discount,
                            'currency_id' => $current['currency_id'],
                            'currency_code' => $current['currency_code'],
                        ]
                    ]);
                    return redirect()->route('frontend.product.cart')->with('success', 'Thêm sản phẩm thành công');
                } else {
                    return redirect()->back()->withErrors(['error' => 'Sản phẩm chưa được thiết lập giá bán']);
                }

            } else {
                return redirect()->back()->withErrors(['error' => 'Sản phẩm không tồn tại']);
            }


        }

    }

    public function getCurrentValue()
    {
        $current_lang = Lang::locale();

        $current_group = 1;
        if (Auth::check()) {
            $current_group = Auth::user()->group;
        }

        return [
            'lang_code' => $current_lang,
            'currency_code' => session()->get('currency')->code,
            'currency_id' => session()->get('currency')->id,
            'group_id' => $current_group,
        ];
    }


    ///Giỏ hàng
    public function cart(Request $request)
    {

        $title = 'Giỏ hàng';
        $shopping_cart = static::renderShoppingCart();
        $citys = DB::table('cities')->orderBy('sort', 'ASC')->get();
        $userAddress = null;
        if ($request->receiver == "old" && Auth::check()){
            $userAddress = App\Modules\User\Models\UserAddress::where('user_id',Auth::user()->id)->orderBy('id','DESC')->first();
        }
        return theme_view('product.cart', compact('title', 'citys', 'shopping_cart', 'userAddress', 'districts'));
    }

    public function ajaxDistrict(Request $request)
    {

        if (!isset($request->city_code) || !$request->city_code) {
            return false;
        }
        $district = DB::table('devvn_quanhuyen')->where('city_code', $request->city_code)->orderBy('name', 'ASC')->get();
        return $district;
    }

    public function postAjxcheckout(Request $request)
    {
        $input = $request->all();
        $current = $this->getCurrentValue();

        if ($input['type'] == 'add' && isset($input['id'])) {
            $product = Product::find($input['id']);
            if ($product) {
                $price = $product->price[$current['currency_code']][$current['group_id']];
                if ($price && $price >= 0) {

                    $listedprice = $product->listedprice[$current['currency_code']];
                    if ($listedprice && $listedprice > 0) {
                        $discount = (($listedprice - $price) / $listedprice) * 100;
                    } else {
                        $discount = 0;
                    }
                    $cartItem = Cart::instance('Product')->add([
                        'id' => $product->sku,
                        'name' => $product->name,
                        'qty' => 1,
                        'price' => $price,
                        'options' => [
                            'discount' => $discount,
                            'currency_id' => $current['currency_id'],
                            'currency_code' => $current['currency_code'],
                        ]
                    ]);
                    $result['row'] = $cartItem->rowId;
                }
            }

        } elseif ($input['type'] == 'remove') {
            if (isset($input['row'])) {
                Cart::instance('Product')->remove($input['row']);
            }
        }
        if ($input['type'] == 'update') {
            if (isset($input['qty']) && isset($input['row'])) {
                Cart::instance('Product')->update($input['row'], intval($input['qty']));
            }
        } elseif ($input['type'] == 'delete') {
            Cart::instance('Product')->destroy();
        }
        $shopping_cart = static::renderShoppingCart();

        $result['shopping_cart'] = $shopping_cart;
        echo json_encode($result);
    }

    public static function renderShoppingCart()
    {
        $paygates = PaygateFrontController::showpaygate('listPaygateImage', 'payment');
        $shopping_cart = theme_view('pages.giohang', compact('paygates'))->render();
        return $shopping_cart;
    }

    public function postCart(Request $request)
    {
        if (!count(Cart::instance('Product')->content())) {

            return redirect()->route('home')->withErrors('Giỏ hàng trống, vui lòng chọn hàng cần mua để thanh toán');
        }
        $this->validate($request, [
            'paygate_code' => 'required',
            'name' => 'required',
            'phoneEmail' => 'required',
            'receiver_name' => 'required',
            'receiver_city' => 'required',
            'receiver_phone' => 'required',
            'receiver_address' => 'required',
        ]);

        ///Kiểm tra user của khách hàng đã tồn tại hay chưa, nếu chưa thì tạo tk với thông tin đó.
        $phoneEmail = $request->phoneEmail;
        $info = null;
        if (filter_var($phoneEmail, FILTER_VALIDATE_EMAIL)) {
            $info = 'email';
        } elseif (is_numeric($phoneEmail)) {

            if (strlen($phoneEmail) == 10 && substr($phoneEmail, 0, 1) == '0') {
                $info = 'phone';
            } else {
                $info = 'username';
            }
        } else {
            $info = null;
        }

        $user = null;
        if(!Auth::check()){

            if ($info == 'phone' || $info == 'email') {
                $check_user = UserModel::where($info, $phoneEmail)->first();
                if (!$check_user) {
                    $datau['username'] = null;
                    $datau['name'] = $request->name;
                    if ($info == 'phone') {
                        $datau['phone'] = $request->phoneEmail;
                        $datau['email'] = null;
                    } else {
                        $datau['email'] = $request->phoneEmail;
                        $datau['phone'] = null;
                    }
                    $password = mt_srand(10);
                    $datau['password'] = Hash::make($password);

                    ///Tạo tài khoản
                    try {
                        $reader = new Reader(storage_path('app/GeoIP2-Country.mmdb'));
                        $record = $reader->country(getIpClient());
                        $country_code = $record->registeredCountry->isoCode;
                    } catch (\Exception $k) {
                        $country_code = 'VN';
                    }
                    $datau['country_code'] = $country_code;
                    $group_setting = \App\Modules\Setting\Models\Setting::where('key', 'default_user_group')->first();
                    $group_id = 2;  // Mặc định nhóm thành viên
                    if ($group_setting) {
                        $group_id = $group_setting->value;
                    }
                    $datau['group'] = $group_id;
                    $datau['ip'] = getIpClient();
                    $approve = \App\Modules\Setting\Models\Setting::where('key', 'approve_user')->first();
                    $datau['status'] = ($approve->value == 1) ? 0 : 1;
                    $datau['parent_id'] = 1;
                    $datau['ref'] = uniqid();

                    $user = \App\Modules\User\Helpers\FlightHelper::createUser($datau);

                    if($user){

                        if($info == 'email'){
                            /// Gửi thư mật khẩu đăng nhập cho khách hàng
                            $mail = new App\Modules\Sendmail\Controllers\SendmailController();
                            $mail->sendmail();
                        }

                        if($info == 'phone'){
                            /// Gửi thư mật khẩu đăng nhập cho khách hàng
                            $sms = new App\Modules\Sms\Controllers\SmsController();
                            $sms->sendSms();
                        }

                        //////Đăng nhập luôn
                        Auth::loginUsingId($user->id);
                    }


                } else {
                    return redirect()->route('frontend.account.login')->withErrors(['error' => 'Vui lòng đăng nhập trước khi mua hàng!']);
                }
            } else {

                return redirect()->route('home')->withErrors('Thông tin người thanh toán không hợp lệ!');
            }
        }else{
            $user = Auth::user();
        }

        if (isset($user->id)) {

            $checksum = md5($user->id.$request->receiver_phone);
            $ship_address = App\Modules\User\Models\UserAddress::where('checksum', $checksum)->first();
            if (!$ship_address) {
                $user_add = new App\Modules\User\Models\UserAddress();
                $user_add->user_id = $user->id;
                $user_add->name = $request->receiver_name;
                $user_add->phone = $request->receiver_phone;
                $user_add->email = $request->receiver_email;
                $user_add->city = $request->receiver_city;
                $user_add->address = $request->receiver_address;
                $user_add->save();

                $ship_address = $user_add;
            }

            $current = $this->getCurrentValue();

            $paygate_code = explode('.', $request->input('paygate_code'));
            if ($paygate_code[0] === 'Wallet') {

                $wallet = \App\Modules\Wallet\Models\Wallet::where(['user' => $user->id, 'currency_code' => $current['currency_code']])->first();

                if (!$wallet) {
                    Cart::instance('Product')->destroy();
                    return redirect()->route('home')->withErrors(['message' => 'Ví không tồn tại!']);
                } else {
                    if ($wallet->balance_decode < Cart::instance('Product')->total(0, '', '')) {
                        Cart::instance('Product')->destroy();
                        return redirect()->route('home')->withErrors(['message' => 'Ví của bạn không đủ tiền! Vui lòng nạp tiền vào ví trước.']);
                    }
                }

            }

            $minute = date('dmYHis', time());
            $order_code = 'PW' . strtoupper(uniqid());

            $order_fees = OrderHelper::paygateFees(Cart::instance('Product')->total(0, '', ''), $paygate_code[0], $paygate_code[1], $user->id, 'p');
            $data = array();
            $data['order_code'] = $order_code;
            $data['currency_id'] = $current['currency_id'];
            $data['payer_id'] = $user->id;
            $data['payee_id'] = 1;
            $data['order_type'] = 'Buy';
            $data['module'] = 'Product';
            $data['net_amount'] = Cart::instance('Product')->total(0, '', '');
            $data['fees'] = $order_fees;
            $data['paygate_code'] = $paygate_code[0];
            $data['bank_code'] = $paygate_code[1];
            $data['payment_type'] = 'p';
            $data['status'] = 'none';
            $data['shipment'] = 1;
            $data['shipment_info'] = $ship_address->id;
            $data['payment'] = 'none';
            $data['admin_note'] = '';
            $data['description'] = 'Mua sản phẩm';
            $data['creator'] = $user->id;
            $data['code'] = 'P' . strtoupper(md5($minute . $user->id . json_encode(Cart::instance('Product')->content()->toArray())));

            $validate = OrderHelper::validateOrder(Cart::instance('Product')->total(0, '', ''), $paygate_code[0], $paygate_code[1], $user->id, 'p');
            if ($validate !== 'validated') {
                return redirect()->back()->withErrors(['message' => $validate]);
            }

            $order = \App\Modules\Order\Models\Order::createOrder($data);

            if ($order && isset($order->id)) {

                foreach (json_decode(Cart::instance('Product')->content()) as $key => $row) {

                    $product = Product::where('id', $row->id)->first();

                    if (!$product) {
                        Cart::remove($row->rowId);
                        continue;
                    } else {

                        ///Chống hack số lượng
                        $qty = ($row->qty >= 1) ? intval($row->qty) : 1;
                        $price = floatval($product->price[$current['currency_code']][$current['group_id']]);

                        $listedprice = $product->listedprice[$current['currency_code']];
                        if ($listedprice && $listedprice > 0) {
                            $discount = (($listedprice - $price) / $listedprice) * 100;
                        } else {
                            $discount = 0;
                        }

                        if ($price && $price >= 0) {

                            $net_amount = $price * $qty;

                            $prOrder = new ProductOrder;
                            $prOrder->order_code = $order_code;
                            $prOrder->user = $user->id;
                            $prOrder->user_info = $user->name;
                            $prOrder->product = $product->name;
                            $prOrder->product_id = $product->id;
                            $prOrder->product_type = 'product';
                            $prOrder->value = $listedprice;
                            $prOrder->order_id = $order->id;
                            $prOrder->currency_id = $current['currency_id'];
                            $prOrder->currency_code = $current['currency_code'];
                            $prOrder->price = $price;
                            $prOrder->qty = $qty;
                            $prOrder->sumvalue = $listedprice * $qty;
                            $prOrder->discount = $discount;
                            $prOrder->subtotal = $net_amount;
                            $prOrder->status = 'none';
                            $prOrder->payment = 'none';
                            $prOrder->cart_content = json_encode($row);
                            $prOrder->method = 'WEB';
                            $prOrder->save();

                        } else {
                            Cart::remove($row->rowId);
                            continue;
                        }

                    }

                }

                ///Kiểm tra có tạo đc order ko
                $product_orders = ProductOrder::where('order_code', $order_code)->get();

                if (count($product_orders) == 0) {
                    return redirect()->route('home')->withErrors(['message' => 'Không thể tạo được đơn hàng']);
                }

                $sum = floatval($product_orders->sum('subtotal'));

                $order_fees_recount = OrderHelper::paygateFees($sum, $paygate_code[0], $paygate_code[1], $user->id, 'p');

                /// Update lại tổng số tiền
                $order->net_amount = $sum;
                $order->fees = $order_fees_recount;
                $order->pay_amount = $sum + $order_fees_recount;
                $order->update();
                $token = $order->token;
                $orderid = $order->order_code;

                Cart::instance('Product')->destroy();

                return redirect()->route('frontend.order.checkout', compact('orderid', 'token'));

            } else {
                return redirect()->route('home')->withErrors(['message' => 'Đơn hàng không được tạo thành công!']);
            }

        } else {
            return redirect()->back()->withErrors(['error' => 'Lỗi khởi tạo tài khoản thành viên cho đơn hàng']);
        }


    }


}
