<?php

namespace Sajed13\Commodity\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('commodities:fetch')->cron('0 */3 * * *');
        $schedule->command('commodities:fetch')->everyFiveMinutes();
    }
}
