<?php

namespace App\Http\Controllers;

use App\Order;
use App\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\WorkloadExport;
use Illuminate\Support\Facades\Storage;

class LaravelExcelController extends Controller
{
    public $file;
    public $from_updated_time = "from_updated_time";
    public $to_updated_time = "to_updated_time";

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function formatDate($dateTime)
    {
        return $dateTime != null ? date("Y-m-d H:i", strtotime($dateTime)) : null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fileName($fromUpdatedTime, $toUpdatedTime)
    {
        return date('d-m-Y', strtotime($fromUpdatedTime)) . 'sd' . date('d-m-Y', strtotime($toUpdatedTime)) . '.xlsx';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeExport(Request $request)
    {
        // input From updated time
        $fromUpdatedTime = $request->input($this->from_updated_time);
        $fromUpdatedTime = $this->formatDate($fromUpdatedTime);

        // input To updated time
        $toUpdatedTime = $request->input($this->to_updated_time);
        $toUpdatedTime = $this->formatDate($toUpdatedTime);

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

        $allFiles = Storage::allFiles("public/excel");
        // dd($allFiles);
        foreach ($allFiles as $file) {
            $tanggal = gmdate("Y-m-d", Storage::lastModified($file));
            // dd();
            if ($tanggal < date("Y-m-d")) {
                Storage::delete($file);
            }
        }

        $file = $this->fileName($fromUpdatedTime, $toUpdatedTime);

        $modsInStudy = Str::of($modsInStudy)->explode(',');
        $priorityDoctor = Str::of($priorityDoctor)->explode(',');
        // $radiographerName = Str::of($radiographerName)->explode(',');
        dd($radiographerName);

        $count = Patient::downloadExcel($fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName)
            ->count();

        if ($count > 0) {
            $message = (new WorkloadExport($fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName))
                ->queue("public/excel/" . $file)
                // ->onQueue("excel")
                ->chain([]);

            $response = [
                "code" => 200,
                "message" => $message
            ];
        } else {
            $response = [
                "code" => 404,
                "message" => "Data tidak ditemukan"
            ];
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function progressExport(Request $request)
    {
        // input From updated time
        $fromUpdatedTime = $request->input($this->from_updated_time);
        $fromUpdatedTime = $this->formatDate($fromUpdatedTime);

        // input To updated time
        $toUpdatedTime = $request->input($this->to_updated_time);
        $toUpdatedTime = $this->formatDate($toUpdatedTime);

        $file = $this->fileName($fromUpdatedTime, $toUpdatedTime);
        $exists = Storage::exists("public/excel/" . $file);

        if ($exists) {
            $response = 200;
        } else {
            $response = 404;
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadExport(Request $request)
    {
        // input From updated time
        $fromUpdatedTime = $request->input($this->from_updated_time);
        $fromUpdatedTime = $this->formatDate($fromUpdatedTime);

        // input To updated time
        $toUpdatedTime = $request->input($this->to_updated_time);
        $toUpdatedTime = $this->formatDate($toUpdatedTime);

        $file = $this->fileName($fromUpdatedTime, $toUpdatedTime);

        $exists = Storage::exists("public/excel/" . $file);

        if ($exists) {
            $response = [
                "code" => 200,
                "message" => asset("storage/excel/" . $file)
            ];
        } else {
            $response = [
                "code" => 404,
                "message" => "File tidak ditemukan"
            ];
        }

        return $response;
    }
}
