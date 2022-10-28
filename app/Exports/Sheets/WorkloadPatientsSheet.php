<?php

namespace App\Exports\Sheets;

use App\Patient;
use Illuminate\Support\Str;
use App\Workload;
use App\WorkloadBHP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkloadPatientsSheet implements FromView, WithStyles, ShouldAutoSize, WithTitle, WithColumnWidths
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
        return "Tabel Pasien";
    }

    public function columnWidths(): array
    {
        return [
            'M' => 10,
            'P' => 10
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $modsInStudy = Str::of($this->modsInStudy)->explode(',');
        $priorityDoctor = Str::of($this->priorityDoctor)->explode(',');
        $radiographerID = Str::of($this->radiographerID)->explode(',');

        $datas = Patient::select(
            'pat_name',
            'pat_birthdate',
            'pat_sex',
            'pat_id',
            'patientid',
            'radiographer_name',
            'name_dep',
            'payment',
            'create_time',
            'mods_in_study',
            'study_desc',
            'study.updated_time',
            'study_datetime',
            'film_small',
            'film_medium',
            'film_large',
            'film_reject_small',
            'film_reject_medium',
            'film_reject_large',
            'priority_doctor',
            'status',
            'approved_at',
        )->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID)
            ->get();

        $sum = Patient::selectRaw('SUM(film_reject_small) AS film_reject_small')
            ->selectRaw('SUM(film_reject_medium) AS film_reject_medium')
            ->selectRaw('SUM(film_reject_large) AS film_reject_large')
            ->selectRaw('SUM(film_small) AS film_small')
            ->selectRaw('SUM(film_medium) AS film_medium')
            ->selectRaw('SUM(film_large) AS film_large')
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID)
            ->first();

        return view('excels.excel-patients-sheet', [
            'datas' => $datas,
            'sum' => $sum,
            'detail' => $this->detail
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $startCell = "A";

        // number cell column sheet style header <thead> for #datas
        $cellStartHeaderDatas = $startCell . "6";
        $cellEndHeaderDatas =  $sheet->getHighestColumn() . "8";

        // number cell column sheet Style Body <tbody> for #datas
        $cellStartBodyDatas = $startCell . "9";
        $cellEndBodyDatas = $sheet->getHighestDataColumn() . $sheet->getHighestDataRow();

        // style untuk autofilter pemeriksaan
        $sheet->setAutoFilter("J6:J6");

        // style untuk autofilter jenis kelamin
        $sheet->setAutoFilter("C6:C6");

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

        // untuk mengatur tab sheets color red
        $sheet->getTabColor()->setRGB("FF0000");

        // untuk mengatur height masing-masing cell
        for ($i = 9; $i <= $sheet->getHighestDataRow(); $i++) {
            $sheet->getRowDimension($i)->setRowHeight(50, "px");
        }

        // freezepane (fix header scroll)
        $sheet->freezePane("A9");

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

        // Jenis Kelamin Female color red -> conditional formatting
        $sexFemale = new Conditional();
        $sexFemale->setConditionType(Conditional::CONDITION_CELLIS);
        $sexFemale->setOperatorType(Conditional::OPERATOR_EQUAL);
        $sexFemale->addCondition('"F"');
        $sexFemale->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_RED);
        $sexFemale->getStyle()->getFont()->setBold(true);

        // Jenis Kelamin Male color blue -> conditional formatting
        $sexMale = new Conditional();
        $sexMale->setConditionType(Conditional::CONDITION_CELLIS);
        $sexMale->setOperatorType(Conditional::OPERATOR_EQUAL);
        $sexMale->addCondition('"M"');
        $sexMale->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_BLUE);
        $sexMale->getStyle()->getFont()->setBold(true);

        // set and get conditional formatting status
        $sexFemaleMale = $sheet->getStyle($cellStartBodyDatas . ":" . $cellEndBodyDatas)->getConditionalStyles();
        $sexFemaleMale[] = $sexFemale;
        $sexFemaleMale[] = $sexMale;

        $sheet->getStyle($cellStartBodyDatas . ":" . $cellEndBodyDatas)->setConditionalStyles($sexFemaleMale);
    }
}
