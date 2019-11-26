<?php

namespace App\Console\Commands;

use App\Modules\Charging\Controllers\ChargingMatchController;
use App\Modules\Charging\Models\Charging;
use App\Modules\Charging\Models\ChargingsMatch;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Cancelmatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:match';

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
        $time_bg = Carbon::now()->subMinutes(60)->toDateTimeString();
        $time_fn = Carbon::now()->subMinutes(4)->toDateTimeString();

        $matchs = ChargingsMatch::where('status', 99)
            ->where('created_at', '>=', $time_bg)
            ->where('created_at', '<=', $time_fn)
            ->orderBy('id', 'asc')->get();

        if(count($matchs) > 0){

            foreach ($matchs as $match){

                $match->lock = 0;
                $match->update();

                $obj = new ChargingMatchController;
                $obj->action_cancel($match,0,':Hệ thống tự động hủy do đợi quá 4 phút',1);
            }

        }

    }
}
