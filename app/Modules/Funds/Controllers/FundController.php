<?php

namespace App\Modules\Funds\Controllers;

use App\Modules\Currency\Models\Currencies;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Auth;
use DB;
use App\User;
use App\Modules\Funds\Models\Funds;
use App\Modules\Funds\Models\Fund_trans;
use App\Modules\Funds\Models\Fund_type;
use App\Modules\Localbank\Models\Localbank;
use Response;
use Carbon\Carbon;
class FundController extends BackendController
{
    //Funds-Tài khoản quỹ
    public function index(Request $request){
        $funds=Funds::orderBy('id','ASC')->paginate(20);
        $localbanks= Localbank::where('status',1)->get();
        if($request->has('keyword') && $request->keyword != null){
            $title='Tìm kiếm: '.$request->keyword;
            $funds=Funds::where('name','LIKE','%'.$request->keyword.'%')->paginate(20);
            return view('Funds::index',compact('funds','localbanks','title'));
        }
        return view('Funds::index',compact('funds','localbanks'));
    }
    public function create(){
        $localbanks= Localbank::where('status',1)->get();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return view('Funds::create',compact('currencies','localbanks'));
    }
    public function store(Request $request){

        if($request->type=='bank'){
            $this->validate($request, [
                'name' => 'required',
                'type' => 'required',
                'acc_number' => 'required',
                'acc_name' => 'required',
                'acc_branch' => 'required',
                'bank_code' => 'required',
            ]);
        }
        else{
            $this->validate($request, [
                'name' => 'required',
                'type' => 'required',
            ]);
        }
        $currencies = Currencies::where('code', $request->currency_code)->where('status',1)->first();
        $code = strtoupper('FU'.uniqid());
        $fund= new Funds();
        $fund->name= $request->name;
        $fund->code= $code;
        $fund->type= $request->type;
        $fund->tax_acc= $request->tax_acc;
        $fund->acc_name= $request->acc_name;
        $fund->acc_number= $request->acc_number;
        $fund->bank_code= $request->bank_code;
        $fund->acc_branch= $request->acc_branch;
        if($request->balance!=''){
            $fund->balance= $request->balance;
        }
        else{
            $fund->balance=0;
        }
        $fund->currency_code= $request->currency_code;
        $fund->currency_id= $currencies->id;
        $fund->status=$request->status;
        $fund->save();

        return redirect()->route('fund.index')->with('success','Thêm thành công');
    }
    public function edit($id){
        $fund=Funds::find($id);
        $localbanks= Localbank::where('status',1)->get();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return view('Funds::edit',compact('fund','localbanks','currencies'));
    }
    public function update($id, Request $request){
        if($request->type=='bank'){
            $this->validate($request, [
                'name' => 'required',
                'type' => 'required',
                'acc_number' => 'required',
                'acc_name' => 'required',
                'acc_branch' => 'required',
                'bank_code' => 'required',
            ]);
        }
        else{
            $this->validate($request, [
                'name' => 'required',
                'type' => 'required',
            ]);
        }
        $fund=Funds::find($id);
        $currencies = Currencies::where('code', $request->currency_code)->where('status',1)->first();
        $fund->name= $request->name;
        $fund->tax_acc= $request->tax_acc;
        $fund->type= $request->type;
        $fund->acc_name= $request->acc_name;
        $fund->acc_number= $request->acc_number;
        $fund->bank_code= $request->bank_code;
        $fund->acc_branch= $request->acc_branch;
        if($request->balance!=''){
            $fund->balance= $request->balance;
        }
        else{
            $fund->balance=0;
        }
        $fund->currency_code= $request->currency_code;
        $fund->currency_id= $currencies->id;
        $fund->status=$request->status;
        $fund->save();
        return redirect()->route('fund.index')->with('success','Cập nhật thành công');
    }
    public function destroy($id){
        Funds::destroy($id);
        return redirect()->route('fund.index')->with('success','Xóa thành công');
    }
    //-----------------------------------------------------
    //Fund-Trans-Tạo phiếu
    public function getFundTrans(){
        $user_id=Auth::user()->id;
        $check= allow('approve');
        $order_code = strtoupper('HDFU'.uniqid());
        $types=Fund_type::orderBy('id','DESC')->where('type','Phiếu thu')->get();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return view('Funds::fund_trans_create',compact('currencies','user_id','order_code','types','check'));
    }
    public function postFundTrans(Request $request){
        $this->validate($request, [
            'amount' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'name' => 'required',
            'description' => 'required',
            'info2' => 'required',
        ]);
        $fund2=Funds::where('id',$request->info2)->first();
        if($request->has('fees')&& $request->has('tax')){
            $total=$request->amount + $request->fees +(($request->amount/100)*$request->tax);
        }
        elseif($request->has('fees')){
            $total=$request->amount + $request->fees;
        }
        elseif($request->has('tax')){
            $total=$request->amount + (($request->amount/100)*$request->tax);
        }
        else{
            $total=$request->amount;
        }
        $balance2=$fund2->balance;
        if($request->type ==='Phiếu chi' && $balance2 < $total){
            return back()->withErrors('Tài khoản chi không đủ. vui lòng kiểm tra lại');
        }
        $user_id=Auth::user()->id;
        $info1=User::where('id',$request->info1)->select('id','username','name','phone','email','country_code','gender')->first();
        $order= new Fund_trans();
        if($request->type==='Phiếu thu' && $request->has('type')){
            $order->sender_fund_id= $request->info1;
            $order->receiver_fund_id= $request->info2;
            $order->sender_info= $info1;
            $order->sender_user_id = $request->info1;
        }
        elseif($request->type==='Phiếu chi' && $request->has('type')){
            $order->receiver_fund_id= $request->info1;
            $order->sender_fund_id= $request->info2;
            $order->receiver_info= $info1;
            $order->receiver_user_id= $request->info1;
        }
        $order->order_code=$request->order_coder;
        $order->type= $request->type;
        $order->reason= $request->reason;
        $order->amount= $request->amount;
        $order->fees= $request->fees;
        $order->tax= $request->tax;
        $order->email= $request->email;
        $order->address= $request->address;
        $order->phone= $request->phone;
        $order->name= $request->name;
        $order->tax_acc= $request->tax_acc;
        $order->total=$total;
        $order->description= $request->description;
        $order->admin_note= $request->admin_note;
        $order->currency_code= $fund2->currency_code;
        $order->currency_id= $fund2->currency_id;
        $order->creator= $user_id;
        $order->day   = Carbon::now()->day;
        $order->month = Carbon::now()->month;
        $order->year  = Carbon::now()->year;
        $order->save();
        $order->before_balance= $fund2->balance;
        try{
            if($request->type=='Phiếu thu'){
                DB::beginTransaction();
                $fund2->balance=$balance2+$total;
                $fund2->save();
                $order->approved=1;
                $order->status='complete';
                $order->approveby=$user_id;
                $order->admin_note=$request->admin_note;
                $order->after_balance=$fund2->balance;
                $order->save();
                DB::commit();
                return redirect()->route('fund-trans.order')->with('success', 'Tạo ' . $request->type . ' thành công');
            }
            elseif($request->type=='Phiếu chi' && allow('approve')===true){
                    $fund2->balance=$balance2-$total;
                    $fund2->save();
                    $order->approved=1;
                    $order->status='complete';
                    $order->approveby=$user_id;
                    $order->admin_note=$request->admin_note;
                    $order->after_balance=$fund2->balance;
                    $order->save();
                    DB::commit();
                    return redirect()->route('fund-trans.order')->with('success', 'Xử lý ' . $request->type . ' thành công');
            }
        }
            catch (\Exception $e){
            DB::rollback();
            return redirect()->route('fund-trans.order')->withErrors(['error' => 'Xử lý không thành công']);
        }
        return redirect()->route('fund-trans.order')->with('success', 'Tạo ' . $request->type . ' thành công');
    }
    public function listOrder(Request $request){
        $check= allow('approve');
        $user_id=Auth::user()->id;
        $funds=Funds::all();
        $reasons=Fund_type::where('type',$request->type)->where('status',1)->get();
        $reason=Fund_type::all();
        $fund_tras=new Fund_trans();

        $fund_tras=$fund_tras->orderBy('id','DESC');
        if($request->has('keyword') && $request->keyword != null){
            $title='Tìm kiếm: '.$request->keyword;
            $fund_tras=Fund_trans::where('name','LIKE','%'.$request->keyword.'%')->paginate(20);
            return view('Funds::list_order',compact('fund_tras','funds','user_id','check','reasons','title'));
        }

        if($request->has('type') && $request->type !=null){
            $fund_tras = $fund_tras->where('type',$request->type);
        }
        if($request->has('funds') && $request->funds !=null){
            $fund_tras = $fund_tras->orwhere('receiver_fund_id',$request->funds)->orwhere('sender_fund_id',$request->funds);
        }
        if($request->has('reason') && $request->type !=null){
            foreach ($reason as $item){
                if($item->name==$request->reason){
                    $fund_tras=$fund_tras->where('reason',$request->reason);
                }
            }
        }
        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {
            if(Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {
                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }
            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();
            $fund_tras = $fund_tras->whereBetween('created_at', [$fromdate, $todate]);
        }
        $fund_tras=$fund_tras->paginate(20);
        return view('Funds::list_order',compact('fund_tras','funds','user_id','check','reasons','title'));
    }
    public function editOrder($id){
        $check= allow('approve');
        $tran=Fund_trans::find($id);
        $convert_total= ucfirst($this->convert_number_to_words($tran->total));
        $funds=Funds::all();
        $user_id=Auth::user()->id;
        return view('Funds::fund_trans_edit',compact('tran','funds','user_id','check','convert_total'));
    }
    public function updateOrder($id, Request $request){
        $order=Fund_trans::find($id);
        $user_id=Auth::user()->id;
        if(allow('edit')===true){
            $order->day= $request->day;
            $order->month= $request->month;
            $order->year= $request->year;
            $order->save();
        }
        if($order->approved==2 && allow('approve')===true) {
            DB::beginTransaction();
            try{
                if($order->type=='Phiếu thu'){
                    $order->time=$order->id.'.'.date('dmYHi', time());
                    $fund=Funds::find($order->receiver_fund_id);
                    $order->before_balance= $fund->balance;
                    $balance=$fund->balance;
                    $fund->balance=$balance+$order->total;
                }
                elseif($order->type=='Phiếu chi'){
                    $order->time=$order->id.'.'.date('dmYHi', time());
                    $fund=Funds::find($order->sender_fund_id);
                    $order->before_balance= $fund->balance;
                    $balance=$fund->balance;
                    $fund->balance=$balance-$order->total;
                }
                $fund->save();
                $order->approved=1;
                $order->status='complete';
                $order->approveby=$user_id;
                $order->admin_note=$request->admin_note;
                $order->after_balance=$fund->balance;
                $order->save();
                DB::commit();
                return back()->with('success', 'Xử lý ' . $request->type . ' thành công');
            }catch (\Exception $e){
                DB::rollback();
                return back()->withErrors(['error' => 'Xử lý không thành công']);
            }
        }
        else{
            $order->admin_note = $request->admin_note;
            $order->save();
                return back()->with('success','Xử lý thành công');
        }
    }
    public function deleteOrder($id){
        Fund_trans::destroy($id);
        return redirect()->route('fund-trans.order')->with('success','Xóa thành công');
    }
    public function Inprint($id){
        $tran=Fund_trans::find($id);
        $convert_total= ucfirst($this->convert_number_to_words($tran->total));
        $funds=Funds::all();
        return view('Funds::print',compact('convert_total','funds','tran'));
    }
    //----------------------------------------------------------
    //Reason-Lý Do
    public function reasonIndex(){
        $reasons= Fund_type::orderBy('type','ASC')->paginate(20);
        return view('Funds::reason_index',compact('reasons'));
    }
    public function reasonCreate(){
        return view('Funds::reason_create');
    }
    public function reasonSorte(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);
        $input=$request->all();
        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;
        Fund_type::create($input);
        return redirect()->route('reason.index')->with('success','Thêm thành công');

    }
    public function reasonEdit($id){
        $reason =Fund_type::find($id);
        return view('Funds::reason_edit',compact('reason'));
    }
    public function reasonUpdate($id,Request $request){
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);
        $reason=Fund_type::find($id);
        $reason->name=$request->name;
        $reason->type=$request->type;
        if(isset($request->status)) {$reason->status = 1;}else{$reason->status = 0;}
        $reason->save();
        return redirect()->route('reason.index')->with('success','Cập nhật thành công');
    }
    public function reasonDelete($id){
        Fund_type::destroy($id);
        return redirect()->route('reason.index')->with('success','Xóa thành công');
    }

    //----------------------------------------------------------
    //AJAX
    public function ajaxBankName(Request $request){
        $localbanks= Localbank::where('status',1)->get();
        if ($localbanks) {
            $localbanks = Localbank::where('paygate_code', $request->code_name)->get();
            $html = '';
            foreach ($localbanks as $value) {
                $html .= " <input value='$value->acc_name' name='acc_name'  readonly type='text' class='form-control'>";
            }
            return $html;
        }
    }
    public function ajaxBankNum(Request $request){
        $localbanks= Localbank::where('status',1)->get();
        if ($localbanks) {
            $localbanks = Localbank::where('paygate_code', $request->code_num)->get();
            $html = '';
            foreach ($localbanks as $value) {
                $html .= " <input value='$value->acc_num' name='acc_number'  readonly type='text' class='form-control'>";
            }
            return $html;
        }
    }
    public function ajaxSender(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->get('searchTerm') . '%')->limit(5)->get();
        $currency = session()->get('currency');
        $data = [];
        foreach ($users as $key => $user) {
            $ivalue = [
                'text' => $user->name.'-'.$user->phone,
                'id' => $user->id
            ];
            $data[] = $ivalue;
        }
        return Response::json($data);
    }
    public function ajaxReceiver(Request $request)
    {
        $funds = Funds::where('name', 'like', '%' . $request->get('searchTerm') . '%')->limit(5)->get();
        $currency = session()->get('currency');
        $data = [];
        foreach ($funds as $key => $fund) {
            $ivalue = [
                'text' => $fund->name.'| STK:'.$fund->acc_number.' | Số dư: '.number_format($fund->balance).' '.$fund->currency_code,
                'id' => $fund->id
            ];
            $data[] = $ivalue;
        }
        return Response::json($data);
    }
    public function ajaxInfoUser(Request $request){
        $users= User::all();
        if ($users) {
            $users = User::where('id', $request->code)->get();
            $html = '';
            foreach ($users as $value) {
                //$html .="<label>Địa chỉ:</label><input type='text' class='form-control' name='name'>";
                $html .="<div class='form-group'><label>Tên(<span class=\"red\">*</span>):</label><input type='text' value='{$value->name}' class='form-control' name='name'></div>";
                $html .="<div class='form-group'><label>Số điện thoại(<span class=\"red\">*</span>):</label><input type='text' value='{$value->phone}' class='form-control' name='phone'></div>";
                $html .="<div class='form-group'><label>Địa chỉ(<span class=\"red\">*</span>):</label><input type='text' value='{$value->address}' class='form-control' name='address'></div>";
            }
            return $html;
        }
    }
    public function ajaxFundReason(Request $request)
    {
        $types = Fund_type::orderBy('id','DESC')->where('type', $request->code)->get();
        $html = '';
        $html .= "<option value=''>-- Nhấp chọn --</option>";
        foreach ($types as $value) {
            $html .= "<option value='" . $value['name'] . "'>" . $value['name'] . "</option>";
        }
        return $html;
    }
    public function ajaxFundCurrency(Request $request)
    {
        $data=Funds::find($request->code);

        $html = '';
        $html .= "<label>$data->currency_code</label>";

        return $html;
    }
    public function ajaxFundType(Request $request)
    {
        $types=Fund_type::where('type',$request->code)->get();
        $html = '';
        $html .= "<option >--Lọc theo lý do--</option>";
        foreach ($types as $value) {
            $html .= "<option value='" . $value['name'] . "'>" . $value['name'] . "</option>";
        }
        return $html;
    }
    public function ajaxFundNumber(Request $request)
    {
        $number=number_format($request->code,0);
        $html = '';
        $html .= "<span >$number</span>";

        return $html;
    }
    public function convert_number_to_words($number)
    {

        $hyphen = ' ';
        $conjunction = ' ';
        $separator = ' ';
        $negative = 'âm ';
        $decimal = ' phẩy ';
        $dictionary = array(
            0 => 'không',
            1 => 'một',
            2 => 'hai',
            3 => 'ba',
            4 => 'bốn',
            5 => 'năm',
            6 => '6áu',
            7 => 'bảy',
            8 => 'tám',
            9 => 'chín',
            10 => 'mười',
            11 => 'mười một',
            12 => 'mười hai',
            13 => 'mười ba',
            14 => 'mười bốn',
            15 => 'mười năm',
            16 => 'mười sáu',
            17 => 'mười bảy',
            18 => 'mười tám',
            19 => 'mười chín',
            20 => 'hai mươi',
            30 => 'ba mươi',
            40 => 'bốn mươi',
            50 => 'năm mươi',
            60 => 'sáu mươi',
            70 => 'bảy mươi',
            80 => 'tám mươi',
            90 => 'chín mươi',
            100 => 'trăm',
            1000 => 'nghìn',
            1000000 => 'triệu',
            1000000000 => 'tỷ',
            1000000000000 => 'nghìn tỷ',
            1000000000000000 => 'triệu tỷ',
            1000000000000000000 => 'tỷ tỷ'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
// overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }


}
