<?php
namespace App\Customs;

use Illuminate\Mail\TransportManager;
use App\Modules\Sendmail\Models\Sendmail;
use App\Modules\Sendmail\Models\Sendmaildriver;

class CustomTransportManager extends TransportManager {


    public function __construct($app)
    {
        $this->app = $app;
        $settings = Sendmail::first();
        if($settings){
            $driver = Sendmaildriver::where('driver',$settings->driver)->first();
            if($driver){
                $connection = json_decode($driver->configs);

                if($settings->driver == 'Smtp'){
                    $this->app['config']['mail'] = [
                        'driver'        => strtolower($settings->driver),
                        'from'          => [
                            'address'   => $settings->from_email,
                            'name'      => $settings->from_name
                        ],
                        'host'          => $connection->host,
                        'port'          => $connection->port,
                        'encryption'    => $connection->encryption,
                        'username'      => $connection->username,
                        'password'      => $connection->password,
                        'sendmail'      => $connection->sendmail,
                        'pretend'       => false
                    ];
                }else{

                    $obj = json_decode($driver->configs, true);
                    $obj['driver'] = strtolower($settings->driver);
                    $obj['from'] = [
                        'address'   => $settings->from_email,
                        'name'      => $settings->from_name
                    ];

                    $this->app['config']['services'] = [
                        strtolower($settings->driver) => $obj
                    ];
                }

            }
        }

    }
}