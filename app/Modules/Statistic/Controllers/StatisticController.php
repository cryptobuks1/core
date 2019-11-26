<?php

namespace App\Modules\Statistic\Controllers;

use App\Modules\Charging\Models\Charging;
use App\Modules\Charging\Models\ChargingProvider;
use App\Modules\Charging\Models\ChargingsTelco;
use App\Modules\Currency\Models\Currencies;
use App\Modules\Group\Models\Group;
use App\Modules\Mtopup\Models\Mtopup;
use App\Modules\Mtopup\Models\MtopupProvider;
use App\Modules\Mtopup\Models\MtopupTelco;
use App\Modules\Order\Models\Order;
use App\Modules\Paygate\Models\Paygate;
use App\Modules\Softcard\Models\Softcard;
use App\Modules\Softcard\Models\SoftcardItem;
use App\Modules\Softcard\Models\SoftcardOrder;
use App\Modules\Stockcard\Models\Stockcard;
use App\Modules\Stockcard\Models\Stockcardsetting;
use App\Modules\Wallet\Controllers\WalletController;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Auth;
use DB;


class StatisticController extends BackendController
{

    public function chargingstat(Request $request)
    {
        $title = "Thống kê đổi thẻ";
        $chargings = new Charging;
        $telcos = ChargingsTelco::select('key')->get();
        $providers = ChargingProvider::select('provider')->get();
        $telco = $request->telco;
        $value = $request->value;
        $status = $request->status;
        $action = (!$request->submit) ? 'filter' : $request->submit;
        if ($request->has('telco') && $request->telco !== 'all') {
            $chargings = $chargings->where('telco', $telco);
        }
        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {
            if (Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {
                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }
            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();
            $chargings = $chargings->whereBetween('created_at', [$fromdate, $todate]);
        }
        if ($request->has('value') && $request->value !== null) {
            $chargings = $chargings->where('real_value', $value);
        }
        if ($request->has('status') && $request->status == 'correct') {
            $chargings = $chargings->where('status', 1);
        }
        if ($request->has('status') && $request->status == 'wrong') {
            $chargings = $chargings->where('status', 2);
        }
        if ($request->has('status') && $request->status == 'invalid') {
            $chargings = $chargings->where('status', 3);
        }
        if ($request->has('status') && $request->status == 'waiting') {
            $chargings = $chargings->where('status', 99);
        }
        if ($request->has('provider') && $request->provider !== null) {
            $chargings = $chargings->where('provider', $request->provider);
        }
        if ($request->has('user_id') && $request->user_id !== null) {
            if (is_numeric($request->user_id)) {
                $chargings = $chargings->where('user', $request->user_id);
            } else {
                return redirect()->back()->withErrors(['error' => 'Mã khách hàng phải là số nguyên dương']);
            }
        }
        if($action == 'filter'){
            $total = $chargings;
            $chargings = $chargings->orderBy('created_at', 'DESC')->paginate(25)->appends([
                'telco' => $telco,
                'status' => $status,
                'value' => $value,
                'provider' => $request->provider,
                'user_id' => $request->user_id,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate
            ]);
            return view('Statistic::charging_stat', compact('title', 'chargings', 'telcos', 'total', 'providers'));
        }elseif($action == 'excel'){
            $data = $chargings->orderBy('id', 'DESC')->get()->toArray();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('DOITHECAO');
            $sheet->setCellValue('A1', 'Seri');
            $sheet->setCellValue('B1', 'Mã nạp');
            $sheet->setCellValue('C1', 'Mạng');
            $sheet->setCellValue('D1', 'Mã KH');
            $sheet->setCellValue('E1', 'MG gửi');
            $sheet->setCellValue('F1', 'MG thực');
            $sheet->setCellValue('G1', 'Phí');
            $sheet->setCellValue('H1', 'Phạt');
            $sheet->setCellValue('I1', 'Số tiền');
            $sheet->setCellValue('J1', 'Trạng thái');
            $sheet->setCellValue('K1', 'Thời gian');
            $sheet->setCellValue('L1', 'Request ID');
            $numRow = 2;
            foreach ($data as $row) {
                switch ($row['status']){
                    case 1:
                        $status = 'Thẻ đúng';
                        break;
                    case 2:
                        $status = 'Sai mệnh giá';
                        break;
                    case 3:
                        $status = 'Thẻ lỗi';
                        break;
                    default:
                        $status = 'Chờ xử lý';
                        break;
                }
                $sheet->setCellValue('A' . $numRow, strval(' '.$row['serial']));
                $sheet->setCellValue('B' . $numRow, strval(' '.$row['code']));
                $sheet->setCellValue('C' . $numRow, $row['telco']);
                $sheet->setCellValue('D' . $numRow, $row['user']);
                $sheet->setCellValue('E' . $numRow, $row['declared_value']);
                $sheet->setCellValue('F' . $numRow, $row['real_value']);
                $sheet->setCellValue('G' . $numRow, $row['fees']);
                $sheet->setCellValue('H' . $numRow, $row['penalty']);
                $sheet->setCellValue('I' . $numRow, $row['amount']);
                $sheet->setCellValue('J' . $numRow, $status);
                $sheet->setCellValue('K' . $numRow, $row['created_at']);
                $sheet->setCellValue('L' . $numRow, $row['request_id']);
                $numRow++;
            }
            $writer = new Xlsx($spreadsheet);
            $filename = 'doithecao_' . time();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            $writer->save("php://output");
        }else{
            return redirect()->route('statistic.softcard')->withErrors(['error' => 'Yêu cầu không hợp lệ!']);
        }
    }


    public function softcardstat(Request $request)
    {

        $title = "Thống kê bán thẻ cào";
        $softcards = new SoftcardOrder;

        $servicecodes = Softcard::select('service_code')->get();
        $providers = Stockcardsetting::select('provider')->get();

        $service_code = $request->service_code;
        $value = $request->value;
        $status = $request->status;
        $action = (!$request->submit) ? 'filter' : $request->submit;


        if ($request->has('service_code') && $request->service_code !== null) {
            $softcards = $softcards->where('service_code', $service_code);
        }


        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {

            if (Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {

                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }

            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();

            $softcards = $softcards->whereBetween('created_at', [$fromdate, $todate]);
        }

        if ($request->has('value') && $request->value !== null) {
            $softcards = $softcards->where('value', $value);
        }

        if ($request->has('status') && $request->status == 'completed') {
            $softcards = $softcards->where('status', 'completed');
        }

        if ($request->has('status') && $request->status == 'canceled') {
            $softcards = $softcards->where('status', 'canceled');
        }

        if ($request->has('status') && $request->status == 'pending') {
            $softcards = $softcards->where('status', 'pending');
        }

        if ($request->has('provider') && $request->provider !== null) {
            $softcards = $softcards->where('provider', $request->provider);
        }

        if ($request->has('user_id') && $request->user_id !== null) {
            if (is_numeric($request->user_id)) {
                $softcards = $softcards->where('user', $request->user_id);
            } else {
                return redirect()->back()->withErrors(['error' => 'Mã khách hàng phải là số nguyên dương']);
            }
        }


        if($action == 'filter'){

            $total = $softcards;

            $softcards = $softcards->orderBy('id', 'DESC')->paginate(25)->appends([
                'service_code' => $service_code,
                'status' => $status,
                'value' => $value,
                'provider' => $request->provider,
                'user_id' => $request->user_id,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate
            ]);


            return view('Statistic::softcard_stat', compact('title', 'softcards', 'servicecodes', 'total', 'providers'));

        }elseif($action == 'excel'){

            $data = $softcards->orderBy('id', 'DESC')->get()->toArray();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('BANTHECAO');

            $sheet->setCellValue('A1', 'Mã đơn');
            $sheet->setCellValue('B1', 'Sản phẩm');
            $sheet->setCellValue('C1', 'Mã dịch vụ');
            $sheet->setCellValue('D1', 'NCC');
            $sheet->setCellValue('E1', 'Mệnh giá');
            $sheet->setCellValue('F1', 'Số lượng');
            $sheet->setCellValue('G1', 'Tổng mệnh giá');
            $sheet->setCellValue('H1', 'Số tiền');
            $sheet->setCellValue('I1', 'Trạng thái');
            $sheet->setCellValue('J1', 'Ngày');
            $sheet->setCellValue('K1', 'Mã KH');

            $numRow = 2;
            foreach ($data as $row) {
                $sheet->setCellValue('A' . $numRow, $row['order_code']);
                $sheet->setCellValue('B' . $numRow, $row['product']);
                $sheet->setCellValue('C' . $numRow, $row['service_code']);
                $sheet->setCellValue('D' . $numRow, $row['provider']);
                $sheet->setCellValue('E' . $numRow, $row['value']);
                $sheet->setCellValue('F' . $numRow, $row['qty']);
                $sheet->setCellValue('G' . $numRow, $row['value']*$row['qty']);
                $sheet->setCellValue('H' . $numRow, $row['subtotal']);
                $sheet->setCellValue('I' . $numRow, $row['status']);
                $sheet->setCellValue('J' . $numRow, Carbon::parse($row['created_at'])->format('d-m-Y'));
                $sheet->setCellValue('K' . $numRow, $row['user']);
                $numRow++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'banthe_' . time();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');

            $writer->save("php://output");

        }else{
            return redirect()->route('statistic.softcard')->withErrors(['error' => 'Yêu cầu không hợp lệ!']);
        }

    }


    public function stockcardstat(Request $request)
    {

        $title = "Thống kê số tồn kho thẻ";

        $servicecodes = Softcard::select('service_code')->get();

        $stocks = SoftcardItem::paginate(25);
        if (isset($request->service_code)) {

            $stocks = SoftcardItem::where('service_code', $request->service_code)->paginate(25);
        }

        foreach ($stocks as $item) {
            $totalc = Stockcard::where('status', 0)->where('item_sku', $item->sku)->count();
            $item->available = $totalc;
        }

        return view('Statistic::stock_stat', compact('title', 'stocks', 'servicecodes'));

    }


    public function withdrawstat(Request $request)
    {

        $title = "Thống kê rút tiền từ ví";
        $withdraws = new Order;
        $status = $request->status;

        $withdraws = $withdraws->where('order_type', 'Withdraw')->where('module', 'Wallet');


        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {

            if (Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {

                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }

            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();

            $withdraws = $withdraws->whereBetween('created_at', [$fromdate, $todate]);
        }

        if ($request->has('status') && $request->status == 'completed') {
            $withdraws = $withdraws->where('status', 'completed');
        }

        if ($request->has('status') && $request->status == 'canceled') {
            $withdraws = $withdraws->where('status', 'canceled');
        }

        if ($request->has('status') && $request->status == 'pending') {
            $withdraws = $withdraws->where('status', 'pending');
        }


        if ($request->has('user_id') && $request->user_id !== null) {
            if (is_numeric($request->user_id)) {
                $withdraws = $withdraws->where('payer_id', $request->user_id);
            } else {
                return redirect()->back()->withErrors(['error' => 'Mã khách hàng phải là số nguyên dương']);
            }
        }

        $total = $withdraws;

        $withdraws = $withdraws->orderBy('id', 'DESC')->paginate(25)->appends([
            'status' => $status,
            'user_id' => $request->user_id,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate
        ]);


        return view('Statistic::withdraw_stat', compact('title', 'withdraws', 'total'));

    }


    public function depositstat(Request $request)
    {

        $title = "Thống kê nạp tiền - không tính đơn hoàn tiền";
        $deposits = new Order;
        $paygates = Paygate::pluck('code');
        $group_user = Group::where('status',1)->get();
        $status = $request->status;

        $deposits = $deposits->where('order_type', 'Deposit')->where('module', 'Wallet');


        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {

            if (Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {

                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }

            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();

            $deposits = $deposits->whereBetween('updated_at', [$fromdate, $todate]);
        }

        if ($request->has('paygate_code') && $request->paygate_code !== null) {
            $deposits = $deposits->where('paygate_code', $request->paygate_code);
        }

        if ($request->has('status') && $request->status == 'completed') {
            $deposits = $deposits->where('status', 'completed');
        }

        if ($request->has('status') && $request->status == 'canceled') {
            $deposits = $deposits->where('status', 'canceled');
        }

        if ($request->has('status') && $request->status == 'pending') {
            $deposits = $deposits->where('status', 'pending');
        }


        if ($request->has('user_id') && $request->user_id !== null) {
            if (is_numeric($request->user_id)) {
                $deposits = $deposits->where('payee_id', $request->user_id);
            } else {
                return redirect()->back()->withErrors(['error' => 'Mã khách hàng phải là số nguyên dương']);
            }
        }
        if ($request->group_user){
            $user_id = User::where('group',$request->group_user)->where('status',1)->pluck('id')->toArray();
            $deposits = $deposits->whereIn('payee_id', $user_id);
        }
        $total = $deposits;

        $deposits = $deposits->orderBy('id', 'DESC')->paginate(25)->appends([
            'status' => $status,
            'user_id' => $request->user_id,
            'paygate_code' => $request->paygate_code,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate
        ]);


        return view('Statistic::deposit_stat', compact('title', 'deposits', 'total', 'paygates','group_user'));

    }


    public function walletstat(Request $request)
    {
        $title = "Thống kê thay đổi số dư ví";
        $wallets = new WalletHistory;
        $currencies = Currencies::pluck('code', 'id');

        /// Loại các transfer vì nó ko gây biến động tổng số tiền thành viên
        $wallets = $wallets->where('code', '!=', 'T')->orderBy('id', 'desc');

        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {

            if (Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {

                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }

            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();

            $wallets = $wallets->whereBetween('created_at', [$fromdate, $todate]);
        }

        if ($request->has('user_id') && $request->user_id !== null) {
            if (is_numeric($request->user_id)) {
                $wallets = $wallets->where('user_id', trim($request->user_id));
            } else {
                return redirect()->back()->withErrors(['error' => 'Mã khách hàng phải là số nguyên dương']);
            }
        }

        if ($request->has('currency_id') && $request->currency_id !== null) {
            $wallets = $wallets->where('currency_id', $request->currency_id);
        }
        if ($request->has('code') && $request->code !== null) {
            $wallets = $wallets->where('code', $request->code);
        }

        $total = $wallets;

        $wallets = $wallets->orderBy('id', 'ASC')->paginate(40)->appends([
            'user_id' => $request->user_id,
            'code' => $request->code,
            'currency_id' => $request->currency_id,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate
        ]);


        return view('Statistic::wallet_stat', compact('title', 'wallets', 'total', 'currencies', 'doithecao', 'muamathe', 'napcuoc', 'ruttien', 'naptien'));

    }


    public function dailystat(Request $request)
    {

        $title = 'Tổng hợp giao dịch từ VÍ ĐIỆN TỬ ' . Carbon::today()->format('d-m-Y');

        $fromdate = Carbon::today()->startOfDay();
        $todate = Carbon::today()->endOfDay();

        $softcard = WalletHistory::where('code', 'S')->where('user_id', '!=', 1)->whereBetween('created_at', [$fromdate, $todate])->sum('pay_amount');
        $charging = WalletHistory::where('code', 'C')->where('user_id', '!=', 1)->whereBetween('created_at', [$fromdate, $todate])->sum('pay_amount');
        $mtopup = WalletHistory::where('code', 'M')->where('user_id', '!=', 1)->whereBetween('created_at', [$fromdate, $todate])->sum('pay_amount');
        $withdraw = WalletHistory::where('code', 'W')->where('user_id', '!=', 1)->whereBetween('created_at', [$fromdate, $todate])->sum('pay_amount');
        $deposit = WalletHistory::where('code', 'D')->where('user_id', '!=', 1)->whereBetween('created_at', [$fromdate, $todate])->sum('pay_amount');
        $fees = WalletHistory::where('code', 'T')->where('user_id', '!=', 1)->whereBetween('created_at', [$fromdate, $todate])->sum('fees');

        $cur_balance = Wallet::where('user', '!=', 1)->sum('balance_decode');
        return view('Statistic::dailystat', compact('title', 'softcard', 'charging', 'mtopup', 'withdraw', 'deposit', 'cur_balance', 'fees'));

    }


    public function mtopupstat(Request $request)
    {

        $title = "Thống kê nạp cước";
        $mtopups = new Mtopup;

        $servicecodes = MtopupTelco::select('service_code')->get();
        $providers = MtopupProvider::select('provider')->get();

        $service_code = $request->service_code;
        $provider = $request->provider;
        $status = $request->status;
        $action = (!$request->submit) ? 'filter' : $request->submit;

        if ($request->has('service_code') && $request->service_code !== null) {
            $mtopups = $mtopups->where('service_code', $service_code);
        }

        if ($request->has('fromdate') && $request->has('todate') && $request->fromdate !== null && $request->todate !== null) {

            if (Carbon::parse($request->fromdate)->gt(Carbon::parse($request->todate))) {

                return redirect()->back()->withErrors(['error' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc']);
            }

            $fromdate = Carbon::parse($request->fromdate)->startOfDay();
            $todate = Carbon::parse($request->todate)->endOfDay();

            $mtopups = $mtopups->whereBetween('created_at', [$fromdate, $todate]);
        }

        if ($request->has('provider') && $request->provider !== null) {
            $mtopups = $mtopups->where('provider', $provider);
        }

        if ($request->has('status') && $request->status == 'completed') {
            $mtopups = $mtopups->where('status', 'completed');
        }

        if ($request->has('status') && $request->status == 'canceled') {
            $mtopups = $mtopups->where('status', 'canceled');
        }

        if ($request->has('status') && $request->status == 'pending') {
            $mtopups = $mtopups->where('status', 'pending');
        }

        if ($request->has('user_id') && $request->user_id !== null) {
            if (is_numeric($request->user_id)) {
                $mtopups = $mtopups->where('user', $request->user_id);
            } else {
                return redirect()->back()->withErrors(['error' => 'Mã khách hàng phải là số nguyên dương']);
            }
        }


        if ($action == 'filter') {
            $total = $mtopups;

            $mtopups = $mtopups->orderBy('id', 'DESC')->paginate(25)->appends([
                'service_code' => $service_code,
                'status' => $status,
                'provider' => $request->provider,
                'user_id' => $request->user_id,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate
            ]);

            return view('Statistic::mtopup_stat', compact('title', 'mtopups', 'servicecodes', 'total', 'providers'));
        } elseif ($action == 'excel') {

            $data = $mtopups->orderBy('id', 'DESC')->get()->toArray();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('NAPCUOC');

            $sheet->setCellValue('A1', 'Mã đơn');
            $sheet->setCellValue('B1', 'Thuê bao');
            $sheet->setCellValue('C1', 'Loại');
            $sheet->setCellValue('D1', 'NCC');
            $sheet->setCellValue('E1', 'Cần nạp');
            $sheet->setCellValue('F1', 'Đã nạp');
            $sheet->setCellValue('G1', 'Thanh toán');
            $sheet->setCellValue('H1', 'Trạng thái');
            $sheet->setCellValue('I1', 'Ngày');
            $sheet->setCellValue('K1', 'Mã KH');

            $numRow = 2;
            foreach ($data as $row) {
                $sheet->setCellValue('A' . $numRow, $row['order_code']);
                $sheet->setCellValue('B' . $numRow, $row['phone_number']);
                $sheet->setCellValue('C' . $numRow, $row['service_code']);
                $sheet->setCellValue('D' . $numRow, $row['provider']);
                $sheet->setCellValue('E' . $numRow, $row['declared_value']);
                $sheet->setCellValue('F' . $numRow, $row['completed_value']);
                $sheet->setCellValue('G' . $numRow, $row['amount']);
                $sheet->setCellValue('H' . $numRow, $row['status']);
                $sheet->setCellValue('I' . $numRow, Carbon::parse($row['created_at'])->format('d-m-Y'));
                $sheet->setCellValue('K' . $numRow, $row['user']);
                $numRow++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'napcuoc_' . time();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');

            $writer->save("php://output");

        } else {
            return redirect()->route('statistic.mtopup')->withErrors(['error' => 'Yêu cầu không hợp lệ!']);
        }

    }

}
