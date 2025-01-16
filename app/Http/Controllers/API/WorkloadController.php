<?php

namespace App\Http\Controllers\API;

use App\Order;
use App\Study;
use App\Dokter;
use App\Workload;
use App\Department;
use App\WorkloadBHP;
use App\Radiographer;
use App\PaymentInsurance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
                $department = Department::where('dep_id', $request->dep_id)->first();
                $dokter = Dokter::where('dokterid', $request->dokterid)->first();
                $radiographer = Radiographer::where('radiographer_id', $request->radiographer_id)->first();
                $payment = PaymentInsurance::where('id_payment', $request->id_payment)->first();
                $harga_prosedur = str_replace(',', '', $request->harga_prosedur);
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
                        'radiographer_name' => $radiographer->radiographer_name . ' ' . $radiographer->radiographer_lastname,
                        'contrast' => $request->contrast,
                        'priority' => $request->priority,
                        'harga_prosedur' => $harga_prosedur,
                        'contrast_allergies' => $request->contrast_allergies,
                        'spc_needs' => $request->spc_needs,
                        'id_payment' => $request->id_payment,
                        'payment' => $payment->payment,
                    ]
                );
            });

            Workload::updateOrCreate(
                [
                    'uid' => $uid
                ],
                [
                    'accession_no' => $request->accession_no,
                    'study_desc_pacsio' => $request->study_desc_pacsio
                ]
            );

            WorkloadBHP::updateOrCreate(
                [
                    'uid' => $uid
                ],
                [
                    'acc' => $request->accession_no,
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
                    'accession_no' => $request->accession_no,
                    'study_desc' => $request->study_desc_pacsio
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
}
