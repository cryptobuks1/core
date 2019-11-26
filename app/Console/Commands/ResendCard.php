<?php

namespace App\Console\Commands;

use App\Modules\Charging\Helpers\ChargingHelper;
use App\Modules\Charging\Models\Charging;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ResendCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resend:subprovider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gui the sang nha cung cap phu khi qua gio';

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
        $time = Carbon::now()->subMinutes(2)->toDateTimeString();
        $time_td = Carbon::today()->toDateTimeString();

        $chargings = Charging::where('status', 99)
            ->where('lock', 0)
            ->where('created_at', '>=', $time_td)
            ->where('created_at', '<=', $time)
            ->orderBy('id', 'asc')->limit(20)->get();


        if(count($chargings) > 0){

            foreach ($chargings as $charging){
                $charging->lock = 1;
                $charging->update();
                ChargingHelper::callSubProvider($charging);

            }

        }

    }
}
