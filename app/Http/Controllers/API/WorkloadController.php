<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Workload;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkloadExport;
use App\Http\Controllers\API\FormatResponse;
use App\Order;
use App\Patient;
use App\Radiographer;
use App\Study;
use App\WorkloadBHP;

class WorkloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workload = Workload::paginate();
        return FormatResponse::success($workload, "Berhasil menampilkan data", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workload = workload::where("uid", $id)->first();

        if (!$workload) {
            return FormatResponse::error(NULL, "uid tidak ditemukan", 404);
        }

        return FormatResponse::success($workload, "Berhasil menampilkan data", 200);
    }


    public function update($uid, Request $request)
    {
        DB::transaction(function () use ($uid, $request) {

            Order::withoutEvents(function () use ($uid, $request) {
                Order::updateOrCreate(
                    [
                        'uid' => $uid
                    ],
                    [
                        'patientid' => $request->no_foto,
                        'address' => $request->address,
                        'weight' => $request->weight,
                        'dep_id' => $request->dep_id,
                        'name_dep' => $request->name_dep,
                        'named' => $request->named,
                        'radiographer_name' => $request->radiographer_name,
                        'contrast' => $request->contrast,
                        'priority' => $request->priority,
                        'pat_state' => $request->pat_state,
                        'contrast_allergies' => $request->contrast_allergies,
                        'spc_needs' => $request->spc_needs,
                        'payment' => $request->payment,
                    ]
                );
            });

            WorkloadBHP::updateOrCreate(
                [
                    'uid' => $uid
                ],
                [
                    'film_small' => $request->film_small,
                    'film_medium' => $request->film_medium,
                    'film_large' => $request->film_large,
                    'film_reject_small' => $request->film_reject_small,
                    'film_reject_medium' => $request->film_reject_medium,
                    'film_reject_large' => $request->film_reject_large,
                    're_photo' => $request->re_photo,
                    'kv' => $request->kv,
                    'mas' => $request->mas,
                ]
            );

            Study::where('study_iuid', $uid)
                ->update([
                    'accession_no' => $request->accession_no
                ]);

            $study = Study::where('study_iuid', $uid)->first();

            $study->patient()->update([
                'pat_id' => $request->pat_id,
                'pat_name' => $request->pat_name,
                'pat_birthdate' => date('Ymd', strtotime($request->pat_birthdate)),
                'pat_sex' => $request->pat_sex,
            ]);
        });

        return response()->json('Berhasil!', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadExcel(Request $request)
    {
        // input From updated time
        $fromUpdatedTime = $request->input('from_updated_time');
        $fromUpdatedTime = $fromUpdatedTime != null ? date("Y-m-d H:i", strtotime($fromUpdatedTime)) : null;

        // input To updated time
        $toUpdatedTime = $request->input('to_updated_time');
        $toUpdatedTime = $toUpdatedTime != null ? date("Y-m-d H:i", strtotime($toUpdatedTime)) : null;

        // input modsInStudy
        $modsInStudy = $request->input('mods_in_study');
        if ($modsInStudy != null) {
            $modsInStudy = Str::of($modsInStudy)->replace(" ", "");
        } else {
            $modsInStudy = null;
        }

        // input priorityDoctor
        $priorityDoctor = $request->input('priority_doctor');
        if ($priorityDoctor != null) {
            $priorityDoctor = Str::of($priorityDoctor)->replace(" ", "");
        } else {
            $priorityDoctor = null;
        }

        // input radiographerName
        $radiographerAll = [];
        $radiographerID = $request->input('radiographer_id');

        if ($radiographerID != null) {

            $radiographerID = Str::of($radiographerID)->replace(" ", "");

            if ($radiographerID == 'all') {
                foreach (Radiographer::all() as $radiographer) {
                    $radiographerAll[] = $radiographer->radiographer_id;
                    $radiographerID = implode(',', $radiographerAll);
                }
            }
        } else {
            $radiographerID = null;
        }

        $file =  date('d-m-Y H:i', strtotime($fromUpdatedTime)) . ' sd ' . date('d-m-Y H:i', strtotime($toUpdatedTime)) . '.xlsx';

        return (new WorkloadExport($fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID))->download($file);
    }
}
