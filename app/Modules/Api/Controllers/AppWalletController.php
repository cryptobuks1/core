<?php

namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\Api;
use App\Modules\Order\Helpers\OrderHelper;
use App\Modules\Order\Models\Order;
use App\Modules\Setting\Models\Setting;
use App\Modules\User\Helpers\FlightHelper;
use App\Modules\User\Models\User as UserModel;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletHistory;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use App\Helpers\CurlHelper;
use Log;
use File;
use Hash;
use Illuminate\Routing\Route;
use Carbon\Carbon;

class AppWalletController extends FrontendController
{

    public $client_ip;
    public $app_key;

    public function __construct()
    {
        parent::__construct();
        $this->app_key = config('app.MOB_KEY');
    }

    public function appWalletHistory(Request $request)
    {
        $this->client_ip = getIpClient();
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        if (!isset($request->api_token) || !$request->api_token) {
            return $this->set_output(605);
        }

        if (!isset($request->user_id) || !$request->user_id) {
            return $this->set_output(606);
        }

        if ($request->user_id == 1) {
            return null;
        }

        if (!isset($request->walletId)) {
            return $this->set_output(622);
        }

        $userinfo = UserModel::where('id', $request->user_id)->where('api_token', $request->api_token)->first();
        if ($userinfo) {
            $wallet = Wallet::find($request->walletId);
            if ($wallet) {
                $per_page = (isset($request->per_page) && $request->per_page > 0) ? $request->per_page : 10;
                $page = (isset($request->page) && $request->page > 1) ? $request->page : 1;
                $trans = WalletHistory::where('user_id', $request->user_id)->orderBy('id', 'desc')->paginate($per_page, ['*'], 'page', $page);

                return $trans;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function appWalletTransfer(Request $request)
    {
        $this->client_ip = getIpClient();
        if (!isset($request->MOB_KEY) || $request->MOB_KEY !== $this->app_key) {
            return $this->set_output(603);
        }

        if (!isset($request->api_token) || !$request->api_token) {
            return $this->set_output(605);
        }

        if (!isset($request->user_id) || !$request->user_id) {
            return $this->set_output(606);
        }

        if ($request->user_id == 1) {
            return null;
        }

        if (!isset($request->walletId)) {
            return $this->set_output(622);
        }

        if (!isset($request->amount) || $request->amount <= 0) {
            return $this->set_output(624);
        }

        if (!isset($request->description) || !$request->description) {
            return $this->set_output(625);
        }

        if (!isset($request->username) || !$request->username) {
            return $this->set_output(626);
        }

        $name = FlightHelper::getName($request->username);
        if (!$name) {
            return $this->set_output(627);
        }

        $userinfo = UserModel::where('id', $request->user_id)->where('api_token', $request->api_token)->first();
        if ($userinfo) {
            $payer_wallet = Wallet::where(['id' => $request->walletId, 'user' => $request->user_id, 'status' => 1])->first();
            if ($payer_wallet) {

                $setting = Setting::where('key', 'allow_transfer')->first();
                if ($setting->value == 1) {

                    $payee = UserModel::where('username', $request->username)->where('status', 1)->first();
                    if (!$payee) {
                        return $this->set_output(628);
                    }

                    $payee_wallet = Wallet::where(['user' => $payee->id, 'status' => 1, 'currency_id' => $payer_wallet->currency_id])->first();

                    if (!$payee_wallet) {
                        return $this->set_output(629);
                    }

                    if ($payee_wallet->number == $payer_wallet->number) {

                        return $this->set_output(631);
                    }

                    $amount = abs(floatval($request->amount));
                    $description = strip_tags($request->description);

                    $order_fees = OrderHelper::paygateFees($amount, 'Wallet', 'Wallet_' . $payee_wallet->currency_code, $request->user_id, 't');

                    $pay_amount = $request->amount + $order_fees;

                    if ($pay_amount > floatval($payer_wallet->balance_decode)) {

                        return $this->set_output(632);
                    }

                    $validate = OrderHelper::validateOrder($amount, 'Wallet', 'Wallet_' . $payee_wallet->currency_code, $request->user_id, 't');
                    if ($validate !== 'validated') {
                        return json_encode(['error_code' => 633, 'message' => $validate]);
                    }

                    $minute = date('dmYHi', time());
                    DB::beginTransaction();
                    try {


                        $order = new Order;
                        $order->order_code = 'TA' . time() . mt_rand(1000, 9999);
                        $order->order_type = 'Transfer';
                        $order->module = 'Wallet';
                        $order->currency_id = $payer_wallet->currency_id;
                        $order->currency_code = $payer_wallet->currency_code;
                        $order->payer_id = $payer_wallet->user;
                        $order->payer_wallet = $payer_wallet->number;
                        $order->payer_info = '';
                        $order->payee_id = $payee_wallet->user;
                        $order->payee_wallet = $payee_wallet->number;
                        $order->payee_info = $request->username;
                        $order->net_amount = abs($request->amount);
                        $order->fees = $order_fees;
                        $order->pay_amount = $pay_amount;
                        $order->paygate_code = 'Wallet';
                        $order->bank_code = 'Wallet_' . $payee_wallet->currency_code;
                        $order->payment_type = 't';
                        $order->affiliate_code = '';
                        $order->status = 'none';
                        $order->payment = 'none';
                        $order->shipment = 0;
                        $order->shipment_info = null;
                        $order->description = $description;
                        $order->admin_note = '';
                        $order->ipaddress = $this->client_ip;
                        $order->creator = $request->user_id;
                        $order->code = 'T' . strtoupper(md5($minute . $request->user_id));
                        $order->token = sha1($order->code . $order->id . $order->payer_id . 'NC');
                        $order->save();

                        $time = rand(1000000, 3000000);
                        usleep($time);
                        $response = Wallet::transferFund($order->id);
                        if ($response === 'PAY_SUCCESS') {

                            $order->status = 'completed';
                            $order->update();
                            DB::commit();

                            return json_encode(['error_code' => 0, 'message' => 'Chuyển tiền thành công!']);

                        } else {

                            return json_encode(['error_code' => 1, 'message' => 'Chuyển tiền thất bại!']);
                        }
                    } catch (\Exception $e) {
                        DB::rollback();
                        return json_encode(['error_code' => 2, 'message' => 'Chuyển tiền thất bại do có lỗi hệ thống!']);
                    }

                } else {

                    return $this->set_output(630);
                }


            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    protected function set_output($error_code)
    {
        $output = array();
        $output['error_code'] = $error_code;
        $output['message'] = Api::error_code($error_code);
        echo json_encode($output);
    }


}
