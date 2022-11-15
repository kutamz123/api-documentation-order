<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\PatientUnreadSendMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Telegram\TelegramMessage;

class PatientUnreadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['telegram', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return App\Mail\PatientUnreadSendMail
     */
    public function toMail($notifiable)
    {
        if ($notifiable->order->dokradid == null) {
            if ($notifiable->pk_dokter_radiology == null) {
                $to = "andikautama034@gmail.com";
            } else {
                $to = $notifiable->dokterRadiology->dokrad_email;
            }
        } else {
            $to = $notifiable->order->dokterRadiology->dokrad_email;
        }

        return (new PatientUnreadSendMail($notifiable))
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
        if ($notifiable->order->dokradid == null) {
            if ($notifiable->pk_dokter_radiology == null) {
                $to = "@intiwid";
            } else {
                $to = $notifiable->dokterRadiology->idtele;
            }
        } else {
            $to = $notifiable->order->dokterRadiology->idtele;
        }

        return TelegramMessage::create()
            ->to($to)
            ->view('telegram.patient-unread', [
                'workload' => $notifiable
            ]);
    }
}
