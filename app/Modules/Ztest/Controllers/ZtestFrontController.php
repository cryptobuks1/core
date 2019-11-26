<?php

namespace App\Modules\Ztest\Controllers;

use App\Modules\Catalog\Models\Catalog;
use App\Modules\Charging\Controllers\ChargingFrontController;
use App\Modules\Charging\Helpers\ChargingHelper;
use App\Modules\Charging\Models\Charging;
use App\Modules\Charging\Models\ChargingsAccount;
use App\Modules\Charging\Models\ChargingsMatch;
use App\Modules\Charging\Models\ChargingsProxy;
use App\Modules\Charging\Models\ChargingsTelco;
use App\Modules\Merchant\Models\Merchant;
use App\Modules\Mtopup\Helpers\MtopupHelper;
use App\Modules\Mtopup\Models\Mtopup;
use App\Modules\Mtopup\Models\MtopupCkey;
use App\Modules\Mtopup\Models\MtopupTelco;
use App\Modules\Order\Models\Order;
use App\Modules\Paygate\Models\Paygate;
use App\Modules\Sms\Models\Sms;
use App\Modules\Softcard\Models\Softcard;
use App\Modules\Softcard\Models\SoftcardItem;
use App\Modules\Softcard\Models\SoftcardOrder;
use App\Modules\Stockcard\Models\Stockcard;
use App\Modules\Ztest\Models\Votes;
use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use Auth;
use DB;
use App\Helpers\CurlHelper;
use Illuminate\Support\Facades\Mail;
use Log;
use File;
use Lang;
use Cookie;
use GeoIp2\Database\Reader;
use Illuminate\Routing\Route;
use App\User;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ZtestFrontController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();

    }

    var $AccessKey = '49fdc5f4-b909-4a17-ad1b-99945aa2af67';
    var $SecretAccessKey = '5459f4e06d3cf8be95659ef2a5f57d65846775b5';

    public function postip(Request $request){

        $ip = $this->getUserIpAddr();

        $data = array();
        $data['ip'] = $ip;
        $data['item'] = $request->item;

        Log::info(['Request' => json_encode($data)]);

    }


    public function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    public function testpostdata(){

        $dataPost = array(
            'item' => 'nghia',
        );

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://api.netpay.vn/chargingws/postip', [
            'json' => $dataPost
        ]);

        $statusCode = $response->getStatusCode();
        dd($statusCode);
    }



    public function kiemtragiaodich(){
        ini_set('max_execution_time', 3000);

        $order = Order::select('order_code')->groupBy('order_code')->havingRaw('count(*) > 1')->get();


        foreach ($order as $sd){


            try{
                $aaaa = Mtopup::where('order_code', $sd->order_code)->first();
                dd($aaaa);

            }catch (\Exception $e){
                continue;
            }

        }

    }


    public function ordercode(){

        $a = Merchant::find(2);
        dd($a->ips);

    }

    public function date()
    {


        $url = "https://muacard.vn/api/charging?provider=viettel&serial=55555555555&code=3333333333333&amount=100000&api_key=36add1019c204e8b67a79fe849640dfb&charging_type=1";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $output = curl_exec($handle);
        curl_close($handle);

        echo $output.'---------';
        exit();
        $name = Route::currentRouteName();
        $sc = Order::where('order_code', 'S153805951997897')->first();
        $list = $sc->softcard()->pluck('product');
        dd($list);
        $date = Carbon::now();
        echo $date->format('d-m-Y');
    }

    public function callocta(){
        //return $this->makeConnection();
    }

    public function generateAuth()
    {
        $info = ['Request' => [
            'User' =>[
                'UserName' =>'apitest3',
                'Password' =>'0123123123',
                'Captcha' => null
            ],
            'Data' =>[
                'RequestDate' => date('Y-m-d\TH:i:s').'+07:00'
            ]
        ]];

        $auth = json_encode($info);
//
//        {"Response":{"Code":0,"Message":"","Data":{"Status":null,"AccountAuthID":null,"AccountID":null,"AccessKey":"9bca0f45-e1d7-414a-90ad-9ba417e8ebfd","PublicKey":null,"SecretAccessKey":"c2da88804c26ce16e311fdf9953d6977cb827c22","ExpriedDate":"2018-09-23T15:27:44","CreateDate":null,"LastUpdate":null}},"Sign":null}
//

        $url = 'https://api2.sandbox.octa.vn/api/v3/GenarateAuth';
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $auth );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);

        print_r($result);

    }



    public function makeSignature($secretAccessKey, $body)
    {
        return base64_encode(hash_hmac("sha1", $body, $secretAccessKey,  TRUE));
    }


    public function downloadSoftpin()
    {

        $res = ['Request' =>
        ['Data' =>
            [
            'ReceiptNumber' => rand(1000000,9000000).'NC',  //// Mã order của mình
            'ServiceCode' => 'GATE10',
            'Price' => 10000,
            'Amount' => 1,
            'RequestDate' => date('Y-m-d\TH:i:s').'+07:00'
        ]]];
        $body =json_encode($res);

        //dd($body);
        $signature =  $this->makeSignature($this->SecretAccessKey, $body);

        $header = [
            'Content-Type:application/json',
            'Authorization: ECOPAY '.$this->AccessKey.':'.$signature
        ];


        $ch = curl_init('https://api2.sandbox.octa.vn/api/v3/PayCode');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

        $result = curl_exec($ch);
        curl_close($ch);


        $card = json_decode($result);


        if($card->Response->ResponseData){


            $card1 =$card->Response->Data->Transaction->Info;
            $nghia = json_decode($card1);
            $baoanh = $nghia[0];
            $code = $baoanh->Code;

            $this->card_decrypt($code, $this->SecretAccessKey);

        }


    }


    public function GetAgentInfo(){

        $res = ['Request' =>[
            'RequestDate' => date('Y-m-d\TH:i:s').'+07:00'
        ]];
        $body =json_encode($res);

        $signature =  $this->makeSignature($this->SecretAccessKey, $body);


        $header = [
            'Content-Type:application/json',
            'Authorization: ECOPAY '.$this->AccessKey.':'.$signature
        ];


        $ch = curl_init('https://api2.sandbox.octa.vn/api/v3/GetAgentInfo');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);

        $abc = json_decode($result);
        print_r($abc['Response']['Data']);
        echo'<br>';
        //$this->card_decrypt($result, $this->SecretAccessKey);

    }


    public function GetTransactionInfo(){

        $res = ['Request' =>
            ['Data' =>
                [
                    'ReceiptNumber' => '1310689NC',
                    'RequestDate' => date('Y-m-d\TH:i:s').'+07:00'
                ]]];
        $body =json_encode($res);

        $signature =  $this->makeSignature($this->SecretAccessKey, $body);


        $header = [
            'Content-Type:application/json',
            'Authorization: ECOPAY '.$this->AccessKey.':'.$signature
        ];


        $ch = curl_init('https://api2.sandbox.octa.vn/api/v3/GetTransactionInfo');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);

        $this->card_decrypt($result, $this->SecretAccessKey);
    }


    public function card_decrypt($data, $secret)
    {
        $key = md5(utf8_encode($secret), false);
        $key = substr($key, 0, 24);
        $data = base64_decode($data);
        $data = @mcrypt_decrypt('tripledes', $key, $data, 'ecb');
        $block = @mcrypt_get_block_size('tripledes', 'ecb');
        $len = strlen($data);
        $pad = ord($data[$len-1]);
        $result = substr($data, 0, strlen($data) - $pad);

        return $result;
    }

    public function adminlogin(){
        Auth::loginUsingId(1);
    }


    public function updatesku(){
        $stocks = Stockcard::all();
        foreach ($stocks as $stock) {
            $ids = SoftcardItem::where('sku', $stock->item_sku)->first();
            $stock->sku_id = $ids->id;
            $stock->update();
        }
    }

    public function testip(Request $request){

        $reader = new Reader(storage_path('app/GeoIP2-Country.mmdb'));

        $record = $reader->country('171.241.136.11');

        dd($record->registeredCountry->isoCode);

    }

    public function testpost(){

        $postdata['status'] = 2;
        $postdata['message'] = 'the dung';
        $postdata['request_id'] = 12123;
        $postdata['declared_value'] = 100000;
        $postdata['value'] = 100000;
        $postdata['amount'] = 80000;
        $postdata['code'] = 99999999999999;
        $postdata['serial'] = 88884544000;
        $postdata['telco'] = 'VIETTEL';
        $postdata['trans_id'] = 45;
        $postdata['callback_sign'] = md5(87554554);


        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://update.carddd.info/CardGate/CallbackUrl', [
            'verify' => false,
            'headers' => ['content-type' => 'application/json'],
            'body' => \GuzzleHttp\json_encode($postdata)

        ]);

        $statusCode = $response->getStatusCode();

        $result_ncc = $response->getBody()->getContents();

        dd($response);

    }


    public function testexcel(){

        $inputFileName = 'C://file.xlsx';

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($inputFileName);

        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        dd($sheetData);


       // https://techalltype.com/myblog/import-and-export-using-phpspreadsheet-library-in-codeigniter/

//        $data = [
//            ['Nguyễn Khánh Linh', 'Nữ', '500k'],
//            ['Ngọc Trinh', 'Nữ', '700k'],
//            ['Tùng Sơn', 'Không xác định', 'Miễn phí'],
//            ['Kenny Sang', 'Không xác định', 'Miễn phí']
//        ];
//
//        $spreadsheet = new Spreadsheet();
//        $sheet = $spreadsheet->getActiveSheet();
//        $sheet->setTitle('NGHIA');
//
//
//        $sheet->setCellValue('A1', 'Tên');
//        $sheet->setCellValue('B1', 'Giới Tính');
//        $sheet->setCellValue('C1', 'Đơn giá');
//
//
//        $numRow = 2;
//        foreach ($data as $row) {
//            $sheet->setCellValue('A' . $numRow, $row[0]);
//            $sheet->setCellValue('B' . $numRow, $row[1]);
//            $sheet->setCellValue('C' . $numRow, $row[2]);
//            $numRow++;
//        }
//
//
//        $writer = new Xlsx($spreadsheet);
//
//
//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header('Content-Disposition: attachment; filename="file.xlsx"');
//        $writer->save("php://output");
    }


    public function testdate(){

        $today = Carbon::today()->format('d-m-Y');
        $today_c = Carbon::parse('2019-04-05 17:22:54')->format('d-m-Y');

        $sms = Sms::where('phone', '0943793986')->where('type', 'Odp')->where('created_at','<=', Carbon::now())->where('expired_at','>=', Carbon::now())->first();

        dd($sms);



        if($today == $today_c && Carbon::parse('2019-04-06 00:00:00')->gt(Carbon::now())){
            echo 'ok';
        }else{
            dd($today_c);
        }


    }

    public function testcallback(){

        $postdata['status'] = 1;
        $postdata['request_id'] = 54554155;
        $postdata['declared_value'] = 100000;
        $postdata['value'] = 100000;
        $postdata['amount'] = 68000;
        $postdata['code'] = '454541515215';
        $postdata['serial'] = '545544111';
        $postdata['telco'] = 'VIETTEL';
        $postdata['trans_id'] = '886';
        $postdata['callback_sign'] = 'jdfhj234gfjlgnkdf3242trfgjfgd';

        $url = 'http://webthetest.com/postcallback?'.http_build_query($postdata);

        $client = new \GuzzleHttp\Client();

        try{

//            $response = $client->request('POST', $url, [
//                'headers' =>['content-type' => 'application/json', 'cache-control' => 'no-cache'],
//                'body' => \GuzzleHttp\json_encode($postdata)
//            ]);
//
//            $responseJson = $response->getBody()->getContents();
//
//            if($responseJson == 'OK'){
//                echo 'da goi thanh cong';
//            }else{
//                echo 'that bai';
//            }

//
            $response = $client->request('GET', $url);

            $statusCode = $response->getStatusCode();
            if($statusCode && $statusCode == 200){
                dd($response->getBody()->getContents());
            }else{
                echo 'nhu shit';
            }

        }catch (\Exception $e){
            dd($e->getMessage());

        }

    }

    public function mtest(){

        $napchamlist = Mtopup::where(['payment'=>'paid', 'status' => 'pending', 'telco' => 'VIETTEL'])->orderBy('id', 'ASC')->get();

        dd($napchamlist->sum('completed_value'));

    }

    public function md5test(){

        $phone = '0978989331';
}

