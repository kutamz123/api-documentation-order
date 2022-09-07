<?php

namespace App\Console\Commands;

use App\WorkloadRadiographer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PatientUnreadNotification;

class PatientUnreadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:patient-unread';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'call notification for patient unread';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $patients = WorkloadRadiographer::where('status', 'ready to approve')->get();

        Notification::send($patients, new PatientUnreadNotification());
    }
}
