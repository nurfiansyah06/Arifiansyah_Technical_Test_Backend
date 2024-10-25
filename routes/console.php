<?php

use App\Console\Commands\UpdateIsExistsPenalty;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('app:update-is-exists-penalty', function () {
    $command = new UpdateIsExistsPenalty();
    $command->handle();
})->describe('Update is exists penalty');


Schedule::command('app:update-is-exists-penalty')->daily();