<?php

namespace App\Console\Commands;

use App\Events\ModalityPacsEvent;
use App\Jobs\LogModalityPacsJob;
use App\Patient;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LogModalityPacsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:modality-pacs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Log Slack For Modality Send To Pacs';

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
        Patient::with(['study'])->where('pat_custom2', null)->get()
            ->contains(function ($data) {
                $response = [
                    'study iuid' => $data->study->study_iuid,
                    'Nomor Accession' => $data->study->accession_no,
                    'Nama' => $data->pat_name,
                    'Id Pasien' => $data->pat_id,
                    'Tanggal Lahir' => $data->pat_birthdate,
                    'Modalitas' => $data->study->mods_in_study,
                    'Pemeriksaan' => $data->study->study_desc,
                    'Waktu Selesai Pemeriksaan' => $data->updated_time
                ];

                $info = "{$data->study->mods_in_study} Sukses Terkirim Ke Pacs";

                ModalityPacsEvent::dispatch($info, $response);
            });
    }
}
