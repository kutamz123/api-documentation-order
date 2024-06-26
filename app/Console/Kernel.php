<?php

namespace App\Console;

use App\ActiveDicomRouter;
use App\Patient;
use App\ActiveUpdateSimrs;
use App\ActiveNotificationUnread;
use App\ActiveNotificationSendPacs;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // setting update ke simrs
        $schedule->command('simrs:update-uid')
            ->everyMinute()
            ->when(function () {
                $active = ActiveUpdateSimrs::first();
                return (bool) $active->is_active ?? false;
            });

        // setting log notif masuk ke pacs
        $schedule->command('log:modality-pacs')
            ->everyMinute()
            ->onSuccess(function () {
                Patient::where('pat_custom2', null)->update(['pat_custom2' => '1']);
            });

        // setting notifikasi pasien saat dikirim ke pacs
        $schedule->command('notification:patient-send-pacs')
            ->everyMinute()
            ->when(function () {
                $active = ActiveNotificationSendPacs::first();
                // ketika notif telegram active atau notif mail active
                if ($active->is_active_telegram || $active->is_active_mail) {
                    $response = true;
                } else {
                    $response = false;
                }
                return $response;
            });

        // setting notifikasi pasien belum dibaca selama 2 jam
        $schedule->command('notification:patient-unread')
            ->everyMinute()
            ->when(function () {
                $active = ActiveNotificationUnread::first();
                // ketika notif telegram active atau notif mail active
                if ($active->is_active_telegram || $active->is_active_mail) {
                    $response = true;
                } else {
                    $response = false;
                }
                return $response;
            });

        // setting send dicom to dicom router
        $schedule->command('satu-sehat:dicom-router')
            ->everyMinute()
            ->when(function () {
                $active = ActiveDicomRouter::first();
                return (bool) $active->is_active ?? false;
            });
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
