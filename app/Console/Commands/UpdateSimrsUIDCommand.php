<?php

namespace App\Console\Commands;

use App\Study;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\OrderController;

class UpdateSimrsUIDCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simrs:update-uid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update uid to simrs and detail patient if patient manual';

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
        Study::doesntHave('order')
            ->where('updated_time', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 2 DAY)'))
            ->get()
            ->contains(function ($data) {
                $request = new Request([
                    'accession_no' => $data->accession_no,
                    'pat_id' => $data->patient->pat_id,
                    'study_iuid' => $data->study_iuid,
                    'mods_in_study' => $data->mods_in_study
                ]);
                (new OrderController($request))->validationUpdateSimrs($request);
            });
    }
}
