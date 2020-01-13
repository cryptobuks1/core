<?php

namespace App\Modules\Api\Controllers;

use App\Helpers\CurlHelper;
use App\Helpers\ValidationRc;
use App\Modules\Api\Models\Api;
use App\Modules\Api\Models\Country;
use App\Modules\Backend\Controllers\BackendController;
use ResellerClub;
use GuzzleHttp;

use Auth;
use DB;



class ResellerController extends BackendController
{
    public $config = [
        'post_url' => 'https://domaincheck.httpapi.com/',
        'api_key' => 'dNhEaXMn7ELCEzV5TxYGtUGDptji2FHb',
        'auth_userid' => 363367,
    ];

    //DOMAIN
    //domain test: thietbinas.com
    //kiểm tra domain
    public function checkDomain($domain,$tlds,$suggestAlternatives=FALSE)
    {
        $avail = array(
            'domain-name' => $domain,
            'tlds' => $tlds,
            'suggest-alternative' => $suggestAlternatives,
        );
        $this->defaultValidate($avail);
        $result= $this->callApi('GET', 'domains', 'available', $avail,NULL,'domaincheck.httpapi.com');
        dd($result);
    }
    //customerid
    public function searchCustomerid($domain)
    {
        $options= array(
            'domain-name' => $domain,
            'options' => 'OrderDetails',
        );
        $result=$this->callApi('GET', 'domains', 'details-by-name', $options,NULL,'test.httpapi.com');
        return $result->customerid;
    }
    //info DNS
    public function getDNSName($domain) {

        $customerId= $this->searchCustomerid($domain);
        if(isset($customerId)){
            $options = array(
                'customer-id' => $customerId,
            );
            $this->defaultValidate($options);
            $result=$this->callApi('GET', 'domains', 'customer-default-ns', $options,NULL,'test.httpapi.com');
            return $result;
        }
        else{
            return null;
        }
    }
    // lấy order Id
    public function getOrderId($domain) {
        $options = array(
            'domain-name' => $domain,
        );
        $this->defaultValidate($options);
        $result= $this->callApi('POST', 'domains', 'orderid', $options,NULL,'test.httpapi.com');
        return $result;
    }
    //đổi dns default
    public function changeDNSDomain($domain) {
        $orderId= $this->getOrderId($domain);
        if(isset($orderId)){
            $options = array(
                'order-id' => $orderId,
                'ns' => 'dns3.nencer.com',
                'ns' => 'dns2.nencer.com',
            );
            $this->defaultValidate($options);
            $result= $this->callApi('POST', 'domains', 'modify-ns', $options,NULL,'test.httpapi.com');
            dd($result);
            return $result->actionstatusdesc;
        }
        else{
            return null;
        }
    }

    //CONTACT

    //create contact
    public function createContact($domain) {
        $customerId= $this->searchCustomerid($domain);
        $code='VN';
        $phone='0987233805';
        if(isset($customerId)) {
            $data = array(
                'name' => 'Duy Quan',
                'company' => 'Nencer',
                'email' => 'duyquan627@gmail.com',
                'address-line-1' => 'Cau Giay',
                'city' => 'Ha Noi',
                'country' => $code,
                'zipcode' => '100000',
                'phone-cc' => '84',
                'phone' => $phone,
                'customer-id' => $customerId,
                'type' => 'Contact',
            );
            $this->defaultValidate($data);
            $result = $this->callApi('GET', 'contacts', 'add', $data, NULL, 'test.httpapi.com');
            return $result;
        }
        else{
            return null;
        }
    }
    //info contact
    public function getContact($contactId) {
        $contactDetails['contact-id'] = $contactId;
        $this->defaultValidate($contactDetails);
        $result= $this->callApi('GET', 'contacts', 'details', $contactDetails,NULL,'test.httpapi.com');
        $response=json_encode($result);
        dd(json_decode($response,true));
    }
    //Xóa contact
    public function deleteContact($contactId) {
        $contactDetails['contact-id'] = $contactId;
        $this->defaultValidate($contactDetails);
        $result= $this->callApi('POST', 'contacts', 'delete', $contactDetails,NULL,'test.httpapi.com');
        dd($result);
    }
    // Danh sách contact
    public function getListContact($domain){
        $customerId= $this->searchCustomerid($domain);
        if(isset($customerId)){
            $contactDetails= array(
                'customer-id'=>$customerId,
                'type'=>'Contact',
                'no-of-records'=>10,
                'page-no'=>1,
            );
            $this->defaultValidate($contactDetails);
            $result= $this->callApi('POST','contacts','search',$contactDetails,NULL,'test.httpapi.com');
            dd($result);
        }else{
            return null;
        }
    }

