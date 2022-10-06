<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\WorkloadRadiographer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkloadRadiographerExport;
use App\Http\Controllers\API\FormatResponse;
use App\Radiographer;

class WorkloadRadiographerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workloadRadiographer = WorkloadRadiographer::paginate();
        return FormatResponse::success($workloadRadiographer, "Berhasil menampilkan data", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workloadRadiographer = WorkloadRadiographer::where("uid", $id)->first();

        if (!$workloadRadiographer) {
            return FormatResponse::error(NULL, "uid tidak ditemukan", 404);
        }

        return FormatResponse::success($workloadRadiographer, "Berhasil menampilkan data", 200);
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

        // input xrayTypeCode
        $xrayTypeCode = $request->input('xray_type_code');
        if ($xrayTypeCode != null) {
            $xrayTypeCode = Str::of($xrayTypeCode)->replace(" ", "");
        } else {
            $xrayTypeCode = null;
        }

        // input patienttype
        $patienttype = $request->input('patienttype');
        if ($patienttype != null) {
            $patienttype = Str::of($patienttype)->replace(" ", "");
        } else {
            $patienttype = null;
        }

        // input radiographerName
        $radiographerAll = [];
        $radiographerName = $request->input('radiographer_name');

        if ($radiographerName != null) {

            $radiographerName = Str::of($radiographerName)->replace(" ", "");

            if ($radiographerName == 'all') {
                foreach (Radiographer::all() as $radiographer) {
                    $radiographerAll[] = $radiographer->radiographer_name;
                    $radiographerName = implode(',', $radiographerAll);
                }
            }
        } else {
            $radiographerName = null;
        }

        $file =  date('d-m-Y H:i', strtotime($fromUpdatedTime)) . ' sd ' . date('d-m-Y H:i', strtotime($toUpdatedTime)) . '.xlsx';

        return (new WorkloadRadiographerExport($fromUpdatedTime, $toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName))->download($file);
    }
}
