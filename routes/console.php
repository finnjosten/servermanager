<?php

use App\Console\Commands\CloneDb;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;

if (env('APP_IS_FALLBACK') != true) {
    Schedule::command(CloneDb::class)->daily();
}
