<?php

namespace App\Modules\Realestates\Controllers;
use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\Order\Helpers\OrderHelper;
use App\Modules\Order\Models\Order;
use App\Modules\Paygate\Controllers\PaygateFrontController;
use App\Modules\Realestates\Models\BuyVip;
use App\Modules\Realestates\Models\Cities;
use App\Modules\Realestates\Models\GroupProject;
use App\Modules\Realestates\Models\Orders;
use App\Modules\Realestates\Models\Provinces;
use App\Modules\Realestates\Models\Wallets;
use App\Modules\Ztest\Models\Votes;
use App\User;
use Illuminate\Http\Request;
use App\Modules\Realestates\Models\RealestatesType;
use App\Modules\Realestates\Models\Realestates;
use App\Modules\Realestates\Models\RealestatesImg;
use App\Modules\Realestates\Models\Project;
use App\Modules\Realestates\Models\Search;
use App\Modules\Realestates\Models\RealestatesOrderItems;
use App\Modules\Realestates\Models\Broker;
use Auth;
use Cookie;
use Carbon\Carbon;

class RealestatesFrontController extends FrontendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();

        $request = Request();
        $now = Carbon::now();
        $data = Realestates::where('module', 'Realestates')->where('end_date', '<', $now)->update(['status' => 3]);
        $user_id = Auth::user()->id;
        $data = Realestates::where('user_id', $user_id)->orderBy('id', 'desc')->paginate(20);
        $vip = BuyVip::all();
        $broker = Broker::where('user_id', $user_id)->first();
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $title = "Search: " . $data;
            $data = Realestates::where('title', 'LIKE', '%' . $keyword . '%')->orderBy('id', 'DESC')->paginate(20);
        }
        return theme_view('realestates.realestates', compact('data', 'vip', 'title', 'user', 'broker'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paygates = PaygateFrontController::showpaygate('listPaygatePayFullwidth', 'payment');
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $date = $dt->toDateString();
        $end_day = $dt->addDays(6)->toDateString();
        $vip = BuyVip::where('level', '<', '7')->orderBy('id', 'desc')->get();
        $types = RealestatesType::all();
        $cities = Cities::all();
        $provinces = Provinces::all();
        $project = Project::all();
        return theme_view('realestates.dang_tin', compact('types', 'cities', 'provinces', 'vip', 'date', 'end_day', 'paygates', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = \App\Modules\User\Models\User::find(Auth::user()->id);
        if (!$user) {
            return redirect()->back()->withErrors(['error' => "Tài khoản thành viên không tồn tại"]);
        }
        $user_id = Auth::user()->id;
        $data1 = new Realestates;
        $data1->module = 'Realestates';
        $data1->user_id = $user_id;
        $data1->title = $request->title;
        $data1->slug = str_slug($request->title . '-' . $data1->id);
        $data1->form = $request->form;
        $data1->type = $request->type;
        $data1->city = $request->city;
        $data1->province = $request->province;
        $data1->commune = $request->commune;
        $data1->street = $request->street;
        $data1->project = $request->project;
        $data1->acreage = $request->acreage;
        $data1->price = $request->price;
        $data1->address = $request->address;
        $data1->description = $request->description;
        $data1->facade = $request->facade;
        $data1->way_in = $request->way_in;
        $data1->direction = $request->direction;
        $data1->directio_balcony = $request->directio_balcony;
        $data1->floor = $request->floor;
        $data1->bedroom = $request->bedroom;
        $data1->toilet = $request->toilet;
        $data1->furniture = $request->furniture;
        $data1->name_contact = $request->name_contact;
        $data1->address_contact = $request->address_contact;
        $data1->phone_contact = $request->phone_contact;
        $data1->email_contact = $request->email_contact;
        $data1->type_news = 7;
        $data1->featured = 0;
        $data1->start_date = $request->start_date;
        $data1->end_date = $request->end_date;
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar->getClientOriginalName();
            $data1->image = $avatar;
            $request->avatar->storeAs('public/avatar', $avatar);
        }
        $data1->save();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new RealestatesImg([
                    'realestates_id' => $data1->id,
                    'img' => $filename,
                ]);
                $file->save();
            }
        }
        if ($request->type_news != 7) {
            $news = Realestates::find($data1->id);
            $vip = BuyVip::where('level', $request->type_news)->first();
            $total = $vip->price;
            $check = $news->type_news;
            $this->validate($request, [
                'paygate_code' => 'required'
            ]);
            $paygate_code = explode('.', $request->input('paygate_code'));
            if (Auth::user()->id == 1) {
                return redirect()->back()->withErrors(['error' => "Tài khoản Admin này không được mua gói vip"]);
            }

            if ($paygate_code[0] === 'Wallet') {

                $wallet = Wallets::where(['user' => Auth::user()->id, 'currency_code' => 'VND'])->first();

                if (!$wallet) {
                    return redirect()->route('tin.rao')->withErrors(['message' => 'Ví không tồn tại!']);
                } else {
                    if ($wallet->balance_decode < $total) {
                        return redirect()->route('tin.rao')->withErrors(['message' => 'Ví của bạn không đủ tiền! Vui lòng nạp tiền vào ví trước.']);
                    }
                }
            }
            $order_code = 'RW' . uniqid();
            $order_fees = OrderHelper::paygateFees($total, $paygate_code[0], $paygate_code[1], Auth::user()->id, 'p');

            /// Tạo nháp order
            if ($check != $request->type_news) {
                $data = array();
                $data['order_code'] = $order_code;
                $data['currency_id'] = 1;
                $data['payer_id'] = Auth::user()->id;
                $data['payee_id'] = 1;
                $data['order_type'] = 'Buy';
                $data['module'] = 'Realestates';
                $data['net_amount'] = $total;
                $data['fees'] = $order_fees;
                $data['paygate_code'] = $paygate_code[0];
                $data['bank_code'] = $paygate_code[1];
                $data['payment_type'] = 'p';
                $data['status'] = 'none';
                $data['payment'] = 'none';
                $data['admin_note'] = '';
                $data['realestates_id'] = $data1->id;
                $data['description'] = 'Tin vip: ' . $vip->name . ', Giá: ' . $vip->price . ', Số ngày:' . $vip->day . ', Level: ' . $vip->level;
                $data['creator'] = Auth::user()->id;
                $data['code'] = 'R' . uniqid();

                $validate = OrderHelper::validateOrder($total, $paygate_code[0], $paygate_code[1], Auth::user()->id, 'p');
                if ($validate !== 'validated') {
                    return redirect()->back()->withErrors(['message' => $validate]);
                }
                $order = Order::createOrder($data);
                if ($order) {
                    $order_item = new RealestatesOrderItems;
                    $order_item->order_id = $order->id;
                    $order_item->order_code = $order_code;
                    $order_item->realestates_id = $data1->id;
                    $order_item->realestates_title = $news->title;
                    $order_item->currency_id = 1;
                    $order_item->currency_code = 'VND';
                    $order_item->module = 'Realestates';
                    $order_item->vip_name = $vip->name;
                    $order_item->vip_enddate = $request->end_date;
                    $order_item->vip_startdate = $request->start_date;
                    $order_item->vip_level = $request->type_news;
                    $order_item->price = $vip->price;
                    $order_item->user = Auth::user()->id;
                    $order_item->user_info = 'nghia212239';
                    $order_item->status = 'none';
                    $order_item->payment = 'none';
                    $order_item->vip_content = $vip;
                    $order_item->provider = 'Stock';
                    $order_item->method = 'WEB';
                    $order_item->save();
                }
                $token = $order->token;
                $orderid = $order->order_code;

                return redirect()->route('frontend.order.checkout', compact('orderid', 'token'));
            }
        }
        return redirect()->route('tin.rao')->with('success', 'Đăng tin thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paygates = PaygateFrontController::showpaygate('listPaygatePayFullwidth', 'payment');
        $vip = BuyVip::all();
        $files = RealestatesImg::where('realestates_id', $id)->get();
        $types = RealestatesType::all();
        $data = Realestates::find($id);
        $cities = Cities::all();
        $province = Provinces::where('city_code', $data->city)->get();
        $project = Project::where('province', $data->province)->get();
        return theme_view('realestates.edit_tin', compact('types', 'data', 'cities', 'province', 'files', 'vip', 'paygates', 'project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Realestates::find($id);
        $data->title = $request->title;
        $data->slug = str_slug($request->title . '-' . $id);
        $data->form = $request->form;
        if ($request->type != '') {
            $data->type = $request->type;
        }
        $data->city = $request->city;
        $data->province = $request->province;
        $data->commune = $request->commune;
        $data->street = $request->street;
        $data->project = $request->project;
        $data->acreage = $request->acreage;
        $data->price = $request->price;
        $data->address = $request->address;
        $data->description = $request->description;
        $data->facade = $request->facade;
        $data->way_in = $request->way_in;
        $data->direction = $request->direction;
        $data->directio_balcony = $request->directio_balcony;
        $data->floor = $request->floor;
        $data->bedroom = $request->bedroom;
        $data->toilet = $request->toilet;
        $data->furniture = $request->furniture;
        $data->name_contact = $request->name_contact;
        $data->address_contact = $request->address_contact;
        $data->phone_contact = $request->phone_contact;
        $data->email_contact = $request->email_contact;
        $data->pay = $request->pay;
        $data->status = $request->status;
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar->getClientOriginalName();
            $data->image = $avatar;
            $request->avatar->storeAs('public/avatar', $avatar);
        }
        $data->save();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/avatar', $filename);
                $file = new RealestatesImg([
                    'realestates_id' => $id,
                    'img' => $filename,
                ]);
                $file->save();
            }
        }
        return redirect()->route('tin.rao')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Realestates::destroy($id);
        return back()->with('success', 'Xóa thành công');
    }

    public function getAjaxCities(Request $request)
    {
        $city = Cities::where('code', $request->code)->first();
        if ($city) {
            $provinces = Provinces::where('city_code', $request->code)->get();
            $html = '';
            $html .= "<option value=''>-- Chọn quận/huyện --</option>";
            foreach ($provinces as $value) {
                $html .= "<option value='" . $value['name'] . "'>" . $value['name'] . "</option>";
            }
            return $html;
        }
    }

    public function getAjaxProvince(Request $request)
    {
        $city = Provinces::where('name', $request->code)->first();
        if ($city) {
            $project = Project::where('province', $request->code)->get();
            $html = '';
            $html .= "<option value=''>-- Chọn dự án --</option>";
            foreach ($project as $value) {
                $html .= "<option value='" . $value['name'] . "'>" . $value['name'] . "</option>";
            }
            return $html;
        }
    }

    public function getAjaxForm(Request $request)
    {
        $type = RealestatesType::where('form_id', $request->code)->get();
        $html = '';
        $html .= "<option >-- Chọn loại nhà đất --</option>";
        foreach ($type as $value) {
            $html .= "<option value='" . $value['name'] . "'>" . $value['name'] . "</option>";
        }
        return $html;
    }

    public function deleteImg($id)
    {
        RealestatesImg::destroy($id);
        return back();
    }

    //Trang home
    public function tinrao(Request $request)
    {
        $dt = Carbon::now();
        $today = $dt->toDateString();
        $data1 = Realestates::where('approved', 1)->where('status', 1)->orderBy('id', 'desc')->where('end_date', '>=', $today)->paginate(6);
        $data2 = Realestates::where('approved', 1)->where('featured', 1)->where('status', 1)->orderBy('type_news', 'asc')->where('end_date', '>=', $today)->orderBy('id', 'desc')->paginate(6);
        $city = Cities::all();
        $province = Provinces::all();
        $search = Search::where('type', 1)->where('status', 1)->get();
        $search2 = Search::where('type', 3)->where('status', 1)->get();
        $search3 = Search::where('type', 2)->where('status', 1)->get();
        $search4 = Search::where('type', 4)->where('status', 1)->get();
        $type = RealestatesType::where('form_id', 1)->get();
        $type1 = RealestatesType::where('form_id', 2)->get();
        $pro = Provinces::where('city_code', $request->city)->get();

        if ($request->has('price') | $request->has('city') | $request->has('province') | $request->has('name') | $request->has('acreage') | $request->has('type')) {
            $code = 0;
            $data = Realestates::where('approved', 1)->where('status', 1)->where('form', 1)->where('module', 'Realestates');
            if ($request->has('name') && $request->name !== null) {
                if (($request->name)) {
                    $data = $data->where('title', 'like', '%' . $request->name . '%');
                } else {
                    return redirect()->back()->withErrors(['error' => 'Không có tin rao nào']);
                }
            }
            foreach ($type as $item) {
                if ($request->has('type') && $request->type == $item->name) {
                    $data = $data->where('type', $request->type);
                }
            }

            foreach ($city as $item) {
                if ($request->has('city') && $request->city == $item->code) {
                    $data = $data->where('city', $request->city);
                }
            }

            foreach ($province as $item) {
                if ($request->has('province') && $request->province == $item->name) {
                    $data = $data->where('province', $request->province);
                }
            }

            foreach ($search as $item) {
                if ($request->has('price') && $request->price == $item->code) {
                    $data = $data->whereBetween('price', [$item->start, $item->end]);
                }
            }
            foreach ($search2 as $item) {
                if ($request->has('acreage') && $request->acreage == $item->code) {
                    $data = $data->whereBetween('acreage', [$item->start, $item->end]);
                }
            }
            $data = $data->orderBy('type_news', 'asc')->orderBy('id', 'DESC')->paginate(6);
            return theme_view('realestates.nha_dat_ban', compact('data', 'city', 'pro', 'type', 'code', 'search', 'search2'));
        }

        if ($request->has('price1') | $request->has('city1') | $request->has('province1') | $request->has('name1') | $request->has('acreage1') | $request->has('type1')) {
            $code = 1;
            $data = Realestates::where('approved', 1)->where('status', 1)->where('form', 2)->where('module', 'Realestates');
            if ($request->has('name1') && $request->name1 !== null) {
                if (($request->name1)) {
                    $data = $data->where('title', 'like', '%' . $request->name1 . '%');
                } else {
                    return redirect()->back()->withErrors(['error' => 'Không có tin rao nào']);
                }
            }
            foreach ($type1 as $item) {
                if ($request->has('type1') && $request->type1 == $item->name) {
                    $data = $data->where('type', $request->type1);
                }
            }

            foreach ($city as $item) {
                if ($request->has('city1') && $request->city1 == $item->code) {
                    $data = $data->where('city', $request->city1);
                }
            }

            foreach ($province as $item) {
                if ($request->has('province1') && $request->province1 == $item->name) {
                    $data = $data->where('province', $request->province1);
                }
            }

            foreach ($search3 as $item) {
                if ($request->has('price1') && $request->price1 == $item->code) {
                    $data = $data->whereBetween('price', [$item->start, $item->end]);
                }
            }

            foreach ($search4 as $item) {
                if ($request->has('acreage1') && $request->acreage1 == $item->code) {
                    $data = $data->whereBetween('acreage', [$item->start, $item->end]);
                }
            }
            $data = $data->orderBy('type_news', 'asc')->orderBy('id', 'DESC')->paginate(6);
            return theme_view('realestates.nha_dat_thue', compact('data', 'city', 'pro', 'type1', 'code', 'search3', 'search4'));
        }
//        Cookie::queue('typer','');
        return theme_view('realestates.home', compact('data1', 'data2', 'data', 'city', 'pro', 'type', 'type1', 'code', 'search', 'search2', 'search3', 'search4'));
    }

    public function detail($id, $slug)
    {
        $data = Realestates::find($id);
        $vip = BuyVip::all();
        $img = RealestatesImg::where('realestates_id', $id)->get();
        $type = RealestatesType::all();
        $project = Project::where('name', $data->project)->first();
        return theme_view('realestates.detail', compact('data', 'type', 'img', 'vip', 'project'));
    }

    public function TinNews(Request $request)
    {
        $data = new Realestates;
        $dt = Carbon::now();
        $today = $dt->toDateString();
        $data = $data->where('approved', 1)->where('status', 1)->where('module', 'Realestates')->where('end_date', '>=', $today);
        $city = Cities::all();
        $province = Provinces::all();
        $type = RealestatesType::all();
        $pro = Provinces::where('city_code', $request->city)->get();
        if ($request->has('name') && $request->name !== null) {
            if (($request->name)) {
                $data = $data->where('title', 'like', '%' . $request->name . '%');
            } else {
                return redirect()->back()->withErrors(['error' => 'Không có tin rao nào']);
            }
        }

        foreach ($city as $item)
            if ($request->has('city') && $request->city == $item->code) {
                $data = $data->where('city', $request->city);
            }

        foreach ($province as $item)
            if ($request->has('province') && $request->province == $item->name) {
                $data = $data->where('province', $request->province);
            }
        $data = $data->orderBy('id', 'DESC')->paginate(6);
        return theme_view('realestates.tin_moi', compact('data', 'city', 'pro', 'type'));
    }

    public function featured(Request $request)
    {
        $data = new Realestates;
        $dt = Carbon::now();
        $today = $dt->toDateString();
        $data = $data->where('approved', 1)->where('featured', 1)->where('status', 1)->where('module', 'Realestates')->where('end_date', '>=', $today);
        $city = Cities::all();
        $province = Provinces::all();
        $type = RealestatesType::all();
        $pro = Provinces::where('city_code', $request->city)->get();
        if ($request->has('name') && $request->name !== null) {
            if (($request->name)) {
                $data = $data->where('title', 'like', '%' . $request->name . '%');
            } else {
                return redirect()->back()->withErrors(['error' => 'Không có tin rao nào']);
            }
        }

        foreach ($city as $item)
            if ($request->has('city') && $request->city == $item->code) {
                $data = $data->where('city', $request->city);
            }

        foreach ($province as $item)
            if ($request->has('province') && $request->province == $item->name) {
                $data = $data->where('province', $request->province);
            }
        $data = $data->orderBy('type_news', 'asc')->orderBy('id', 'DESC')->paginate(6);
        return theme_view('realestates.tin_noi_bat', compact('data', 'city', 'pro', 'type'));
    }

    public function ajaxTime(Request $request)
    {
        //        tính khoảng cách giữa 2 ngày
        $id = $request->vip;
        $vip = BuyVip::where('level', $id)->first();
        $day = $vip->day;
        $dt = Carbon::parse($request->end);
        $add_day = $dt->addDays($day - 1)->toDateString();
        $html = '';
        $html .= " <input value='$add_day' name='end_date' id='end_date' readonly type='text' class='form-control'>";
        return $html;
    }

    public function ajaxTime2(Request $request)
    {
        //        tính khoảng cách giữa 2 ngày
        $id = $request->vip;
        $vip = BuyVip::find($id);
        $day = $vip->day;
        $dt = Carbon::now();
        $add_day = $dt->addDays($day - 1)->toDateString();
        $html = '';
        $html .= " <input value='$add_day' name='end_date' id='end' readonly type='text' class='form-control'>";
        return $html;
    }

    public function BuyVip($id)
    {
        $paygates = PaygateFrontController::showpaygate('listPaygatePayFullwidth', 'payment');
        $vip = BuyVip::where('level', '!=', 7)->get();
        $data = Realestates::find($id);
        $now = Carbon::now();
        $today = Carbon::now()->toDateString();
        $end = Carbon::parse($data->end_date);
        $check = $now->gt($end);
        return theme_view('realestates.buy_vip', compact('vip', 'data', 'paygates', 'today', 'check', 'today'));
    }

    public function postBuyVip($id, Request $request)
    {
        if ($request->type_news != "") {
            $news = Realestates::find($id);
            $vip = BuyVip::where('level', $request->type_news)->first();
            $total = $vip->price;

            $check = $news->type_news;
            $this->validate($request, [
                'paygate_code' => 'required'
            ]);
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            if (Auth::user()->id == 1) {
                return redirect()->back()->withErrors(['error' => "Tài khoản Admin này không được mua gói vip"]);
            }
            $user = \App\Modules\User\Models\User::find(Auth::user()->id);
            if (!$user) {
                return redirect()->back()->withErrors(['error' => "Tài khoản thành viên không tồn tại"]);
            }
            $paygate_code = explode('.', $request->input('paygate_code'));
            if ($paygate_code[0] === 'Wallet') {
                $wallet = Wallets::where(['user' => Auth::user()->id, 'currency_code' => 'VND'])->first();
                if (!$wallet) {
                    return redirect()->route('tin.rao')->withErrors(['message' => 'Ví không tồn tại!']);
                } else {
                    if ($wallet->balance_decode < $total) {
                        return redirect()->route('tin.rao')->withErrors(['message' => 'Ví của bạn không đủ tiền! Vui lòng nạp tiền vào ví trước.']);
                    }
                }
            }
            $order_code = 'RW' . uniqid();
            $order_fees = OrderHelper::paygateFees($total, $paygate_code[0], $paygate_code[1], Auth::user()->id, 'p');

            /// Tạo nháp order

            $data = array();
            $data['order_code'] = $order_code;
            $data['currency_id'] = 1;
            $data['payer_id'] = Auth::user()->id;
            $data['payee_id'] = 1;
            $data['order_type'] = 'Buy';
            $data['module'] = 'Realestates';
            $data['net_amount'] = $total;
            $data['fees'] = $order_fees;
            $data['paygate_code'] = $paygate_code[0];
            $data['bank_code'] = $paygate_code[1];
            $data['payment_type'] = 'p';
            $data['status'] = 'none';
            $data['payment'] = 'none';
            $data['admin_note'] = '';
            $data['realestates_id'] = $id;
            $data['description'] = 'Tin vip: ' . $vip->name . ', Giá: ' . $vip->price . ', Số ngày:' . $vip->day . ', Level: ' . $vip->level;
            $data['creator'] = Auth::user()->id;
            $data['code'] = 'R' . uniqid();

            $validate = OrderHelper::validateOrder($total, $paygate_code[0], $paygate_code[1], Auth::user()->id, 'p');
            if ($validate !== 'validated') {
                return redirect()->back()->withErrors(['message' => $validate]);
            }
            $order = Order::createOrder($data);

            if ($order) {
                $order_item = new RealestatesOrderItems;
                $order_item->order_id = $order->id;
                $order_item->order_code = $order_code;
                $order_item->realestates_id = $id;
                $order_item->realestates_title = $news->title;
                $order_item->currency_id = 1;
                $order_item->currency_code = 'VND';
                $order_item->vip_name = $vip->name;
                $order_item->module = 'Realestates';
                $order_item->vip_enddate = $request->end_date;
                $order_item->vip_startdate = $request->start_date;
                $order_item->vip_level = $request->type_news;
                $order_item->price = $vip->price;
                $order_item->user = Auth::user()->id;
                $order_item->user_info = 'nghia212239';
                $order_item->status = 'none';
                $order_item->payment = 'none';
                $order_item->vip_content = $vip;
                $order_item->provider = 'Stock';
                $order_item->method = 'WEB';
                $order_item->save();
            }
            $token = $order->token;
            $orderid = $order->order_code;

            return redirect()->route('frontend.order.checkout', compact('orderid', 'token'));
        } else {
            return redirect()->back()->withErrors(['error' => 'Bạn phải chọn gói vip!']);
        }
    }

    //Dự án
    public function duan(Request $request)
    {

        $group = GroupProject::where('status', 1)->get();
        $project = new Project;
        $city = Cities::all();
        $province = Provinces::all();
        $pro = Provinces::where('city_code', $request->city)->get();
        $project = $project->where('module', 'Realestates');
        if ($request->has('name') && $request->name !== null) {
            if (($request->name)) {
                $project = $project->where('name', 'like', '%' . $request->name . '%');
            } else {
                return redirect()->back()->withErrors(['error' => 'Không tìm dữ liệu cần tìm!']);
            }
        }

        foreach ($city as $item)
            if ($request->has('city') && $request->city == $item->code) {
                $project = $project->where('city', $request->city);
            }

        foreach ($province as $item)
            if ($request->has('province') && $request->province == $item->name) {
                $project = $project->where('province', $request->province);
            }
        $project = $project->orderBy('id', 'DESC')->paginate(6);
        return theme_view('realestates.du_an', compact('group', 'project', 'city', 'pro'));
    }

    public function GroupProject($slug, $id, Request $request)
    {
        $group1 = GroupProject::find($id);
        $group = GroupProject::all();
        $city = Cities::all();
        $province = Provinces::all();
        $project = new Project;

        $arr_cat = ["$group1->code"];
        $arr_cat = (string)json_encode($arr_cat);
        $arr_cat = "'" . $arr_cat . "'";
        $project = $project::whereRaw('JSON_CONTAINS(group2,' . $arr_cat . ')')->where('module', 'Realestates');
        $pro = Provinces::where('city_code', $request->city)->get();

        if ($request->has('name') && $request->name !== null) {
            if (($request->name)) {
                $project = $project->where('name', 'like', '%' . $request->name . '%');
            } else {
                return redirect()->back()->withErrors(['error' => 'Có lỗi sảy ra']);
            }
        }

        foreach ($city as $item)
            if ($request->has('city') && $request->city == $item->code) {
                $project = $project->where('city', $request->city);
            }

        foreach ($province as $item)
            if ($request->has('province') && $request->province == $item->name) {
                $project = $project->where('province', $request->province);
            }

        $project = $project->orderBy('id', 'DESC')->paginate(6);
        return theme_view('realestates.du_an_group', compact('group', 'group1', 'project', 'city', 'pro', 'province'));
    }

    public function DetailProject($slug, $id)
    {
        $data = Project::find($id);
        $group = GroupProject::where('status', 1)->get();
        $img = RealestatesImg::where('project_id', $id)->get();
        return theme_view('realestates.detail_project', compact('data', 'img', 'group'));
    }

    public function ProjectCities(Request $request)
    {
        $city = Cities::where('code', $request->code)->first();
        if ($city) {
            $provinces = Provinces::where('city_code', $request->code)->get();
            $html = '';
            $html .= "<option value=''>-- Chọn quận/huyện --</option>";
            foreach ($provinces as $value) {
                $html .= "<option value='" . $value['name'] . "' >" . $value['name'] . "</option>";
            }
            return $html;
        }
    }

    public function TinBan(Request $request)
    {
        $dt = Carbon::now();
        $today = $dt->toDateString();
        $data = Realestates::where('approved', 1)->where('status', 1)->where('form', 1)->where('module', 'Realestates')->where('end_date', '>=', $today);
        $city = Cities::all();
        $province = Provinces::all();
        $code = 0;
        $search = Search::where('type', 1)->where('status', 1)->get();
        $search2 = Search::where('type', 3)->where('status', 1)->get();
        $type = RealestatesType::where('form_id', 1)->get();
        $pro = Provinces::where('city_code', $request->city)->get();

        if ($request->has('name') && $request->name !== null) {
            if (($request->name)) {
                $data = $data->where('title', 'like', '%' . $request->name . '%');
            } else {
                return redirect()->back()->withErrors(['error' => 'Không có tin rao nào']);
            }
        }
        foreach ($type as $item)
            if ($request->has('type') && $request->type == $item->name) {
                $data = $data->where('type', $request->type);
            }

        foreach ($city as $item)
            if ($request->has('city') && $request->city == $item->code) {
                $data = $data->where('city', $request->city);
            }

        foreach ($province as $item)
            if ($request->has('province') && $request->province == $item->name) {
                $data = $data->where('province', $request->province);
            }

        foreach ($search as $item) {
            if ($request->has('price') && $request->price == $item->code) {
                $data = $data->whereBetween('price', [$item->start, $item->end]);
            }
        }
        foreach ($search2 as $item) {
            if ($request->has('acreage') && $request->acreage == $item->code) {
                $data = $data->whereBetween('acreage', [$item->start, $item->end]);
            }
        }
        $data = $data->orderBy('type_news', 'asc')->orderBy('id', 'DESC')->paginate(6);
        return theme_view('realestates.nha_dat_ban', compact('data', 'city', 'pro', 'type', 'code', 'search', 'search2'));
    }

    public function TinThue(Request $request)
    {
        $city = Cities::all();
        $dt = Carbon::now();
        $today = $dt->toDateString();
        $province = Provinces::all();
        $data = Realestates::where('approved', 1)->where('status', 1)->where('form', 2)->where('module', 'Realestates')->where('end_date', '>=', $today);
        $search3 = Search::where('type', 2)->where('status', 1)->get();
        $search4 = Search::where('type', 4)->where('status', 1)->get();
        $code = 1;
        $type1 = RealestatesType::where('form_id', 2)->get();
        $pro = Provinces::where('city_code', $request->city)->get();

        if ($request->has('name1') && $request->name1 !== null) {
            if (($request->name1)) {
                $data = $data->where('title', 'like', '%' . $request->name1 . '%');
            } else {
                return redirect()->back()->withErrors(['error' => 'Không có tin rao nào']);
            }
        }
        foreach ($type1 as $item) {
            if ($request->has('type1') && $request->type1 == $item->name) {
                $data = $data->where('type', $request->type1);
            }
        }

        foreach ($city as $item) {
            if ($request->has('city1') && $request->city1 == $item->code) {
                $data = $data->where('city', $request->city1);
            }
        }

        foreach ($province as $item) {
            if ($request->has('province1') && $request->province1 == $item->name) {
                $data = $data->where('province', $request->province1);
            }
        }

        foreach ($search3 as $item) {
            if ($request->has('price1') && $request->price1 == $item->code) {
                $data = $data->whereBetween('price', [$item->start, $item->end]);
            }
        }

        foreach ($search4 as $item) {
            if ($request->has('acreage1') && $request->acreage1 == $item->code) {
                $data = $data->whereBetween('acreage', [$item->start, $item->end]);
            }
        }
        $data = $data->orderBy('type_news', 'asc')->orderBy('id', 'DESC')->paginate(6);
        return theme_view('realestates.nha_dat_thue', compact('data', 'city', 'pro', 'type1', 'code', 'search3', 'search4'));
    }

    public function orderDetail($order_code)
    {
        $orders = RealestatesOrderItems::where('order_code', $order_code)->get();
        return theme_view('realestates.order', compact('orders'));
    }

    public function listOrder(Request $request)
    {
        $orders = RealestatesOrderItems::where('status', 'completed')->orderBy('id', 'DESC')->paginate(20);
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $title = "Search: " . $orders;
            $orders = RealestatesOrderItems::where('realestates_title', 'LIKE', '%' . $keyword . '%')->where('status', 'completed')->orderBy('id', 'DESC')->paginate(20);
        }
        return theme_view('realestates.list_order', compact('orders', 'title'));
    }

    public function deleteOrder($id)
    {
        RealestatesOrderItems::destroy($id);
        return back();
    }

    public function createBroker()
    {
        $user_id = Auth::user()->id;
        Cookie::queue('user_broker', $user_id, 120);
        $cities = Cities::all();
        $types=RealestatesType::orderBy('form_id','desc')->get();
        return theme_view('realestates.broker_create', compact('types', 'cities'));
    }

    public function postCreateBroker(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|min:10',
            'email' => 'email|required',
            'fields' => 'required',
            'city' => 'required',
            'province' => 'required',
            'image' => 'required',
            'type' => 'required',
        ]);
        $user_id = Cookie::get('user_broker');
        $broker = new Broker();
        $user = User::find($user_id);
        if ($user) {
            $check = Broker::where('user_id', $user_id)->first();
            if (!$check) {
                $broker->name = $request->name;
                $broker->slug = str_slug($request->name);
                $broker->address = $request->address;
                $broker->type = $request->type;
                $broker->city = $request->city;
                $broker->province = $request->province;
                $broker->phone = $request->phone;
                $broker->email = $request->email;
                $broker->website = $request->website;
                $broker->fields = $request->fields;
                $broker->introduce = $request->introduce;
                $broker->introduce_show= $request->introduce_show;
                $broker->status = $request->status;
                $broker->module = 'Realestates';
                $broker->user_id = $user_id;
                if ($request->hasFile('image')) {
                    $avatar = $request->image->getClientOriginalName();
                    $broker->image = $avatar;
                    $request->image->storeAs('public/avatar', $avatar);
                }
                $broker->save();
                $update = Auth::user()->where('id', $user_id)->update(['broker' => $request->type]);
                return redirect()->route('tin.rao')->with('success', 'Tạo hồ sơ công ty mô giới thành công');
            } else {
                return redirect()->route('tin.rao')->withErrors( 'Tài khoản này đã tạo mô giới!');
            }
        }
        else{
            return redirect()->route('login')->withErrors('Vui lòng đăng nhập');
        }
    }

    public function editBroker($id){
        $broker= Broker::find($id);
        $cities=Cities::all();
        $province= Provinces::where('city_code',$broker->city)->get();
        $types=RealestatesType::orderBy('form_id','desc')->get();
        return theme_view('realestates.broker_edit',compact('broker','types','cities','province'));
    }
    public function postEditBroker(Request $request,$id){
        $this->validate($request, [
            'name'     => 'required',
            'address'  => 'required',
            'phone'    => 'required|min:10',
            'email'    => 'email|required',
            'fields'   => 'required',
            'city'     => 'required',
            'province' => 'required',
            'type'    => 'required',
        ]);

        $user_id= Auth::user()->id;
        $broker= Broker::find($id);
        $broker->name=$request->name;
        $broker->slug= str_slug($request->name);
        $broker->address= $request->address;
        $broker->type= $request->type;
        $broker->city= $request->city;
        $broker->province= $request->province;
        $broker->phone= $request->phone;
        $broker->email= $request->email;
        $broker->website= $request->website;
        $broker->fields= $request->fields;
        $broker->introduce= $request->introduce;
        $broker->introduce_show= $request->introduce_show;
        $broker->module= 'Realestates';
        $broker->status= $request->status;
        if($request->hasFile('image')){
            $avatar=$request->image->getClientOriginalName();
            $broker->image=$avatar;
            $request->image->storeAs('public/avatar',$avatar);
        }
        $broker->save();
        $update=Auth::user()->where('id',$user_id)->update(['broker'=>$request->type]);
        return redirect()->route('tin.rao')->with('success','Cập nhật thành công');
    }
    public function deleteBroker($id){
        Broker::destroy($id);
        $user_id= Auth::user()->id;
        $update=Auth::user()->where('id',$user_id)->update(['broker'=>0]);
        return redirect()->route('tin.rao')->with('success','Xóa mô giới thành công');
    }
    public function broker(Request $request){
        $citys = Cities::all();
        $types=RealestatesType::select('id','name')->get();
        $types2=RealestatesType::where('form_id',$request->form)->select('id','name')->get();
        $pros = Provinces::where('city_code', $request->city)->get();
        $provinces = Provinces::all();
        $brokers  = new Broker;
        $brokers2 = new Broker;

        $brokers = $brokers->where('status',1)->where('module','Realestates')->where('type',1);
        $brokers2 = $brokers2->where('status',1)->where('module','Realestates')->where('type',2);
        if ($request->has('keyword') && $request->keyword !== null) {
            if (($request->keyword)) {
                $brokers  = $brokers->where('name','LIKE','%'.$request->keyword.'%')->orderBy('id', 'DESC')->paginate(10);
                $brokers2 = $brokers2->where('name','LIKE','%'.$request->keyword.'%')->orderBy('id', 'DESC')->paginate(10);
                return theme_view('realestates.broker',compact('brokers','brokers2','types','citys','pros','types2'));
            } else {
                return redirect()->back()->withErrors(['error' => 'Không có tin rao nào']);
            }
        }

//        if($request->has('type') && $request->type!==null){
//            $brokers=new Broker;
//            $brokers2=new Broker;
//            $arr_cat = ["$request->type"];
//            $arr_cat = (string)json_encode($arr_cat);
//            $arr_cat = "'" . $arr_cat . "'";
//            $brokers = $brokers::whereRaw('JSON_CONTAINS(type,' . $arr_cat . ')');
//            $brokers2 = $brokers2::whereRaw('JSON_CONTAINS(type,' . $arr_cat . ')');
//        }

        foreach ($citys as $city){
            if($request->has('city') && $request->city !== null && $request->city== $city->code){
                $brokers  = $brokers->where('city',$request->city);
                $brokers2 = $brokers2->where('city',$request->city);
            }
        }
        foreach ($provinces as $province){
            if($request->has('province') && $request->province !== null && $request->province== $province->name){
                $brokers  = $brokers->where('province',$request->province);
                $brokers2 = $brokers2->where('province',$request->province);
            }
        }
        $brokers = $brokers->orderBy('id', 'DESC')->paginate(10);
        $brokers2 = $brokers2->orderBy('id', 'DESC')->paginate(10);
        return theme_view('realestates.broker',compact('brokers','brokers2','types','citys','pros','types2'));
    }

    public function getAjaxForm3(Request $request)
    {
        $type = RealestatesType::where('form_id', $request->code)->get();
        $html = '';
        $html .= "<option >-- Chọn loại nhà đất --</option>";
        foreach ($type as $value) {
            $html .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
        }
        return $html;
    }
    public function detailBroker( Request $request, $slug, $id){
        $citys = Cities::all();
        $types=RealestatesType::select('id','name')->get();
        $types2=RealestatesType::where('form_id',$request->form)->select('id','name')->get();
        $pros = Provinces::where('city_code', $request->city)->get();
        $provinces = Provinces::all();
        $broker = Broker::where('status',1)->where('id',$id)->first();
        $today=Carbon::now();
        $data=Realestates::where('user_id',$broker->user_id)->where('status',1)->where('approved',1)->orderBy('id','DESC')->where('end_date', '>=', $today)->paginate(10);
        if($request->has('keyword') || $request->has('city') || $request->has('province') ){
            $brokers  = new Broker;
            $brokers2 = new Broker;
            $brokers = $brokers->where('status',1)->where('module','Realestates')->where('type',1);
            $brokers2 = $brokers2->where('status',1)->where('module','Realestates')->where('type',2);

            if ($request->has('keyword') && $request->keyword !== null) {
                if (($request->keyword)) {
                    $brokers  = $brokers->where('name','LIKE','%'.$request->keyword.'%')->orderBy('id', 'DESC')->paginate(10);
                    $brokers2 = $brokers2->where('name','LIKE','%'.$request->keyword.'%')->orderBy('id', 'DESC')->paginate(10);
                    return theme_view('realestates.broker',compact('brokers','brokers2','types','citys','pros','types2'));
                } else {
                    return redirect()->back()->withErrors(['error' => 'Không có tin rao nào']);
                }
            }
            foreach ($citys as $city){
                if($request->has('city') && $request->city !== null && $request->city== $city->code){
                    $brokers  = $brokers->where('city',$request->city);
                    $brokers2 = $brokers2->where('city',$request->city);
                }
            }
            foreach ($provinces as $province){
                if($request->has('province') && $request->province !== null && $request->province== $province->name){
                    $brokers  = $brokers->where('province',$request->province);
                    $brokers2 = $brokers2->where('province',$request->province);
                }
            }
            $brokers = $brokers->orderBy('id', 'DESC')->paginate(10);
            $brokers2 = $brokers2->orderBy('id', 'DESC')->paginate(10);
            return theme_view('realestates.broker',compact('brokers','brokers2','types','citys','pros','types2'));
        }
        return theme_view('realestates.broker_detail',compact('brokers','brokers2','types','citys','pros','types2','broker','data'));
    }
    public function testPrefectMoney($order_code){
        
    }
}
