<?php

namespace App\Console;

use App\Console\Commands\Disputes\GenerateTableDisputes;
use App\Console\Commands\Disputes\GenerateTableFactor;
use App\Console\Commands\Disputes\VerificationDispute;
use App\Console\Commands\Youtube\YoutubeChannelLastVideo;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Youtube\YoutubeVideo::class,
        Commands\Youtube\YoutubeChannel::class,
        YoutubeChannelLastVideo::class,

        GenerateTableDisputes::class,
        GenerateTableFactor::class,
        VerificationDispute::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
