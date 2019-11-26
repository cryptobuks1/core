<?php

namespace App\Console\Commands;

use App\Modules\Wallet\Models\Wallet;
use Illuminate\Console\Command;
use DB;

class Sumbalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sum:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $user_balance = Wallet::where('user', '!=', 1)->sum('balance_decode');
        $balance = Wallet::where('user', 1)->first();
        $admin_balance = $balance->balance_decode;

        $data = array();
        $data['balance_user'] = $user_balance;
        $data['balance_admin'] = $admin_balance;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('balance_logs')->insert($data);

        $this->info('Cap nhat so du thanh cong');
    }
}
