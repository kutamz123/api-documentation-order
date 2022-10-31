<?php

namespace App\Exports\Sheets;

use App\Patient;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkloadStatusSheet implements FromView, WithStyles, ShouldAutoSize, WithTitle
{
    protected $fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID, $detail;

    public function __construct($fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID, $detail)
    {
        $this->fromUpdatedTime = $fromUpdatedTime;
        $this->toUpdatedTime = $toUpdatedTime;
        $this->modsInStudy = $modsInStudy;
        $this->priorityDoctor = $priorityDoctor;
        $this->radiographerID = $radiographerID;
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
        $modsInStudy = Str::of($this->modsInStudy)->explode(',');
        $modsInStudyImplode = $modsInStudy->implode("','");

        $priorityDoctor = Str::of($this->priorityDoctor)->explode(',');
        $priorityDoctorImplode = $priorityDoctor->implode("','");

        $radiographerID = Str::of($this->radiographerID)->explode(',');
        $radiographerIDImplode = $radiographerID->implode("','");

        $totalApproved = Patient::select('approved_at')
            ->where('status', 'approved')
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID)
            ->count();

        $totalStatus = Patient::select('status')
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID)
            ->count();

        $approved = Patient::selectRaw("SUM((SELECT TIMESTAMPDIFF(MINUTE, study.updated_time, CONCAT(approved_at)) <= 180)) AS less_than_three_hour")
            ->selectRaw("SUM((SELECT TIMESTAMPDIFF(MINUTE, study.updated_time, CONCAT(approved_at)) > 180)) AS greater_than_three_hour")
            ->selectRaw("
            (SUM((SELECT TIMESTAMPDIFF(MINUTE, study.updated_time, CONCAT(approved_at)) <= 180)) /
                ($totalApproved)
            ) * 100 AS persentase_less_than_three_hour")
            ->selectRaw("
            (SUM((SELECT TIMESTAMPDIFF(MINUTE, study.updated_time, CONCAT(approved_at)) > 180)) /
                ($totalApproved)
            ) * 100 AS persentase_greater_than_three_hour")
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID)
            ->where('status', 'approved')
            ->first();

        $statuses = Patient::selectRaw("status, COUNT(status) AS jumlah")
            ->selectRaw("
            COUNT(status) /
            ($totalStatus) * 100 AS persentase")
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID)
            ->groupBy('status')
            ->get();

        $sumWaiting = $statuses[0]['jumlah'] ?? 0;
        $sumApproved = $statuses[1]['jumlah'] ?? 0;
        $persentaseWaiting = $statuses[0]['persentase'] ?? 0;
        $persentaseApproved = $statuses[1]['persentase'] ?? 0;

        return view('excels.excel-status-sheet', [
            'persentase_waiting' => $persentaseWaiting,
            'persentase_approved' => $persentaseApproved,
            'sum_waiting' => $sumWaiting,
            'sum_approved' => $sumApproved,
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
        $statusWaiting->addCondition('"waiting"');
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
