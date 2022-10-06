<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\WorkloadRadiographerStatusSheet;
use App\Exports\Sheets\WorkloadRadiographerStudiesSheet;
use App\Exports\Sheets\WorkloadRadiographerPatientsSheet;

class WorkloadRadiographerExport implements WithProperties, ShouldAutoSize, WithMultipleSheets
{
    use Exportable;

    // http://127.0.0.1:8000/api/export-excel?from_updated_time=2019-01-09%2000:00&to_updated_time=2022-09-09%2018:10&xray_type_code=CR,PX,CT,DX&patienttype=normal&radiographer_name=KS,%20RA

    protected $fromUpdatedTime, $toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName, $detail;

    public function __construct($fromUpdatedTime, $toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName)
    {
        $this->fromUpdatedTime = $fromUpdatedTime;
        $this->toUpdatedTime = $toUpdatedTime;
        $this->xrayTypeCode = $xrayTypeCode;
        $this->patienttype = $patienttype;
        $this->radiographerName = $radiographerName;
        $this->detail = [
            'fromUpdatedTime' => date('d-m-Y H:i', strtotime($this->fromUpdatedTime)),
            'toUpdatedTime' => date('d-m-Y H:i', strtotime($this->toUpdatedTime)),
            'xrayTypeCode' => $this->xrayTypeCode,
            'patienttype' => $this->patienttype,
            'radiographerName' => $this->radiographerName,
            'dateNow' => date('d-m-Y H:i', strtotime(NOW()))
        ];
    }

    public function sheets(): array
    {
        return [
            new WorkloadRadiographerPatientsSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->xrayTypeCode, $this->patienttype, $this->radiographerName, $this->detail),
            new WorkloadRadiographerStudiesSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->xrayTypeCode, $this->patienttype, $this->radiographerName, $this->detail),
            new WorkloadRadiographerStatusSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->xrayTypeCode, $this->patienttype, $this->radiographerName, $this->detail)
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
