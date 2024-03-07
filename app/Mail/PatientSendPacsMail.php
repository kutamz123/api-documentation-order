<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientSendPacsMail extends Mailable
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
        return $this->markdown('mail.patient-send-pacs', [
            'workload' => $this->workload
        ]);
    }
}
