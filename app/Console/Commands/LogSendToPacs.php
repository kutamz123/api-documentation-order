<?php

namespace App\Console\Commands;

use App\Patient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LogSendToPacs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:send-pacs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Log Slack For Send To Pacs';

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
        Patient::with(['study'])->where('pat_custom2', '1')->get()
            ->contains(function ($data) {
                Log::channel('slack-success')->info('Send To Pacs', [
                    'response' => [
                        'uid' => $data->study->study_iuid,
                        'name' => $data->pat_name,
                        'patient_id' => $data->pat_id,
                        'modality' => $data->study->mods_in_study,
                        'prosedur' => $data->study->study_desc
                    ]
                ]);
                $this->info($data->study->study_iuid . ' Success Send Log Slack From Modality To Pacs');
            });
    }
}
