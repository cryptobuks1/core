<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\Viettelkpp',
        'App\Console\Commands\Updatemtopup',
        'App\Console\Commands\Sumbalance',
        'App\Console\Commands\Resetnapho',
        'App\Console\Commands\SendmailOrder',
        'App\Console\Commands\UpdatVietcombank',
        'App\Console\Commands\ResendCard',
        'App\Console\Commands\Xoanhap',
        'App\Console\Commands\Cancelmatch',
        'App\Console\Commands\LoginMyviettelTs',
        'App\Console\Commands\Resetvip',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('viettelkpp:keeplogin')->everyTenMinutes();
        // $schedule->command('update:vietcombank')->everyMinute();
        $schedule->command('mtopup:updatestatus')->everyFiveMinutes();
        $schedule->command('sum:balance')->cron('0 0 * * *');
        $schedule->command('reset:napho')->cron('0 0 * * *');
        $schedule->command('sendmail:order')->everyMinute();
        $schedule->command('resend:subprovider')->cron('*/2 * * * *');
        $schedule->command('delete:noneorder')->everyFiveMinutes();
        $schedule->command('cancel:match')->everyMinute();
        $schedule->command('login:myvietteltrasau')->everyMinute();
        $schedule->command('realestate:resetvip')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
