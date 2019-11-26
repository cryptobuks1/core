<?php

namespace App\Console\Commands;

use App\Helpers\CurlHelper;
use App\Modules\Mtopup\Models\Mtopup;
use App\Modules\Order\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class Updatemtopup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtopup:updatestatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update trang thai cua Mtopup';

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

        $time = Carbon::today()->subDays(2)->endOfDay();

        $orders = Order::where('module', 'Mtopup')
            ->where('payment', 'paid')
            ->where('status', 'pending')
            ->where('created_at', '>', $time)
            ->orderBy('id', 'asc')
            ->pluck('order_code');

        if (count($orders) > 0) {
            foreach ($orders as $order_code) {
                ini_set('max_execution_time', 600);

                $mtopups = Mtopup::where('payment', 'paid')->where('status', 'pending')->where('order_code', $order_code)->where('provider', '!=', 'Me')->get();

                if (count($mtopups) > 0) {

                    foreach ($mtopups as $mtopup) {

                        try {
                            $provider = $mtopup->provider;
                            $classPath = '\App\Modules\Mtopup\Providers\\' . $provider . '\\' . $provider;
                            $ProviderN = new $classPath;

                            $ProviderN->updateMtopup($mtopup);
                        } catch (\Exception $e) {
                            continue;
                        }

                    }


                } else {
                    continue;
                }

            }
        }


        $out = 'Da chay cap nhat trang thai thanh cong';
        $this->info($out);

    }
}
