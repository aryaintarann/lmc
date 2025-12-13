<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('sitemap:generate')->daily();
Schedule::command('seo:check-decay')->weeklyOn(1, '08:00');
Schedule::command('trends:analyze')->dailyAt('00:00');
