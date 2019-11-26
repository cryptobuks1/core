<?php

namespace App\Console\Commands;

use App\Modules\Charging\Models\ChargingsAccount;
use App\Modules\Charging\Models\ChargingsProxy;
use Illuminate\Console\Command;

class Resetnapho extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:napho';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset tai khoan nap ho sau 12h dem';

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
        $accounts = ChargingsAccount::get();
        foreach ($accounts as $account){
            $account->used = 0;
            $account->used_amount = 0;
            $account->lock = 0;
            $account->ip= null;
            $account->status = 1;
            $account->logged = 0;
            $account->counts = 0;
            $account->token = null;
            $account->logs = null;
            $account->update();
        }

        $proxies = ChargingsProxy::get();
        foreach ($proxies as $proxy){
            $proxy->used = 0;
            $proxy->lock = 0;
            $proxy->counts = 0;
            $proxy->login_count = 0;
            $proxy->status = 1;
            $proxy->update();
        }

        $this->info('Phuc hoi thanh cong');

    }
}
