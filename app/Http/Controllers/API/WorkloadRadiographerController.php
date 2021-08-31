<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\WorkloadRadiographer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\FormatResponse;

class WorkloadRadiographerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workloadRadiographer = WorkloadRadiographer::all();
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
}
