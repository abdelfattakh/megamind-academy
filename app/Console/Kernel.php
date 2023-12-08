<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(fn () => info('Schedule Working'))->everyMinute()->when(config('app.debug'));

        if (config('queue.default') == 'database') {
            $this->startDBQueue($schedule);
        }

        $schedule->command('cache:prune-stale-tags')->hourly();

        $schedule->command('model:prune')->monthly();
    }

    private function startDBQueue(Schedule $schedule): void
    {
        $schedule->command('queue:restart')->everyFiveMinutes();

        // --stop-when-empty
        $schedule->command('queue:work --queue=high,default --max-time=500 --tries=10')
            ->everyMinute()
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
