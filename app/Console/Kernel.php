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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $setting = config('setting');

        // /** import data from cbs */
        // $date    = $setting['schedule_import_cbs_monthly']['date'];
        // $time    = $setting['schedule_import_cbs_monthly']['time'];
        // $schedule->command('import:data-from-cbs')->monthlyOn($date, $time);

        /** send message to customer that has ticket for monthly prize */
        $smsDate    = $setting['schedule_send_sms_monthly']['date'];
        $smsTime    = $setting['schedule_send_sms_monthly']['time'];
        $schedule->command('sms:send-monthly-prize')->monthlyOn($smsDate, $smsTime);
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