    //ORDER
    //domain test: ngaymoi.net
    //Create order (Mất tiền :D )

    public function createOrder(){
        $contactDetails= array(
            'domain-name' =>'ngaymoi.net',
            'customer-id' => 8543771,
            'months' => 1,
            'no-of-accounts' => 5,
            'invoice-option'  => 'Invoice',
        );
            $this->defaultValidate($contactDetails);
            $result= $this->callApi('GET','eelite','us/add',$contactDetails,NULL,'test.httpapi.com');
            dd($result);
    }

    //thêm số lượng email cần mua
    public function addEmail($domain){
        $order_Id= $this->getOrderId($domain);
        if(isset($order_Id)){
            $contactDetails= array(
                'order-id' => 89278454,
                'no-of-accounts' => 1,
                'invoice-option' => 'NoInvoice',
            );
            $this->defaultValidate($contactDetails);
            $result= $this->callApi('GET','eelite','us/add-email-account',$contactDetails,NULL,'test.httpapi.com');
            dd($result);
        }else{
            return null;
        }
    }
    //add email
    public function createEmail(){
            $contactDetails= array(
                'order-id' => 89278454,
                'email' => 'duyquan97@ngaymoi.net',
                'passwd' => 'Nencer@123456',
                'notification-email' => 'duyquan627@gmail.com',
                'first-name'  => 'Duy',
                'last-name' => 'Quan',
                'country-code' => 'VN',
                'language-code' => 'en'
            );
            $this->defaultValidate($contactDetails);
            $result= $this->callApi('GET','mail','user/add',$contactDetails,NULL,'test.httpapi.com');
            dd($result);
    }

    //xem thông tin email
    public function getEmail(){
        $contactDetails= array(
            'order-id' => 89278454,
            'email' => 'duyquan@ngaymoi.net',
        );
        $this->defaultValidate($contactDetails);
        $result= $this->callApi('GET','mail','user',$contactDetails,NULL,'test.httpapi.com');
        dd($result);
    }

    //update email
    public function updateEmail(){
        $contactDetails= array(
            'order-id' => 89278454,
            'email' => 'duyquan@ngaymoi.net',
            'notification-email' => 'duyquan627@gmail.com',
            'first-name'  => 'Hoang',
            'last-name' => 'Quan',
        );
        $this->defaultValidate($contactDetails);
        $result= $this->callApi('GET','mail','user/modify',$contactDetails,NULL,'test.httpapi.com');
        dd($result);
    }

    //đổi pass email
    public function changePassEmail(){
        $contactDetails= array(
            'order-id' => 89278454,
            'email' => 'duyquan@ngaymoi.net',
            'old-passwd' => 'Nencer@123456',
            'new-passwd' => 'Nencer@1234567',
        );
        $this->defaultValidate($contactDetails);
        $result= $this->callApi('GET','mail','user/change-password',$contactDetails,NULL,'test.httpapi.com');
        dd($result);
    }
    //xóa email
    public function deleteEmail(){
        $contactDetails= array(
            'order-id' => 89278454,
            'email' => 'duyquan@ngaymoi.net',
        );
        $this->defaultValidate($contactDetails);
        $result= $this->callApi('GET','mail','user/delete',$contactDetails,NULL,'test.httpapi.com');
        dd($result);
    }

