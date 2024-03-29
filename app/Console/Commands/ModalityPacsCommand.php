<?php

namespace App\Console\Commands;

use App\Events\ModalityPacsEvent;
use App\Patient;
use Illuminate\Console\Command;

class ModalityPacsCommand extends Command
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
                    'Study Iuid' => $data->study->study_iuid,
                    'Accession No' => $data->study->accession_no,
                    'Nama' => $data->pat_name,
                    'Jenis Kelamin' => $data->pat_sex,
                    'MRN' => $data->pat_id,
                    'Tanggal Lahir' => $data->pat_birthdate,
                    'Modalitas' => $data->study->mods_in_study,
                    'Pemeriksaan' => $data->study->study_desc,
                    'Waktu Selesai Pemeriksaan' => $data->study->study_datetime
                ];

                $info = "{$data->study->mods_in_study} Sukses Terkirim Ke Pacs";

                ModalityPacsEvent::dispatch($info, $response);
            });
    }
}
