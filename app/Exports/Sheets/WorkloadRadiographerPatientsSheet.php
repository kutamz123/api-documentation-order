<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Str;
use App\WorkloadRadiographer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkloadRadiographerPatientsSheet implements FromView, WithStyles, ShouldAutoSize, WithTitle
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
        return "Tabel Pasien";
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $xrayTypeCode = Str::of($this->xrayTypeCode)->explode(',');
        $patienttype = Str::of($this->patienttype)->explode(',');
        $radiographerName = Str::of($this->radiographerName)->explode(',');

        $datas = WorkloadRadiographer::downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName)
            ->orderBy('updated_time', 'desc')
            ->get();

        $sum = WorkloadRadiographer::selectRaw('SUM(filmsize8) AS filmsize8')
            ->selectRaw('SUM(filmsize10) AS filmsize10')
            ->selectRaw('SUM(filmreject8) AS filmreject8')
            ->selectRaw('SUM(filmreject10) AS filmreject10')
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName)
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
