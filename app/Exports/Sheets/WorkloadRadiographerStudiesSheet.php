<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Str;
use App\WorkloadRadiographer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkloadRadiographerStudiesSheet implements FromView, WithStyles, ShouldAutoSize, WithTitle
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
        return "Tabel Study";
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $xrayTypeCode = Str::of($this->xrayTypeCode)->explode(',');
        $patienttype = Str::of($this->patienttype)->explode(',');
        $radiographerName = Str::of($this->radiographerName)->explode(',');

        $studies = WorkloadRadiographer::select('prosedur')
            ->selectRaw('COUNT(*) AS jumlah')
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName)
            ->orderBy('prosedur', 'asc')
            ->groupBy('prosedur')
            ->get();

        $countStudies = WorkloadRadiographer::select('prosedur')
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName)
            ->count();

        return view('excels.excel-studies-sheet', [
            'studies' => $studies,
            'countStudies' => $countStudies,
            'detail' => $this->detail
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $startCell = "A";

        // number cell column sheet style header <thead> for #datas
        $cellStartHeaderDatas = $startCell . "6";
        $cellEndHeaderDatas =  $sheet->getHighestColumn() . "6";

        // number cell column sheet Style Body <tbody> for #datas
        $cellStartBodyDatas = $startCell . "7";
        $cellEndBodyDatas = $sheet->getHighestDataColumn() . $sheet->getHighestDataRow();

        // style untuk autofilter pemeriksaan
        $sheet->setAutoFilter("B6:B6");

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

        // freezepane (fix header scroll)
        $sheet->freezePane("A7");

        // untuk mengatur tab sheets color red
        $sheet->getTabColor()->setRGB("2986cc");

        // untuk mengatur height masing-masing cell
        for ($i = 6; $i <= $sheet->getHighestDataRow(); $i++) {
            $sheet->getRowDimension($i)->setRowHeight(50, "px");
        }
    }
}
