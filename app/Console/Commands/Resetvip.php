<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Modules\Realestates\Models\Realestates;


class Resetvip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'realestate:resetvip';

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
        $time = Carbon::today()->subDay(90)->endOfDay();

        $now= Carbon::now();
        $data=  Realestates::where('module','Realestates')
            ->where('end_date','<',$now)
            ->where('created_at', '>', $time)
            ->update(['status' => 3]);
    }
}
