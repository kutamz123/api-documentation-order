<?php

namespace App\Exports\Sheets;

use App\Patient;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkloadStudiesSheet implements WithEvents, FromQuery, WithStyles, ShouldAutoSize, WithTitle,  WithHeadings, WithMapping
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
        return "Tabel Study";
    }


    public function map($study): array
    {
        // set number
        static $number = 1;
        return [
            $number++,
            $study->study_desc,
            $study->jumlah
        ];
    }

    public function headings(): array
    {
        return [
            "No",
            "Pemeriksaan",
            "Jumlah"
        ];
    }

    public function query()
    {
        return Patient::selectRaw('UPPER(study_desc) AS study_desc')
            ->selectRaw('COUNT(*) AS jumlah')
            ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
            ->orderBy('study_desc', 'asc')
            ->groupByRaw('UPPER(study_desc)');

        // $countStudies = Patient::select('study_desc')
        //     ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
        //     ->count();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    // public function view(): View
    // {
    //     $modsInStudy = Str::of($this->modsInStudy)->explode(',');
    //     $priorityDoctor = Str::of($this->priorityDoctor)->explode(',');
    //     $radiographerName = Str::of($this->radiographerName)->explode(',');

    //     $studies = Patient::selectRaw('UPPER(study_desc) AS study_desc')
    //         ->selectRaw('COUNT(*) AS jumlah')
    //         ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
    //         ->orderBy('study_desc', 'asc')
    //         ->groupByRaw('UPPER(study_desc)')
    //         ->get();

    //     $countStudies = Patient::select('study_desc')
    //         ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
    //         ->count();

    //     return view('excels.excel-studies-sheet', [
    //         'studies' => $studies,
    //         'countStudies' => $countStudies,
    //         'detail' => $this->detail
    //     ]);
    // }

    public function styles(Worksheet $sheet)
    {
        // number cell column sheet style for #datas
        $cellEndDatas =  $sheet->getHighestColumn() . $sheet->getHighestDataRow();
        $sheet->getStyle($this->columnHeaderStart . $this->rowHeaderStart . ":" . $cellEndDatas)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin'
                ]
            ]
        ]);

        // untuk mengatur tab sheets color blue
        $sheet->getTabColor()->setRGB("2986cc");

        // style untuk autofilter pemeriksaan
        $sheet->setAutoFilter("B1:B1");

        // freezepane (fix header scroll)
        $sheet->freezePane("D" . $this->rowBodyStart);
    }

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
                $rowLast = $event->sheet->getDelegate()->getHighestRow();
                $cellLast = $rowLast + 1;

                $totalColumn = "B";
                $studyDescColumn = "C";

                $event->sheet->setCellValue($totalColumn . $cellLast, "Total");
                $event->sheet->setCellValue($studyDescColumn . $cellLast, "=SUM(" . $studyDescColumn . $this->rowBodyStart . ":" . $studyDescColumn . $rowLast . ")");
            }
        ];
    }
}
