<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Str;
use App\WorkloadRadiographer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkloadRadiographerStatusSheet implements FromView, WithStyles, ShouldAutoSize, WithTitle
{
    protected $fromUpdatedTime, $toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName, $detail;

    public function __construct($fromUpdatedTime, $toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName, $detail)
    {
        $this->fromUpdatedTime = $fromUpdatedTime;
        $this->toUpdatedTime = $toUpdatedTime;
        $this->xrayTypeCode = $xrayTypeCode;
        $this->patienttype = $patienttype;
        $this->radiographerName = $radiographerName;
        $this->detail = $detail;
    }

    /**
     * @return string
     * mengatur for sheets
     */
    public function title(): string
    {
        return "Tabel Status";
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $xrayTypeCode = Str::of($this->xrayTypeCode)->explode(',');
        $xrayTypeCodeImplode = $xrayTypeCode->implode("','");

        $patienttype = Str::of($this->patienttype)->explode(',');
        $patienttypeImplode = $patienttype->implode("','");

        $radiographerName = Str::of($this->radiographerName)->explode(',');
        $radiographerNameImplode = $radiographerName->implode("','");

        $approved = WorkloadRadiographer::selectRaw("SUM((SELECT TIMESTAMPDIFF(MINUTE, updated_time, CONCAT(approve_date, ' ', approve_time)) <= 180)) AS less_than_three_hour")
            ->selectRaw("SUM((SELECT TIMESTAMPDIFF(MINUTE, updated_time, CONCAT(approve_date, ' ', approve_time)) > 180)) AS greater_than_three_hour")
            ->selectRaw("
            (SUM((SELECT TIMESTAMPDIFF(MINUTE, updated_time, CONCAT(approve_date, ' ', approve_time)) <= 180)) /
                (SELECT COUNT(approve_date) AS jumlah
                FROM xray_workload_radiographer
                WHERE status = 'approved'
                AND updated_time BETWEEN '$this->fromUpdatedTime' AND '$this->toUpdatedTime'
                AND xray_type_code IN('$xrayTypeCodeImplode')
                AND patienttype IN('$patienttypeImplode')
                AND radiographer_name IN('$radiographerNameImplode'))
            ) * 100 AS persentase_less_than_three_hour")
            ->selectRaw("
            (SUM((SELECT TIMESTAMPDIFF(MINUTE, updated_time, CONCAT(approve_date, ' ', approve_time)) > 180)) /
                (SELECT COUNT(approve_date) AS jumlah
                FROM xray_workload_radiographer
                WHERE status = 'approved'
                AND updated_time BETWEEN '$this->fromUpdatedTime' AND '$this->toUpdatedTime'
                AND xray_type_code IN('$xrayTypeCodeImplode')
                AND patienttype IN('$patienttypeImplode')
                AND radiographer_name IN('$radiographerNameImplode'))
            ) * 100 AS persentase_greater_than_three_hour")
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName)
            ->where('status', 'approved')
            ->first();

        $statuses = WorkloadRadiographer::selectRaw("status, COUNT(status) AS jumlah")
            ->selectRaw("
            COUNT(status) /
            (SELECT COUNT(status) AS total
                FROM xray_workload_radiographer
                WHERE updated_time BETWEEN '$this->fromUpdatedTime' AND '$this->toUpdatedTime'
                AND xray_type_code IN('$xrayTypeCodeImplode')
                AND patienttype IN('$patienttypeImplode')
                AND radiographer_name IN('$radiographerNameImplode')
            ) * 100 AS persentase")
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName)
            ->groupBy('status')
            ->get();

        return view('excels.excel-status-sheet', [
            'statuses' => $statuses,
            'approved' => $approved,
            'detail' => $this->detail
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $startCell = "A";
        $endCell = "F";

        // number cell column sheet style header <thead> for #datas
        $cellStartHeaderDatas = $startCell . "6";
        $cellEndHeaderDatas =   $endCell . "6";

        // number cell column sheet Style Body <tbody> for #datas
        $cellStartBodyDatas = $startCell . "7";
        $cellEndBodyDatas = $endCell . $sheet->getHighestDataRow();

        // style untuk autofilter pemeriksaan

        // variable untuk alignment
        $alignment =  [
            'horizontal' => 'center',
            'vertical' => 'center',
            'wrapText' => true
        ];

        // variable untuk fontname
        $fontName = 'Calibri';

        // Style Header <thead>
        $styleHeader = [
            'font' => [
                'bold' => true,
                'size' => 13,
                'name' => $fontName
            ], 'alignment' => $alignment,
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'medium'
                ]
            ]
        ];

        $sheet->getStyle($cellStartHeaderDatas . ":" . $cellEndHeaderDatas)->applyFromArray($styleHeader);

        // Style Body <tbody>
        $styleBody = [
            'font' => [
                'name' => $fontName
            ],
            'alignment' => $alignment,
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin'
                ]
            ]
        ];
        $sheet->getStyle($cellStartBodyDatas . ":" . $cellEndBodyDatas)->applyFromArray($styleBody);

        $sheet->getStyle("A8" . ":" . "C12")->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => 'medium'
                ]
            ]
        ]);

        $sheet->getStyle("D8" . ":" . "F12")->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => 'medium'
                ]
            ]
        ]);

        $sheet->getStyle("A7" . ":" . "F7")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'medium'
                ],
            ]
        ]);

        // untuk mengatur tab sheets color yellow
        $sheet->getTabColor()->setRGB("FFFF00");

        // untuk mengatur height masing-masing cell
        for ($i = 6; $i <= $sheet->getHighestDataRow(); $i++) {
            $sheet->getRowDimension($i)->setRowHeight(50, "px");
        }

        // status waiting color green -> conditional formatting
        $statusWaiting = new Conditional();
        $statusWaiting->setConditionType(Conditional::CONDITION_CELLIS);
        $statusWaiting->setOperatorType(Conditional::OPERATOR_EQUAL);
        $statusWaiting->addCondition('"ready to approve"');
        $statusWaiting->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_DARKGREEN);
        $statusWaiting->getStyle()->getFont()->setBold(true);

        // status approved color blue -> conditional formatting
        $statusApproved = new Conditional();
        $statusApproved->setConditionType(Conditional::CONDITION_CELLIS);
        $statusApproved->setOperatorType(Conditional::OPERATOR_EQUAL);
        $statusApproved->addCondition('"approved"');
        $statusApproved->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_DARKBLUE);
        $statusApproved->getStyle()->getFont()->setBold(true);

        // set and get conditional formatting status
        $statusWaitingAndApproved = $sheet->getStyle($cellStartBodyDatas . ":" . $cellEndBodyDatas)->getConditionalStyles();
        $statusWaitingAndApproved[] = $statusWaiting;
        $statusWaitingAndApproved[] = $statusApproved;

        $sheet->getStyle($cellStartBodyDatas . ":" . $cellEndBodyDatas)->setConditionalStyles($statusWaitingAndApproved);
    }
}
