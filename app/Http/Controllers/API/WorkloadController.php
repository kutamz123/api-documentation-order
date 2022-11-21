<?php

namespace App\Http\Controllers\API;

use App\Department;
use App\Order;
use App\Study;
use App\Dokter;
use App\Patient;
use App\Workload;
use App\WorkloadBHP;
use App\Radiographer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\WorkloadExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\API\FormatResponse;

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
                $radiographer = Radiographer::where('radiographer_id', $request->radiographer_id)->first();
                $dokter = Dokter::where('dokterid', $request->dokterid)->first();
                $department = Department::where('dep_id', $request->dep_id)->first();
                Order::updateOrCreate(
                    [
                        'uid' => $uid
                    ],
                    [
                        'patientid' => $request->no_foto,
                        'address' => $request->address,
                        'weight' => $request->weight,
                        'dep_id' => $request->dep_id,
                        'name_dep' => $department->name_dep,
                        'dokterid' => $request->dokterid,
                        'named' => $dokter->named,
                        'radiographer_id' => $request->radiographer_id,
                        'radiographer_name' => $radiographer->radiographer_name,
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

    public function chart(Request $request)
    {
        $from = $request->input('from');
        $from = $from != null ? date("Y-m-d 00:00:00", strtotime($from)) : null;
        $to = $request->input('to');
        $to = $to != null ? date("Y-m-d 23:59:59", strtotime($to)) : null;
        $modsInStudy = $request->input('mods_in_study');
        $modsInStudy != null ? $modsInStudy = Str::of($modsInStudy)->replace(" ", "") : $modsInStudy = null;

        $total = Study::selectRaw('mods_in_study, COUNT(mods_in_study) AS total')
            ->whereBetween('study_datetime', [$from, $to])
            ->whereIn('mods_in_study', $modsInStudy->explode(','))
            ->groupBy('mods_in_study')
            ->get();

        $chart = Study::with(['patient'])
            ->whereBetween('study_datetime', [$from, $to])
            ->whereIn('mods_in_study', $modsInStudy->explode(','))
            ->groupBy('mods_in_study')
            ->get();

        return response()->json($total, 200);
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
        $fromUpdatedTime = $request->input('from_study_datetime');
        $fromUpdatedTime = $fromUpdatedTime != null ? date("Y-m-d H:i", strtotime($fromUpdatedTime)) : null;

        // input To updated time
        $toUpdatedTime = $request->input('to_study_datetime');
        $toUpdatedTime = $toUpdatedTime != null ? date("Y-m-d H:i", strtotime($toUpdatedTime)) : null;

        // input modsInStudy
        $modsInStudy = $request->input('mods_in_study');
        $modsInStudy != null ? $modsInStudy = Str::of($modsInStudy)->replace(" ", "") : $modsInStudy = null;

        // input priorityDoctor
        $priorityDoctor = $request->input('priority_doctor');
        $priorityDoctor != null ? $priorityDoctor = Str::of($priorityDoctor)->replace(" ", "") : $priorityDoctor = null;

        // input radiographerName
        $radiographerAll = [];
        $radiographerName = $request->input('radiographer_name');

        if ($radiographerName != null) {

            $radiographerName = Str::of($radiographerName)->replace(" ", "");

            if ($radiographerName == 'all') {
                foreach (Order::whereNotNull('radiographer_name')->groupBy('radiographer_name')->get() as $radiographer) {
                    $radiographerAll[] = $radiographer->radiographer_name;
                    $radiographerName = implode(',', $radiographerAll);
                }
            }
        } else {
            $radiographerName = null;
        }

        $file =  date('d-m-Y H:i', strtotime($fromUpdatedTime)) . ' sd ' . date('d-m-Y H:i', strtotime($toUpdatedTime)) . '.xlsx';

        return (new WorkloadExport($fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName))->download($file);
    }
}
