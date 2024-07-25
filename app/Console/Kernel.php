<?php

namespace App\Console;


use App\Models\Deliveryer;
use App\Models\PosMachine;
use App\Traits\WeChat\WechatDefaultConfig;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    use WechatDefaultConfig;

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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('cashier-settlement')
//            ->dailyAt(settings('opening_hours_end'));
//
        $schedule->command('deliveryer-settlement')
            ->dailyAt(settings('opening_hours_end'));

        $schedule->call(function () {
            PosMachine::query()->update([
                'status' => PosMachine::STATUS_IDLE,
                'deliveryer_id' => 0,
                'base_amount' => 0
            ]);
            Deliveryer::query()->update([
                'status' => 'offline',
                'base_amount' => 0
            ]);
        })->dailyAt(settings('opening_hours_end'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
