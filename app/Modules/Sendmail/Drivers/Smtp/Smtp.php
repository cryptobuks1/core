<?php
namespace App\Modules\Sendmail\Drivers\Smtp;
class Smtp {

    public $config = [
        'host' => 'smtp.gmail.com',
        'username' => 'your_email',
        'password' => 'your_password',
        'port' => '587',
        'encryption' => 'tls',
        'sendmail' => '/usr/sbin/sendmail -bs'
    ];

}