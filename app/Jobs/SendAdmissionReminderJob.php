<?php


namespace App\Jobs;

use App\Models\AdmissionItem;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\AdmissionReminderMail;
use App\Models\AdmissionReminderLog;



class SendAdmissionReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
{
    Log::info("SendAdmissionReminderJob dijalankan pada " . now());

    $today = Carbon::today('Asia/Jakarta');
    $reminderDays = [7, 1]; // H-7 & H-1

    $students = User::where('role', 'student')
                    ->where('wants_notification', true)
                    ->whereNotNull('notification_type')
                    ->get();

    $items = AdmissionItem::with('admission')->whereNotNull('start_date')->get();

    $totalItemsToSend = 0;
    $totalRemindersSent = 0;

    foreach ($items as $item) {
        if (!$item->admission) continue;

        $startDate = Carbon::parse($item->start_date);
        if ($startDate->isPast()) continue;

        foreach ($reminderDays as $daysBefore) {
            $checkDate = $startDate->copy()->subDays($daysBefore);
            if (!$checkDate->isSameDay($today)) continue;

            Log::info("Processing admission item '{$item->name}' (category: {$item->admission->category}, start_date: {$item->start_date})");

            foreach ($students as $student) {
                $notifTypes = is_array($student->notification_type) 
                               ? $student->notification_type 
                               : [$student->notification_type];

                Log::info("Student: {$student->email}, notification_type: [" . implode(',', $notifTypes) . "]");

                if (!in_array($item->admission->category, $notifTypes)) {
                    Log::info("  -> Skipped, category not in student's notification_type");
                    continue;
                }

                // Mandiri wajib cocok campus
                if (in_array('mandiri', $notifTypes) && 
                    $item->admission->category === 'mandiri' &&
                    $student->campus_id !== $item->admission->campus_id) {
                    Log::info("  -> Skipped, Mandiri category but campus mismatch (student: {$student->campus_id}, item: {$item->admission->campus_id})");
                    continue;
                }

                $alreadySent = AdmissionReminderLog::where('user_id', $student->id)
                    ->where('admission_item_id', $item->id)
                    ->where('category', $item->admission->category)
                    ->exists();

                Log::info("  -> Already sent? " . ($alreadySent ? "YES" : "NO"));

                if ($alreadySent) continue;

                // Kirim email
                Mail::to($student->email)->send(new AdmissionReminderMail($student, $item));
                $totalRemindersSent++;

                // Simpan log
                AdmissionReminderLog::create([
                    'user_id' => $student->id,
                    'admission_item_id' => $item->id,
                    'category' => $item->admission->category,
                    'sent_at' => now(),
                ]);

                Log::info("  -> Email dikirim ke {$student->email}");
            }

            $totalItemsToSend++;
            break; // hindari double reminder untuk hari sama
        }
    }

    Log::info("SUMMARY: Items processed: {$totalItemsToSend}, email terkirim: {$totalRemindersSent}");
}

}





   // public function handle()
    // {
    //     Log::info("SendAdmissionReminderJob dijalankan pada " . now());

    //     $today = Carbon::today('Asia/Jakarta');
    //     $reminderDays = [7, 1]; // H-7 dan H-1

    //     // Ambil semua siswa yang ingin notifikasi
    //     $students = User::where('role', 'student')
    //                     ->where('wants_notification', true)
    //                     ->get();

    //     Log::info("Jumlah siswa yang akan dikirimi notifikasi: " . $students->count());

    //     // Ambil semua item dengan start_date
    //     $items = AdmissionItem::whereNotNull('start_date')->get();

    //     $totalItemsToSend = 0;
    //     $totalRemindersSent = 0;

    //     foreach ($items as $item) {
    //         $startDate = Carbon::parse($item->start_date);

    //         if ($startDate->isPast()) continue;

    //         foreach ($reminderDays as $daysBefore) {
    //             $checkDate = $today->copy()->addDays($daysBefore);

    //             if ($checkDate->isSameDay($startDate)) {
    //                 Log::info("Kirim reminder H-{$daysBefore} untuk item: {$item->name}, start_date: {$item->start_date}");

    //                 foreach ($students as $student) {
    //                     Log::info("Kirim reminder ke: {$student->email}, item: {$item->name}, H-{$daysBefore}");
    //                     // Kirim email langsung di job
    //                     Mail::to($student->email)->send(new AdmissionReminderMail($student, $item));
    //                     $totalRemindersSent++;
    //                 }

    //                 $totalItemsToSend++;
    //                 // hanya kirim sekali per item per hari, keluar dari loop reminderDays
    //                 break;
    //             }
    //         }
    //     }

    //     Log::info("SendAdmissionReminderJob selesai dijalankan pada " . now());
    //     Log::info("Summary hari ini: total items untuk dikirim: {$totalItemsToSend}, total reminders dikirim: {$totalRemindersSent}");
    // }