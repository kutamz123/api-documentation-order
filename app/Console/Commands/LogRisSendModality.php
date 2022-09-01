<?php

namespace App\Console\Commands;

use App\Jobs\LogWarningJob;
use Illuminate\Console\Command;

class LogRisSendModality extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:ris-modality {user*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log ris send to modality';

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
        $user = $this->arguments();
        $response = implode(" ", $user['user']);
        LogWarningJob::dispatch($response);
    }
}
