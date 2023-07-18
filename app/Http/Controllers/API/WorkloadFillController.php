<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Workload;
use App\WorkloadFill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkloadFillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pk = $request->pk;

        // mencari data di workload_fill
        $workloadFill = WorkloadFill::where('pk', $pk)->first();

        // mencari data approved_at di workload
        $approved_at = $workloadFill->workload->approved_at;

        // ketika approved at kosong (waiting) maka approved_at tanggal sekarang
        if ($approved_at == null or $approved_at == '-') {
            $approved_at = NOW();
        }

        DB::transaction(function () use ($workloadFill, $approved_at) {
            Workload::where('uid', $workloadFill->uid)->update([
                'fill' => $workloadFill->fill,
                'status' => 'approved',
                'approved_at' => date('Y-m-d H:i:s', strtotime($approved_at))
            ]);

            WorkloadFill::where('uid', $workloadFill->uid)->update([
                'is_default' => 0
            ]);

            WorkloadFill::where('pk', $workloadFill->pk)->update([
                'is_default' => 1,
                'updated_at' => NOW()
            ]);
        });

        return response()->json(['status' => 'Berhasil!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
