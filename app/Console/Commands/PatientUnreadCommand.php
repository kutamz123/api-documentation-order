<?php

namespace App\Console\Commands;

use App\Workload;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PatientUnreadNotification;
use Illuminate\Support\Facades\Log;

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
        $workloads = Workload::with(["study.patient"])->where('status', 'waiting')
            ->where('study_datetime_pacsio', '<', DB::raw('DATE_SUB(NOW(), INTERVAL 2 HOUR)'))
            ->doesntHave('notificationUnreads')
            ->get();

        Notification::send($workloads, new PatientUnreadNotification());
    }
}
