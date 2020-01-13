<?php
require_once realpath(__DIR__) . '/Autoload.php';

TechAPIAutoloader::register();

use TechAPI\Constant;
use TechAPI\Client;
use TechAPI\Auth\ClientCredentials;

// config api
Constant::configs(array(
    'mode'            => Constant::MODE_LIVE,
    //'mode'            => Constant::MODE_SANDBOX,
    'connect_timeout' => 15,
    'enable_cache'    => false,
    'enable_log'      => false,
    'log_path'    => realpath(__DIR__) . '/logs'
));


// config client and authorization grant type
function getTechAuthorization($CLIENT_ID, $CLIENT_SECRET, $smstype)
{    
    $client = new Client(
        //'YOUR_CLIENT_ID',
        //'YOUR_CLIENT_SECRET',
        //'e615D85fc918f252e1754Ce2391c8Ef923AAB401',
        //'663642d023602e28784F8789dC939f14a54ece5f588848beBdd6314fab8c274de8B618a4',
        $CLIENT_ID,
        $CLIENT_SECRET,
        ///array('send_brandname_otp') // array('send_brandname', 'send_brandname_otp')
        array($smstype)
    );
    
    return new ClientCredentials($client);
}