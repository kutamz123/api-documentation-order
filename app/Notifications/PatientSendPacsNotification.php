<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\PatientSendPacsMail;
use App\ActiveNotificationSendPacs;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramMessage;

class PatientSendPacsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $active = ActiveNotificationSendPacs::first();
        if ($active->is_active_telegram == 1 && $active->is_active_mail == 1) {
            // ketika telegram dan mail aktif maka notif kirim ke telegram dan mail
            $response = ['telegram', 'mail'];
        } else if ($active->is_active_telegram == 1) {
            // ketika telegram aktif maka notif kirim ke telegram
            $response = ['telegram'];
        } else if ($active->is_active_mail == 1) {
            // ketika mail aktif maka notif kirim ke mail
            $response = ['mail'];
        }
        return $response;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // ketika dokradid di xray_order kosong atau
        // dokrad_email dari xray_order maka isi - eror
        if (
            $notifiable->order->dokradid == null ||
            $notifiable->order->dokterRadiology->dokrad_email == null
        ) {
            $to = "-";
        } else {
            // ketika dokter radiologi dixray_order ada maka
            $to = $notifiable->order->dokterRadiology->dokrad_email;
        }

        return (new PatientSendPacsMail($notifiable))
            ->to($to);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Get the telegram representation of the notification
     *
     * @param  mixed  $notifiable
     *
     */

    public function toTelegram($notifiable)
    {
        // ketika dokradid di xray_order kosong atau
        // idtele dari xray_order maka isi - eror
        if (
            $notifiable->order->dokradid == null ||
            $notifiable->order->dokterRadiology->idtele == null
        ) {
            $to = 0;
        } else {
            // ketika dokter radiologi dixray_order ada maka
            $to = $notifiable->order->dokterRadiology->idtele;
        }

        return TelegramMessage::create()
            ->to($to)
            ->view('telegram.patient-send-pacs', [
                'workload' => $notifiable
            ]);
    }
}
