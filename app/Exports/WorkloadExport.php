<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\WorkloadStatusSheet;
use App\Exports\Sheets\WorkloadStudiesSheet;
use App\Exports\Sheets\WorkloadPatientsSheet;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Style\Style;

class WorkloadExport implements WithProperties, ShouldAutoSize, WithMultipleSheets, WithDefaultStyles
{
    use Exportable;

    // http://127.0.0.1:8000/api/store-export-excel?from_updated_time=2019-01-09%2000:00&to_updated_time=2022-09-09%2018:10&mods_in_study=CR,PX,CT,DX&priority_doctor=normal,cito&radiographer_name=52,%2053,%2054,%2055,%2056,%2057

    protected $fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName, $detail, $columnHeaderStart = "A", $rowHeaderStart = 1;

    public function __construct($fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName)
    {
        $this->fromUpdatedTime = $fromUpdatedTime;
        $this->toUpdatedTime = $toUpdatedTime;
        $this->modsInStudy = $modsInStudy;
        $this->priorityDoctor = $priorityDoctor;
        $this->radiographerName = $radiographerName;
        $this->detail = [
            'fromUpdatedTime' => date('d-m-Y H:i', strtotime($this->fromUpdatedTime)),
            'toUpdatedTime' => date('d-m-Y H:i', strtotime($this->toUpdatedTime)),
            'modsInStudy' => $this->modsInStudy,
            'priorityDoctor' => $this->priorityDoctor,
            'radiographerName' => $this->radiographerName,
            'dateNow' => date('d-m-Y H:i', strtotime(NOW()))
        ];
    }

    public function sheets(): array
    {
        return [
            new WorkloadPatientsSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName, $this->detail, $this->columnHeaderStart, $this->rowHeaderStart),
            new WorkloadStudiesSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName, $this->detail, $this->columnHeaderStart, $this->rowHeaderStart),
            new WorkloadStatusSheet($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName, $this->detail, $this->columnHeaderStart, $this->rowHeaderStart)
        ];
    }

    public function properties(): array
    {
        return [
            'creator' => 'Andika Utama',
            'title' => 'Laporan Radiologi',
            'description' => 'Laporan radiologi untuk manajemen RS dengan Hasil output excel',
            'company' => ''
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return [
            'font' => [
                'name' => 'Calibri',
                'size' => 8,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
                'wrapText' => true
            ],
        ];
    }
}
