<?php

namespace App\Console\Commands;

use App\Modules\Charging\Helpers\ChargingHelper;
use App\Modules\Charging\Models\ChargingsAccount;
use App\Modules\Charging\Models\ChargingsMatch;
use App\Modules\Charging\Models\ChargingsProxy;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LoginMyviettelTs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login:myvietteltrasau';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dang nhap Myviettel Tra Sau';

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
        ini_set('max_execution_time', 300);

        $check_acc = ChargingsAccount::where('type', 'napho')
            ->where('telco', 'VIETTEL')
            ->where('status', 1)
            ->where('lock', 0)
            ->where('used', 0)
            ->where('logged', 1)
            ->get();


        if (count($check_acc) < 10) {
            $n = 10 - count($check_acc);

            $accounts = ChargingsAccount::where('type', 'napho')
                ->where('telco', 'VIETTEL')
                ->where('status', 1)
                ->where('lock', 0)
                ->where('used', 0)
                ->where('logged', 0)
                ->orderBy('id', 'asc')->limit($n)->get();

            if (count($accounts) > 0) {
                $proxy = ChargingsProxy::where('lock', 0)
                    ->where('status', 1)
                    ->where('login_count', '<=', 20)
                    ->where('used', '<=', 70)
                    ->inRandomOrder()
                    ->first();

                if ($proxy) {
                    foreach ($accounts as $account) {

                        $account->ip = $proxy->ip.':'.$proxy->port;
                        $account->update();
                        ChargingHelper::loginMvt($account, $proxy->ip);

                    }
                }
            }

        }

    }
}
