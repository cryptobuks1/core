<?php

namespace App\Modules\Api\Controllers;

use App\Helpers\CurlHelper;
use App\Modules\Api\Models\Api;
use App\Modules\Backend\Controllers\BackendController;

use Auth;
use DB;
use GuzzleHttp;



class INetController extends BackendController
{
    public $config = [
        'post_url' => 'https://dms.inet.vn/api/rms/v1',
        'email' => 'suppor@nencer.net',
        'password' =>'147258Abc',
        'token' =>'6B1849471B7AAAA20B6BEA1D167E76763523F3BC'
    ];
    public function checkDomain($domain) {
        $data = array(
            'name' => $domain,
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/domain/checkavailable', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response){
            $result = json_decode($response);


            if($result->status === 'available'){
                return 1;
            }else{
                return 2;
            }
        }else{
            return null;
        }
    }

     public function searchDomain($domain) {
        $data = array(
            'name' => $domain,
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/domain/search', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response){
            $result = json_decode($response,true);
            return $result['content'][0]['id'];
        }else{
            return null;
        }
    }

    public  function changeDNSDomain($domain)
    {
        //get ID
        $id= $this->searchDomain($domain);
        if(isset($id) && $id!=null){
            $data = array(
                "id" => $id,
                "nsList"=>[[
                    "hostname" => "ns5.inet.vn",
                ],[
                    "hostname" => "ns6.inet.vn",
                ]]
            );
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $this->config['post_url'].'/domain/updatedns', [
                'headers' => ['token' => $this->config['token']],
                'json' => $data
            ]);
            $response = $response->getBody()->getContents();
            if($response){
                $result = json_decode($response);
                if(isset($result->id) && $id===$result->id){
                    return 1;
                }else{
                    return 2;
                }
            }
        }
        else{
            return null;
        }
    }

    public function getInfoDomain($domain){

        $id= $this->searchDomain($domain);
        if(isset($id) && $id!=null){
            $data = array(
                "id" => $id,
            );
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $this->config['post_url'].'/domain/detail', [
                'headers' => ['token' => $this->config['token']],
                'json' => $data
            ]);
            $response = $response->getBody()->getContents();

            if($response){
                $result = json_decode($response,true);
                    $output = array();
                    $output['owner'] = $this->convertUserdata($result['contacts'][0]);
                    $output['admin'] = $this->convertUserdata($result['contacts'][1]);
                    $output['tech'] = $this->convertUserdata($result['contacts'][2]);
                    $output['bill'] = $this->convertUserdata($result['contacts'][3]);

                    return $output;
            }
        }
        else{
            return null;
        }
    }
    public function convertUserdata($data){
        if($data['type'] =='registrant'){
            $type='owner';
        }
        elseif($data['type']=='admin'){
            $type='admin';
        }
        elseif($data['type']=='technique'){
            $type='tech';
        }
        else{
            $type='bill';
        }
        $output = array();
        $output['provider_customerid'] = $data['customerId'];
        $output['fullname'] = $data['fullname'];
        $output['email'] = $data['email'];
        $output['country'] = $data['country'];
        $output['province'] = $data['province'];
        $output['address'] = $data['address'];
        $output['phone'] = $data['phone'];
        $output['fax'] = $data['fax'];
        $output['type'] = $type;
        $extend=json_decode($data['dataExtend'],true);
        $output['idNumber'] = $extend['idNumber'];
        $output['birthday'] = $extend['birthday'];
        $output['gender'] = $extend['gender'];

        return $output;
    }

    //create domain
    public function createDomain(){
        $data= array(
            "name" => "test.vn",
           "period"=> 1,
           "customerId"=> 8072,
           "nsList"=> [["hostname"=> "ns1.inet.vn"],["hostname"=> "ns2.inet.vn"]],
           "contacts"=> [
              [

                  "fullname"=> "Công ty A",
                  "organization"=> true,
                  "email"=> "company@example.vn",
                  "country"=> "VN",
                  "province"=> "HNI",
                  "address"=> "247 Cầu Giấy",
                  "phone"=> "0438385588",
                  "dataExtend" =>[
                      ["gender"=>"male"],
                      ["idNumber"=>"030810700"],
                      ["birthday"=>"01/01/1971"],
                  ]
              ],
              [
                  "fullname"=> "Nguyễn Văn A",
                  "organization"=> false,
                  "email"=> "a@example.vn",
                  "country"=> "VN",
                  "province"=> "HNI",
                  "address"=> "247 cau giay",
                  "phone"=> "0974019049",
                  "fax"=> "0974019049",
                  "type"=> "admin",
                  "dataExtend" =>[
                      ["gender"=>"male"],
                      ["idNumber"=>"030810700"],
                      ["birthday"=>"01/01/1971"],
                  ]
              ],
                  [
                  "fullname"=> "Nguyễn Văn A",
                  "organization"=> false,
                  "email"=> "a@example.vn",
                  "country"=> "VN",
                  "province"=> "HNI",
                  "address"=> "247 cau giay",
                  "phone"=> "0974019049",
                  "fax"=> "0974019049",
                  "type"=> "technique",
                  "dataExtend" =>[
                      ["gender"=>"male"],
                      ["idNumber"=>"030810700"],
                      ["birthday"=>"01/01/1971"],
                  ]
              ],
              [
                  "fullname"=> "Nguyễn Văn A",
                  "organization"=> false,
                  "email"=> "a@example.vn",
                  "country"=> "VN",
                  "province"=> "HNI",
                  "address"=> "247 cau giay",
                  "phone"=> "0974019049",
                  "fax"=> "0974019049",
                  "type"=> "billing",
                  "dataExtend" =>[
                      ["gender"=>"male"],
                      ["idNumber"=>"030810700"],
                      ["birthday"=>"01/01/1971"],
                  ]
              ]
           ]
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/domain/create', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response) {
            $result = json_decode($response);
            dd($result);
        }
    }
    //đổi pass đăng nhập
    public function changePass($domain){
        $id= $this->searchDomain($domain);
        $data= array(
            'id'=> $id,
            'password' => 'newpassword'
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/domain/changepassword', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response) {
            $result = json_decode($response);
            dd($result);
        }
    }

    //create Contact
    public function createContact(){
        $data= array(
            "fullname"=> "Nguyễn Văn A",
            "registrar"=> 'inet',
            "organizationName"=> '',
            "email"=> "a@example.vn",
            "country"=> "VN",
            "province"=> "HNI",
            "address"=> "247 cau giay",
            "phone"=> "0974019049",
            "fax"=> "0974019049",
            "type"=> "billing",
            "dataExtend" =>[
                ["gender"=>"male"],
                ["idNumber"=>"030810700"],
                ["birthday"=>"01/01/1971"],
            ]
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/domain/changepassword', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response) {
            $result = json_decode($response);
            dd($result);
        }
    }

    public function emailCreate(){
        $data= array(
            "domainName"=> 'example.com',
            "planId"=> 0,
            "customerId"=> 8072,
            "period"=> 12,
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/email/create', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response) {
            $result = json_decode($response);
            dd($result['Itinerary']);
            dd($result[1][0]['FareAdt']);
        }
    }

    public function emailAccountCreate(){
        $data= array(
            "emailId"=> 0,
            "username"=> '',
            "displayName"=> '',
            "password"=> '',
            "quota"=> 0,
            "status"=> "",
            "emailForward"=> "",
            "description"=> "",
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/emailaccount/create', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response) {
            $result = json_decode($response);
            dd($result);
        }
    }

    public function EmailAccountUpdate(){
        $data= array(
           "id"=> 2073003,
            "emailId"=> 0,
            "username"=> '',
            "displayName"=> '',
            "password"=> '',
            "quota"=> 0,
            "status"=> "",
            "emailForward"=> "",
            "description"=> "",
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/emailaccount/update', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response) {
            $result = json_decode($response);
            dd($result);
        }
    }

    public function EmailAccountDelete(){
        $data= array(
            "id"=> 2073003,
            "emailId"=> 0,
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->config['post_url'].'/emailaccount/delete', [
            'headers' => ['token' => $this->config['token']],
            'json' => $data
        ]);
        $response = $response->getBody()->getContents();
        if($response) {
            $result = json_decode($response);
            dd($result);
        }
    }

}
