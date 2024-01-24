<?php

namespace App\Mail;

use App\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PatientUnreadSendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $workload;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($workload)
    {
        $this->workload = $workload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.patient-unread', [
            'workload' => $this->workload
        ]);
    }
}