    public function callApi($method, $section, $apiName, $urlArray, $section2 = NULL,$domain) {
        $urlFullArray = array(
            'head' => array(
                'protocol' => 'https',
                'domain' => $domain,
                'section' => $section,
                'section2' => $section2,
                'api-name' => $apiName,
                'format' => 'json',
                'auth-userid' => $this->config['auth_userid'],
                'api-key' => $this->config['api_key'],
            ),
            'content' => $urlArray,
        );
        $curl = curl_init();
        if($method === 'GET') {
            $url = $this->createUrl($urlFullArray);
            //dd($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        } else {
            // METHOD_POST
            $requestPath = $this->createRequestPath($urlFullArray);
            curl_setopt($curl, CURLOPT_URL, $requestPath);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

            curl_setopt($curl, CURLOPT_POST,TRUE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $parameterString = $this->createParameterString($urlFullArray);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parameterString);
        }
        $json_result = curl_exec($curl);
        if (curl_errno($curl)) {
            return null;
        }
        curl_close($curl);
        $result_array = json_decode($json_result);
        return $result_array;
    }
    private function createRequestPath($urlFullArray) {
        $head = $urlFullArray['head'];
        $protocol = $head['protocol'];
        $domain = $head['domain'];
        $section = $head['section'];
        $section2 = $head['section2'];
        $apiName = $head['api-name'];
        $format = $head['format'];

        if (NULL == $section2) {
            $requestPath = "$protocol://$domain/api/$section/$apiName.$format";
        }
        else {
            $requestPath = "$protocol://$domain/api/$section/$section2/$apiName.$format";
        }
        return $requestPath;
    }
    public function createUrlParameters($parameters) {
        $parameterItems = array();
        foreach ($parameters as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    if ($this->isValidUrlParameter($item)) {
                        $parameterItems[] = $key . '=' . urlencode($item);
                    }
                }
            }
            elseif ($this->isValidUrlParameter($value)) {
                $parameterItems[] = $key . '=' . urlencode($value);
            }
            else {
                return null;
            }
        }
        return implode('&', $parameterItems);
    }
    private function isValidUrlParameter($parameter) {
        if (is_string($parameter) || is_int($parameter) || is_bool($parameter)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    public function createUrl($urlFullArray) {
        $requestPath = $this->createRequestPath($urlFullArray);
        $parameterString = $this->createParameterString($urlFullArray);
        return $requestPath . '?' . $parameterString;
    }
    private function createParameterString($urlFullArray) {
        $head = $urlFullArray['head'];
        $urlArray = $urlFullArray['content'];
        if (isset($head['auth-userid']) && isset($head['api-key'])) {
            $authParameter = array(
                'auth-userid' => $head['auth-userid'],
                'api-key' => $head['api-key'],
            );
            $authParameterString = $this->createUrlParameters($authParameter);
        }
        $parameterString = $this->createUrlParameters($urlArray);
        $parameters = '';
        if (!empty($parameterString)) {
            if (!empty($authParameterString)) {
                $parameters .= $authParameterString . '&';
            }
            $parameters .= $parameterString;
        }
        return $parameters;
    }
    public function validaterc($type, $subType, $parameters) {
        $validator = new ValidationRc();
        return $validator->validate($type, $subType, $parameters);
    }
    public function defaultValidate($parameters) {
        return $this->validaterc('array', 'default', $parameters);
    }
    public function internetbs_runCommand($commandUrl, $postData)
    {
        //If field starts with '@', escape it
        foreach ($postData as $key => $value) {
            if (substr($value, 0, 1) == "@") {
                $postData = http_build_query($postData);
                break;
            }
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $commandUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $data = curl_exec($ch);
        $result = json_decode($data, true);

        $logData["action"] = $commandUrl;
        $logData["requestParam"] = $postData;
        $logData["responseParam"] = $data;

        curl_close($ch);

        return ($data === false) ? false : $result;
//        return (($data === false) ? false : $this->internetbs_parseResult($data));
    }
    public function corectPhone($phone,$code)
    {
        $code=Country::where('code',$code)->select('dial_code')->first();
        if (is_numeric($phone)) {
            if (strlen($phone) == 9 && substr($phone, 0, 1) !== '0') {
                return $code->dial_code .'.'. $phone;
            } elseif (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
                return $code->dial_code .'.'. substr($phone, 1);
            } else {
                return $phone;
            }
        } else {
            return $phone;
        }
    }

}
