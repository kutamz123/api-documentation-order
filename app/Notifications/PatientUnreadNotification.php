<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\PatientUnreadSendMail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
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
        $to = $notifiable->email ?? 'andikautama034@gmail.com';
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
        $to = $notifiable->dokterRadiology->idtele ?? '@intiwid';
        return TelegramMessage::create()
            ->to($to)
            ->view('telegram.patient-unread', [
                'patient' => $notifiable
            ]);
    }
}
