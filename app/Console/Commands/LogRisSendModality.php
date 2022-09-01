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
    protected $signature = 'log:ris-modality {protocol*}';

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
        $protocol = $this->arguments();

        // mengubah protocol array menjadi text
        $stringProtocol = implode(' ', $protocol['protocol']);

        // membuat array berdasarkan inputan protocol
        $arrayProtocol = explode('protocol', $stringProtocol);

        // ambil text date
        $date = $arrayProtocol[0] ?? null;

        // ambil text request
        $request =  isset($arrayProtocol[1]) ? $date . $arrayProtocol[1] : null;

        // ambil text response
        $response =  isset($arrayProtocol[2]) ? $date . $arrayProtocol[2] : null;

        LogWarningJob::dispatch($request, $response);
    }
}
