<?php

namespace App\Console\Commands;

use App\Workload;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PatientSendPacsNotification;
use Illuminate\Support\Facades\Log;

class PatientSendPacsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:patient-send-pacs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'call notification for patient send pacs';

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
        $workloads = Workload::with(["study.patient"])->where('status', 'waiting')
            ->doesntHave('notificationSendPacs')
            ->get();

        Notification::send($workloads, new PatientSendPacsNotification());

        // try {
        //     Notification::send($workloads, new PatientSendPacsNotification());
        // } catch (\Throwable $th) {
        //     Log::stack(['slack-notification-unread', 'daily'])->critical(__CLASS__, [
        //         'response' => $th
        //     ]);
        // }
    }
}
