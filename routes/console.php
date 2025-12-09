<?php

// use Illuminate\Support\Facades\Artisan;
// use App\Jobs\SendAdmissionReminderJob;
// use Illuminate\Console\Scheduling\Schedule;

// // Command untuk dispatch job
// Artisan::command('reminder:admission', function () {
//     SendAdmissionReminderJob::dispatch();
//     $this->info('Admission reminder job dispatched.');
// })->purpose('Send admission reminder emails to students');

// // Scheduler
// app()->booted(function () {
//     $schedule = app(Schedule::class);

//     // Jalankan setiap hari jam 08:00 WIB
//     $schedule->command('reminder:admission')
//              ->dailyAt('13:59')
//              ->timezone('Asia/Jakarta');
// });
