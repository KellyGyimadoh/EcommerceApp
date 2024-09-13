<?php


use App\Console\Commands\UpdateExpiredProducts;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Register the schedule within the console routes
// app()->booted(function () {
//     $schedule = app(Schedule::class);
//     $schedule->command('app:update-expired-products')->everyFifteenMinutes();
// });