public function testmvlogin(){

    $account = ChargingsAccount::where('type', 'napho')->where('telco', 'VIETTEL')->where('status', 1)->where('lock', 0)->where('used', '<=', 5)->orderBy('id', 'asc')->first();
//dd($account);
$obj = new \App\Modules\Charging\Controllers\ChargingMatchController;

$login = $obj->loginMyviettel($account);


}



public function testnap(){

    $account = ChargingsAccount::find(14);

    $match = ChargingsMatch::find(23);

    $parram = [
        'token' => $account->token,
        'cardcode' => $match->code,
        'phone' => $match->thuebao,
        'type' => $match->service_type,
        'ip' => '167.179.91.138',
        'port' => '80',
        'requestId' => $match->id
    ];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://150.95.104.128/api/v1/nap-the',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($parram),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "api-key: 7c5dd9daee29d72a2e0f57b623a085c1"
        ),
    ));

    $response = curl_exec($curl);

        dd($response);

}

public function testnapho(){
    ini_set('max_execution_time', 3000);

    //$input = array(20000, 50000, 100000, 200000, 10000);

    for($i=1; $i <= 10; $i++ ){
        //$rand_keys = array_rand($input, 1);


        $dataPost = array();
        $dataPost['partner_id'] = '0601968451';
        $dataPost['request_id'] = rand(1000,9000);
        $dataPost['telco'] = 'VIETTEL';
        //$dataPost['amount'] = $input[$rand_keys];
        $dataPost['amount'] = 50000;
        $dataPost['serial'] = rand(1000000,9999999);
        $dataPost['code'] = rand(1000000000000, 9999999999999);
        $dataPost['command'] = 'charging';
        $sign = $this->creatSign('6dd372151552c79c1fbabc49d02829f4', $dataPost);
        $dataPost['sign'] = $sign;

        $response = \App\Helpers\CurlHelper::curl_post('http://webthefull.com/chargingws/v2', $dataPost);
        echo $response; echo '<br>';

    }


}



   public function creatSign($partner_key, $params)
    {
        $data = array();
        $data['request_id'] = $params['request_id'];
        $data['code'] = $params['code'];
        $data['partner_id'] = $params['partner_id'];
        $data['serial'] = $params['serial'];
        $data['telco'] = $params['telco'];
        $data['command'] = $params['command'];
        ksort($data);
        $sign = $partner_key;
        foreach ($data as $item) {
            $sign .= $item;
        }

        //return $sign;

        return md5($sign);
    }




    public function needmatch(){

    $mtopups = Mtopup::all();
        foreach ($mtopups as $mtopup){
            $mtopup->need_match = $mtopup->declared_value - $mtopup->completed_value - $mtopup->lock_amount;
            $mtopup->update();
        }
    }



    public function chay(){

        $matches = ChargingsMatch::where('declared_value', 50000)->where('lock', 0)->where('status', 99)->orderBy('id', 'asc')->get();

        $obj = new \App\Modules\Charging\Controllers\ChargingMatchController;

        $obj->actionMyviettel($matches);

    }


    public function testsum(){
        $match_com = ChargingsMatch::where('mtopup_id', 111)->where('status',99)->sum('declared_value');

        dd($match_com);
    }



    public function mysqljson(){

        $a = \App\Modules\Paygate\Gateways\Vietcombank\Vietcombank::checkTransaction();

        dd($a);
    }

    public function trahang(){

        $web_config = DB::table('settings')->where('key', 'email')->first();

        dd($web_config);

    }


    public function error_viettel($message){

        switch ($message){
            case 'Quý khách đã thực hiện nạp thẻ hộ quá số lần quy định trong ngày.':
                return 6;
                break;
            case 'Mã thẻ sai hoặc đã được sử dụng':
                return 7;
                break;

        }


    }



    public function slm(){

        $ip = getIpClient();
        dd($ip);


//        $settings = \App\Modules\Stockcard\Models\Stockcardsetting::where('provider', 'Netpay')->pluck('configs')->first();
//        $provider_settings = (array)json_decode($settings);
//
//        $url = $provider_settings['post_url'];
//        $data['partner_id'] = $provider_settings['partner_id'];
//        $data['command'] = 'getbalance';
//        $data['wallet_number'] = $provider_settings['wallet_number'];
//        $data['sign'] = $this->createSign($provider_settings['partner_key'], $data);
//        $result = CurlHelper::curl_post($url, $data);
//
//        try{
//            if ($result) {
//                $result = json_decode($result, true);
//                if(is_array($result)){
//                    return $result['balance'];
//                }else{
//                    return false;
//                }
//            }else{
//                return false;
//            }
//        }catch (\Exception $e){
//            Log::info(['LAYSODU' => $e->getMessage()]);
//        }

    }


    protected function createSign($partner_key, $data)
    {
        ksort($data);

        $sign = $partner_key;
        foreach ($data as $item) {
            $sign .= $item;
        }

        $sign = md5($sign);

        return $sign;
    }

    public function paypal(){

        $time = Carbon::now()->subMinutes(1)->toDateTimeString();
        $charging = Charging::where('status', 99)->where('created_at', '<', $time)->orderBy('id', 'asc')->first();
        $p_obj = ChargingsTelco::where('key', $charging->telco)->where('provider', $charging->provider)->first();

        //Gửi lại thẻ sang nhà cung cấp phụ

        $provider = $p_obj->provider2;
        if($provider){
            if($provider == 'Me'){
                $charging->provider = 'Me';
                $charging->admin_note = 'Đổi sang nhà cung cấp phụ vì lý do đợi quá 1 phút';
                $charging->update();
            }else{
                $classPath = '\App\Modules\Charging\Providers\\' . $provider . '\\' . $provider;
                $ProviderN = new $classPath;
                $ProviderN->postcard($charging);
            }

        }

    }

    protected function createtoken(){

        $paygate = Paygate::where('code','Paypal')->first();
        $configs = json_decode($paygate->configs);

        $clientId = $configs->clientId;
        $secret = $configs->secret;

        $paypalURL = 'https://api.sandbox.paypal.com/v1/';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paypalURL.'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);

        dd($response);



        if(empty($result)){
            return null;
        }else
        {
            $json = json_decode($result);
            return $json->access_token;
        }


    }



    public function nghia1() {

     $mengia= '';

     $a = 10000;
        $menggiaout = explode(',',$mengia);

        if(in_array($a, $menggiaout)){
            dd($a);
        }else{
            echo 213123;
        }

    }


    public function error_viettela()
    {

        $message ='{"errorCode":"2","message":"Thao tác không thành công, quý khách vui lòng thao tác lại sau. Xin cảm ơn!"}';

        $message = json_decode($message);

        switch ($message->message) {

            case 'Quá trình thực hiện có lỗi. Quý khách vui lòng thao tác lại sau. Trân trọng cảm ơn.':
                $code = 11;
                break;
            case 'Thao tác không thành công, quý khách vui lòng thao tác lại sau. Xin cảm ơn!':
                $code = 12;
                break;
            case 'Thẻ cào đã nạp thành công cho thuê bao nhưng chưa được gạch nợ.':
                $code = 13;
                break;
            case 'Nạp tiền không thành công.':
                $code = 14;
                break;
            case 'Nạp sai quá số lần qui định trong ngày. ':
                $code = 15;
                break;
            case 'Hệ thống đang bận, Quý khách vui lòng thử lại sau.':
                $code = 16;
                break;
            case 'Quý khách đã nạp sai mã thẻ cào 5 lần liên tiếp. Hệ thống tạm khóa chức năng này trong vòng 1 ngày. Quý khách vui lòng quay lại sau hoặc sử dụng các kênh nạp tiền khác của Viettel. Xin cảm ơn!':
                $code = 17;
                break;
            case 'Thuê bao không đủ điều kiện nạp thẻ hộ.':
                $code = 18;
                break;
            case 'Nạp thẻ không thành công do thông tin thuê bao không hợp lệ.':
                $code = 19;
                break;

            default:
                $code = 100;
        }


        echo $code;
    }


    public function chaynapho(){

        echo "<html>\n";
        echo "<head>\n";
        echo "<title>Dang chay nap ho</title>\n";
        echo "<meta http-equiv=\"refresh\" content=\"3\">\n";
        echo "</head>\n";
        echo "<body>\n";


        $time = Carbon::now()->subMinutes(15)->toDateTimeString();
        $match = ChargingsMatch::where('lock', 0)->where('status', 99)->where('created_at', '>', $time)->orderBy('id', 'asc')->first();

        if($match){
            $obj = new \App\Modules\Charging\Controllers\ChargingMatchController;
            $log = $obj->Myviettel($match);
            $match->logs = $match->logs.'---'.$log;
            $match->update();

        }

        echo "</body>\n";
        echo "</html>";



    }

    public function proxy(){
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET', 'http://httpbin.org/ip', [

            'proxy' => [
                'http'  => 'http://username:password@192.168.16.1:10',
            ]

        ]);

        $a = $res->getBody()->getContents();
        dd($a);

    }


    public function testvtc(){

        $cps = new \App\Modules\Paygate\Gateways\Coinpayment\libs\CoinPaymentsAPI();
        $cps->Setup('cc690b36D34d1247aef935a7E2CF7e02798967F08850bC09E2e27dD460eE8c84', 'f38753a238696a9dcd7c32f53ba98db4025f69e6527a07e97afa2a703d2fb84e');

        $req = array(
            'amount' => 100.00,
            'currency1' => 'USD',
            'currency2' => 'ETH',
            'buyer_email' => 'support@nencer.com',
            'item_name' => 'Test Item/Order Description',
            'address' => '', // leave blank send to follow your settings on the Coin Settings page
            'ipn_url' => 'https://nencer.com/ipn_handler.php',
        );

        $result = $cps->CreateTransaction($req);

        dd($result);

        if ($result['error'] == 'ok') {
            $le = php_sapi_name() == 'cli' ? "\n" : '<br />';
            print 'Transaction created with ID: '.$result['result']['txn_id'].$le;
            print 'Buyer should send '.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
            print 'Status URL: '.$result['result']['status_url'].$le;
        } else {
            print 'Error: '.$result['error']."\n";
        }

    }

    public function testkhop(){

        $a = '{"key":"AKIAQGRVXXZJIIR6P6NS","secret":"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","region":"us-east-1"}';

        $obj = json_decode($a, true);
        $obj['driver'] = 'ses';

        dd($obj);

    }


    public function amazon(){
        $mail = new \App\Modules\Sendmail\Controllers\SendmailController();
        $mail->sendmail('toi dang test mail', 'cung hay day day', 'hotronet@gmail.com');
    }

    public function getfile(){
        dd(getlang('profiles.login'));
    }

    public function dacap(){
        $result = Catalog::withDepth()->find(25);
        dd($result);
    }

    public function getVotes(){
        $user_id = Auth::user()->id;
        Cookie::queue('user_data', $user_id, 120);
        $avgStar = Votes::avg('point');
        return view('Ztest::index',compact('avgStar','user_id'));
    }

    public function postVotes(Request $request){
        $user_id = Cookie::get('user_data');
        $user = User::find($user_id);
        $vote=new Votes;
        if($user){
            $vote_check= Votes::where('user_id',$user_id)->where('model_id',$request->postid)->first();
            if(!$vote_check){
                $vote= new Votes;
                $vote->user_id=$user_id;
                $vote->name=$user->name;
                $vote->module='Product';
                $vote->model_id=$request->postid;
                $vote->point=$request->rating;
                $vote->save();
            }
        }
    }
    public function getRating()
    {
        $user_id = Auth::user()->id;
        Cookie::queue('user_data', $user_id, 120);
        $avgStar = Votes::avg('point');
        return view('Ztest::rating',compact('avgStar','user_id'));
    }
    public function postRating(Request $request)
    {

        $user_id = Cookie::get('user_data');
        $user = User::find($user_id);
        $vote=new Votes;
        if($user){
            $vote_check= Votes::where('user_id',$user_id)->where('model_id',$request->postid)->first();
            if(!$vote_check){
                $vote->user_id=$user_id;
                $vote->module='Product';
                $vote->name=$request->name;
                $vote->point=$request->number_rating;
                $vote->comments=$request->comment;
                $vote->save();
            }
        }
        return back();
    }
}
