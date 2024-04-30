<?php

namespace App\Console\Commands;

use App\Study;
use App\DicomRouter;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendDicomRouterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'satu-sehat:dicom-router';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send dicom to dicom router';

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
        Study::doesntHave('dicomRouter')
            ->where('updated_time', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 DAY)'))
            ->get()
            ->contains(function ($data) {
                $request = new Request([
                    'accession_no' => $data->accession_no,
                    'study_iuid' => $data->study_iuid
                ]);

                $inputcd = 'cd C:\dcmsyst\tool-2.0.26\bin &&';
                $inputdcm = ' dcmqr dcmPACS@127.0.0.1:11118 -qStudyInstanceUID=' . $request->study_iuid . ' -cmove ' . 'DCMROUTER';
                $input = $inputcd . $inputdcm;
                exec($input, $output);

                DicomRouter::create([
                    "uid" => $request->study_iuid,
                    "acc" => $request->accession_no,
                    "request" => $input,
                    "response" => json_encode($output, true)
                ]);
            });
    }
}
