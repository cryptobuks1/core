<?php

namespace App\Console\Commands;

use App\Helpers\CurlHelper;
use Illuminate\Console\Command;

class Viettelkpp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'viettelkpp:keeplogin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Giu ket noi den Viettel KPP';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $res = CurlHelper::curl_get('https://api.mincasoft.io:8817/viettelpaypro/transaction/balanceInquiry');

        $res = json_decode($res);

        if($res && $res->errorId === 2003 && $res->result->responseCode =="00"){

            $out = 'Ban dang dang nhap';
        }else{
            $out = 'Ban da thoat';
        }

        $this->info($out);

    }
}
