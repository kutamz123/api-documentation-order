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
use App\Radiographer;

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
