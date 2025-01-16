<?php

namespace App\Exports\Sheets;

use App\Patient;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkloadStatusSheet implements ShouldAutoSize, WithTitle, WithEvents
{
    protected $fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName, $detail, $columnHeaderStart, $rowHeaderStart, $rowBodyStart = 2;

    public function __construct($fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName, $detail, $columnHeaderStart, $rowHeaderStart)
    {
        $this->fromUpdatedTime = $fromUpdatedTime;
        $this->toUpdatedTime = $toUpdatedTime;
        $this->modsInStudy = $modsInStudy;
        $this->priorityDoctor = $priorityDoctor;
        $this->radiographerName = $radiographerName;
        $this->detail = $detail;
        $this->columnHeaderStart = $columnHeaderStart;
        $this->rowHeaderStart = $rowHeaderStart;
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
    // public function view(): View
    // {
    //     $modsInStudy = Str::of($this->modsInStudy)->explode(',');
    //     $modsInStudyImplode = $modsInStudy->implode("','");

    //     $priorityDoctor = Str::of($this->priorityDoctor)->explode(',');
    //     $priorityDoctorImplode = $priorityDoctor->implode("','");

    //     $radiographerName = Str::of($this->radiographerName)->explode(',');
    //     $radiographerNameImplode = $radiographerName->implode("','");

    //     $totalApproved = Patient::select('approved_at')
    //         ->where('status', 'approved')
    //         ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName)
    //         ->count();

    //     $totalStatus = Patient::select('status')
    //         ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName)
    //         ->count();

    //     $approved = Patient::selectRaw("SUM((SELECT TIMESTAMPDIFF(MINUTE, study.study_datetime, CONCAT(approved_at)) <= 180)) AS less_than_three_hour")
    //         ->selectRaw("SUM((SELECT TIMESTAMPDIFF(MINUTE, study.study_datetime, CONCAT(approved_at)) > 180)) AS greater_than_three_hour")
    //         ->selectRaw("
    //         (SUM((SELECT TIMESTAMPDIFF(MINUTE, study.study_datetime, CONCAT(approved_at)) <= 180)) /
    //             ($totalApproved)
    //         ) * 100 AS persentase_less_than_three_hour")
    //         ->selectRaw("
    //         (SUM((SELECT TIMESTAMPDIFF(MINUTE, study.study_datetime, CONCAT(approved_at)) > 180)) /
    //             ($totalApproved)
    //         ) * 100 AS persentase_greater_than_three_hour")
    //         ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName)
    //         ->where('status', 'approved')
    //         ->first();

    //     $statuses = Patient::selectRaw("status, COUNT(status) AS jumlah")
    //         ->selectRaw("
    //         COUNT(status) /
    //         ($totalStatus) * 100 AS persentase")
    //         ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName)
    //         ->groupBy('status')
    //         ->get();

    //     $sumWaiting = $statuses[0]['jumlah'] ?? 0;
    //     $sumApproved = $statuses[1]['jumlah'] ?? 0;
    //     $persentaseWaiting = $statuses[0]['persentase'] ?? 0;
    //     $persentaseApproved = $statuses[1]['persentase'] ?? 0;

    //     return view('excels.excel-status-sheet', [
    //         'persentase_waiting' => $persentaseWaiting,
    //         'persentase_approved' => $persentaseApproved,
    //         'sum_waiting' => $sumWaiting,
    //         'sum_approved' => $sumApproved,
    //         'statuses' => $statuses,
    //         'approved' => $approved,
    //         'detail' => $this->detail
    //     ]);
    // }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // register events menggunakan API phpspreadsheet yang mendasarinya laravel excel didasarkan pada paket ini

            AfterSheet::class => function (AfterSheet $event) {
                // $lastColumn = $event->sheet->getDelegate()->getHighestColumn();
                // $accessConstructorInput = $event->getConcernable();
                // $rowLast = $event->sheet->getDelegate()->getHighestRow();

                $totalApproved = Patient::select('approved_at')
                    ->where('status', 'approved')
                    ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
                    ->count();

                $totalStatus = Patient::select('status')
                    ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
                    ->count();

                $approved = Patient::selectRaw("SUM((SELECT TIMESTAMPDIFF(MINUTE, study.study_datetime, CONCAT(approved_at)) <= 180)) AS less_than_three_hour")
                    ->selectRaw("SUM((SELECT TIMESTAMPDIFF(MINUTE, study.study_datetime, CONCAT(approved_at)) > 180)) AS greater_than_three_hour")
                    ->selectRaw("
                    (SUM((SELECT TIMESTAMPDIFF(MINUTE, study.study_datetime, CONCAT(approved_at)) <= 180)) /
                        ($totalApproved)
                    ) * 100 AS persentase_less_than_three_hour")
                    ->selectRaw("
                    (SUM((SELECT TIMESTAMPDIFF(MINUTE, study.study_datetime, CONCAT(approved_at)) > 180)) /
                        ($totalApproved)
                    ) * 100 AS persentase_greater_than_three_hour")
                    ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
                    ->where('status', 'approved')
                    ->first();

                $statuses = Patient::selectRaw("status, COUNT(status) AS jumlah")
                    ->selectRaw("
                    COUNT(status) /
                    ($totalStatus) * 100 AS persentase")
                    ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
                    ->groupBy('status')
                    ->get();

                $sumWaiting = 0;
                $sumApproved = 0;
                $persentaseWaiting = 0;
                $persentaseApproved = 0;

                // $sumWaiting = $statuses[0]['jumlah'] ?? 0;
                // $sumApproved = $statuses[1]['jumlah'] ?? 0;
                // $persentaseWaiting = $statuses[0]['persentase'] ?? 0;
                // $persentaseApproved = $statuses[1]['persentase'] ?? 0;

                foreach ($statuses as $status) {
                    if ($status->status == 'APPROVED') {
                        $sumApproved = $status->jumlah;
                        $persentaseApproved = $status->persentase;
                    } else if ($status->status == 'WAITING') {
                        $sumWaiting = $status->jumlah;
                        $persentaseWaiting = $status->persentase;
                    }
                }

                $rowHeaderColumn2 = $this->rowHeaderStart + 1;
                $rowHeaderColumn3 = $rowHeaderColumn2 + 1;
                $rowKurang3jam = $rowHeaderColumn3 + 1;
                $rowLebih3jam = $rowKurang3jam + 1;
                $totalStudy = $rowLebih3jam + 1;
                $totalPersentase = $totalStudy + 1;

                $event->sheet->setCellValue($this->columnHeaderStart . $this->rowHeaderStart, "Waktu Tunggu");

                $event->sheet->setCellValue($this->columnHeaderStart . $rowHeaderColumn2, "Approved");
                $event->sheet->setCellValue("D" . $rowHeaderColumn2, "Waiting");

                $event->sheet->setCellValue($this->columnHeaderStart . $rowHeaderColumn3, "Status");
                $event->sheet->setCellValue("B" . $rowHeaderColumn3, "Study");
                $event->sheet->setCellValue("C" . $rowHeaderColumn3, "Persentase");
                $event->sheet->setCellValue("D" . $rowHeaderColumn3, "Study");

                $event->sheet->setCellValue($this->columnHeaderStart . $rowKurang3jam, "Kurang 3 Jam");
                $event->sheet->setCellValue("B" . $rowKurang3jam, $approved->less_than_three_hour);
                $event->sheet->setCellValue("C" . $rowKurang3jam, round($approved->persentase_less_than_three_hour, 2) . "%");
                $event->sheet->setCellValue("D" . $rowKurang3jam, $sumWaiting);

                $event->sheet->setCellValue($this->columnHeaderStart . $rowLebih3jam, "Lebih 3 Jam");
                $event->sheet->setCellValue("B" . $rowLebih3jam, $approved->greater_than_three_hour);
                $event->sheet->setCellValue("C" . $rowLebih3jam, round($approved->persentase_greater_than_three_hour, 2) . "%");

                $event->sheet->setCellValue($this->columnHeaderStart . $totalStudy, "Total Study");
                $event->sheet->setCellValue("B" . $totalStudy, $sumApproved);
                $event->sheet->setCellValue("D" . $totalStudy, $sumWaiting);

                $event->sheet->setCellValue($this->columnHeaderStart . $totalPersentase, "Total Persentase");
                $event->sheet->setCellValue("B" . $totalPersentase, round($persentaseApproved, 2) . "%");
                $event->sheet->setCellValue("D" . $totalPersentase, round($persentaseWaiting, 2) . "%");

                // number cell column sheet style for #datas
                $cellEndDatas =  $event->sheet->getHighestColumn() . $event->sheet->getHighestDataRow();
                $event->sheet->getStyle($this->columnHeaderStart . $this->rowHeaderStart . ":" . "F7")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin'
                        ]
                    ]
                ]);

                // $event->sheet->getStyle("D8" . ":" . "F12")->applyFromArray([
                //     'borders' => [
                //         'outline' => [
                //             'borderStyle' => 'medium'
                //         ]
                //     ]
                // ]);

                // $event->sheet->getStyle("A7" . ":" . "F7")->applyFromArray([
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => 'medium'
                //         ],
                //     ]
                // ]);

                // untuk mengatur tab sheets color yellow
                $event->sheet->getTabColor()->setRGB("FFFF00");

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
                $statusWaitingAndApproved = $event->sheet->getStyle($this->columnHeaderStart . $this->rowHeaderStart . ":" . $cellEndDatas)->getConditionalStyles();
                $statusWaitingAndApproved[] = $statusWaiting;
                $statusWaitingAndApproved[] = $statusApproved;

                $event->sheet->getStyle($this->columnHeaderStart . $this->rowHeaderStart . ":" . $cellEndDatas)->setConditionalStyles($statusWaitingAndApproved);

                // merge cell
                $marginHeader2 = $this->rowHeaderStart + 1;
                $marginHeader3 = $this->rowHeaderStart + 2;
                $marginHeader4 = $this->rowHeaderStart + 3;
                $marginHeader5 = $this->rowHeaderStart + 4;
                $marginHeader6 = $this->rowHeaderStart + 5;
                $marginHeader7 = $this->rowHeaderStart + 6;

                $event->sheet->mergeCells("A" . $this->rowHeaderStart . ":F" . $this->rowHeaderStart);

                $event->sheet->mergeCells("A" . $marginHeader2 . ":C" . $marginHeader2);
                $event->sheet->mergeCells("D" . $marginHeader2 . ":F" . $marginHeader2);

                $event->sheet->mergeCells("D" . $marginHeader3 . ":F" . $marginHeader3);

                $event->sheet->mergeCells("D" . $marginHeader4 . ":F" . $marginHeader5);

                $event->sheet->mergeCells("B" . $marginHeader6 . ":C" . $marginHeader6);
                $event->sheet->mergeCells("D" . $marginHeader6 . ":F" . $marginHeader6);

                $event->sheet->mergeCells("B" . $marginHeader7 . ":C" . $marginHeader7);
                $event->sheet->mergeCells("D" . $marginHeader7 . ":F" . $marginHeader7);
            }
        ];
    }
}
