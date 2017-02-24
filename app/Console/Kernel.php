<?php

namespace App\Console;

use App\Console\Commands\MakeSignature;
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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\SendSms::class,
        \App\Console\Commands\RbcxSendSms::class,
        \App\Console\Commands\WaterPurifierSendSms::class,
        \App\Console\Commands\ImportFileMenu::class,
        \App\Console\Commands\ExportMenu::class,
        \App\Console\Commands\SendTemplateMsg::class,
        //临时人保车险导出
        \App\Console\Commands\RbcxExprot::class,
        \App\Console\Commands\RbcxScheduledPay::class,
        \App\Console\Commands\RxcxScheduledPay::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('inspire')
//                  ->hourly();
		$schedule->command('templatemsg:send')->everyThirtyMinutes()->withoutOverlapping();
    }
}
