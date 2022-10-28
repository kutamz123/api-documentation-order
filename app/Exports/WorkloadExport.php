<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\WorkloadStatusSheet;
use App\Exports\Sheets\WorkloadStudiesSheet;
use App\Exports\Sheets\WorkloadPatientsSheet;

class WorkloadExport implements WithProperties, ShouldAutoSize, WithMultipleSheets
{
    use Exportable;

    // http://127.0.0.1:8000/api/export-excel?from_updated_time=2019-01-09%2000:00&to_updated_time=2022-09-09%2018:10&mods_in_study=CR,PX,CT,DX&priority_doctor=normal&radiographer_id=52,%2053

    protected $fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID, $detail;

    public function __construct($fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID)
    {
        $this->fromUpdatedTime = $fromUpdatedTime;
        $this->toUpdatedTime = $toUpdatedTime;
        $this->modsInStudy = $modsInStudy;
        $this->priorityDoctor = $priorityDoctor;
        $this->radiographerID = $radiographerID;
        $this->detail = [
            'fromUpdatedTime' => date('d-m-Y H:i', strtotime($this->fromUpdatedTime)),
            'toUpdatedTime' => date('d-m-Y H:i', strtotime($this->toUpdatedTime)),
            'modsInStudy' => $this->modsInStudy,
            'priorityDoctor' => $this->priorityDoctor,
            'radiographerID' => $this->radiographerID,
            'dateNow' => date('d-m-Y H:i', strtotime(NOW()))
        ];
    }

    public function sheets(): array
    {
        return [
            new WorkloadPatientsSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerID, $this->detail),
            new WorkloadStudiesSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerID, $this->detail),
            new WorkloadStatusSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerID, $this->detail)
        ];
    }

    public function properties(): array
    {
        return [
            'creator' => 'Andika Utama',
            'title' => 'Laporan Radiologi',
            'description' => 'Laporan radiologi untuk manajemen RS dengan Hasil output excel',
            'company' => 'intiwid'
        ];
    }
}
