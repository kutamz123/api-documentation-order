<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\PatientUnreadSendMail;
use Illuminate\Support\Facades\Log;
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
        $email = trim($notifiable->email);
        $to = $email == null || $email == '' ? 'andikautama034@gmail.com' : $email;

        $context = [
            'request' => $to,
            'response' => [
                'Nama Pasien' => $notifiable->name,
                'Rekam Medis' =>  $notifiable->mrn,
                'Tanggal Lahir' =>  $notifiable->birth_date,
                'Modalitas' =>  $notifiable->xray_type_code,
                'Pemeriksaan' =>  $notifiable->prosedur,
                'Waktu Pemeriksaan' =>  date('d-m-Y H:i:s', strtotime($notifiable->updated_time))
            ]
        ];

        Log::info(__FUNCTION__, $context);

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
        $idTelegram = trim($notifiable->dokterRadiology->idtele);
        $to = $idTelegram == null || $idTelegram == '' ? '@intiwid' : $idTelegram;

        $context = [
            'request' => $to,
            'response' => [
                'Nama Pasien' => $notifiable->name,
                'Rekam Medis' =>  $notifiable->mrn,
                'Tanggal Lahir' =>  $notifiable->birth_date,
                'Modalitas' =>  $notifiable->xray_type_code,
                'Pemeriksaan' =>  $notifiable->prosedur,
                'Waktu Pemeriksaan' =>  date('d-m-Y H:i:s', strtotime($notifiable->updated_time))
            ]
        ];

        Log::info(__FUNCTION__, $context);

        return TelegramMessage::create()
            ->to($to)
            ->view('telegram.patient-unread', [
                'patient' => $notifiable
            ]);
    }
}
