<?php

namespace App\Console\Commands;

use App\Modules\Mtopup\Models\Mtopup;
use App\Modules\Order\Models\Order;
use App\Modules\Softcard\Models\SoftcardOrder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Xoanhap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:noneorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xoa don hang nhap';

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
        $time = Carbon::now()->subMinute(15);
        Order::where('payment', 'none')->where('status', 'none')->where('created_at','<', $time)->delete();
        Mtopup::where('payment', 'none')->where('status', 'none')->where('created_at','<', $time)->delete();
        SoftcardOrder::where('payment', 'none')->where('status', 'none')->where('created_at','<', $time)->delete();


    }
}
