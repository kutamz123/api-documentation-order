<?php

namespace App\Exports\Sheets;

use App\Patient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkloadPatientsSheet implements WithEvents, FromQuery, WithStyles, ShouldAutoSize, WithTitle, WithColumnWidths, WithHeadings, WithMapping
{

    protected $fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName, $detail, $columnHeaderStart, $rowHeaderStart, $rowBodyStart = 4;

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
        return "Tabel Pasien";
    }

    public function columnWidths(): array
    {
        return [
            'M' => 10,
            'P' => 10
        ];
    }

    public function map($patient): array
    {
        // static $number = 1;
        return [
            "=ROW()-3",
            $patient->pat_name,
            $patient->pat_id,
            $patient->pat_sex,
            $patient->patientid,
            $patient->radiographer_name,
            $patient->pat_birthdate,
            $patient->age,
            $patient->name_dep,
            $patient->mods_in_study,
            $patient->study_desc,
            $patient->film_small,
            $patient->film_medium,
            $patient->film_large,
            $patient->film_reject_small,
            $patient->film_reject_medium,
            $patient->film_reject_large,
            $patient->kv,
            $patient->mas,
            $patient->priority_doctor,
            $patient->payment,
            $patient->create_time,
            $patient->study_datetime,
            $patient->study_datetime,
            $patient->approved_at,
            $patient->spend_time,
            $patient->status,
        ];
    }

    public function headings(): array
    {
        return [
            [
                "No",
                "Nama Pasien",
                "No Rekam Medis",
                "Jenis Kelamin",
                "No Foto",
                "Nama Radiografer",
                "Tanggal Lahir",
                "Umur",
                "Ruangan",
                "Modality",
                "Pemeriksaan",
                "Film",
                "",
                "",
                "",
                "",
                "",
                "Exposed",
                "",
                "Status Pasien",
                "Pembayaran",
                "Waktu Pendaftaran Pasien",
                "Waktu Mulai Pemeriksaan",
                "Waktu Selesai Pemeriksaan",
                "Waktu Baca Pasien",
                "Menghabiskan Waktu",
                "Status Baca",
            ],
            [
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "Digunakan",
                "",
                "",
                "Gagal",
                "",
                "",
                "KV",
                "MAS",
            ],
            [
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "small",
                "medium",
                "large",
                "small",
                "medium",
                "large",
            ]
        ];
    }

    public function query()
    {
        DB::enableQueryLog();
        // inner join
        $patient = Patient::select(
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
            'kv',
            'mas',
            'priority_doctor',
            'status',
            'approved_at',
        )->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
            ->orderBy('study_datetime', 'desc');

        $patient->get();
        Log::error(__FILE__, ["error" => DB::getQueryLog()]);

        return $patient;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    // public function view(): View
    // {
    //     $modsInStudy = Str::of($this->modsInStudy)->explode(',');
    //     $priorityDoctor = Str::of($this->priorityDoctor)->explode(',');
    //     $radiographerName = Str::of($this->radiographerName)->explode(',');

    //     // menggunakan relationship
    //     // $datas = Patient::downloadExcelOrm($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
    //     //     ->orderBy('patient.study_datetime', 'desc')
    //     //     ->get();

    //     // inner join
    //     $datas = Patient::select(
    //         'pat_name',
    //         'pat_birthdate',
    //         'pat_sex',
    //         'pat_id',
    //         'patientid',
    //         'radiographer_name',
    //         'name_dep',
    //         'payment',
    //         'create_time',
    //         'mods_in_study',
    //         'study_desc',
    //         'study.updated_time',
    //         'study_datetime',
    //         'film_small',
    //         'film_medium',
    //         'film_large',
    //         'film_reject_small',
    //         'film_reject_medium',
    //         'film_reject_large',
    //         'kv',
    //         'mas',
    //         'priority_doctor',
    //         'status',
    //         'approved_at',
    //     )->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
    //         ->orderBy('study_datetime', 'desc')
    //         ->get();

    //     $sum = Patient::selectRaw('SUM(film_reject_small) AS film_reject_small')
    //         ->selectRaw('SUM(film_reject_medium) AS film_reject_medium')
    //         ->selectRaw('SUM(film_reject_large) AS film_reject_large')
    //         ->selectRaw('SUM(film_small) AS film_small')
    //         ->selectRaw('SUM(film_medium) AS film_medium')
    //         ->selectRaw('SUM(film_large) AS film_large')
    //         ->downloadExcel($this->fromUpdatedTime, $this->toUpdatedTime, $this->modsInStudy, $this->priorityDoctor, $this->radiographerName)
    //         ->first();

    //     return view('excels.excel-patients-sheet', [
    //         'datas' => $datas,
    //         'sum' => $sum,
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

        // untuk mengatur tab sheets color red
        $sheet->getTabColor()->setRGB("FF0000");

        // untuk autofilter pemeriksaan
        // $sheet->setAutoFilter("B6:B6");

        // freezepane (fix header scroll)
        $sheet->freezePane("D" . $this->rowBodyStart);

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
        $statusWaitingAndApproved = $sheet->getStyle($this->columnHeaderStart . $this->rowHeaderStart . ":" . $cellEndDatas)->getConditionalStyles();
        $statusWaitingAndApproved[] = $statusWaiting;
        $statusWaitingAndApproved[] = $statusApproved;

        $sheet->getStyle($this->columnHeaderStart . $this->rowHeaderStart . ":" . $cellEndDatas)->setConditionalStyles($statusWaitingAndApproved);

        // merge cell
        $marginHeader2 = $this->rowHeaderStart + 1;
        $marginHeader3 = $this->rowHeaderStart + 2;
        $sheet->mergeCells("A" . $this->rowHeaderStart . ":A" . $marginHeader3);
        $sheet->mergeCells("B" . $this->rowHeaderStart . ":B" . $marginHeader3);
        $sheet->mergeCells("C" . $this->rowHeaderStart . ":C" . $marginHeader3);
        $sheet->mergeCells("D" . $this->rowHeaderStart . ":D" . $marginHeader3);
        $sheet->mergeCells("E" . $this->rowHeaderStart . ":E" . $marginHeader3);
        $sheet->mergeCells("F" . $this->rowHeaderStart . ":F" . $marginHeader3);
        $sheet->mergeCells("G" . $this->rowHeaderStart . ":G" . $marginHeader3);
        $sheet->mergeCells("H" . $this->rowHeaderStart . ":H" . $marginHeader3);
        $sheet->mergeCells("I" . $this->rowHeaderStart . ":I" . $marginHeader3);
        $sheet->mergeCells("J" . $this->rowHeaderStart . ":J" . $marginHeader3);
        $sheet->mergeCells("K" . $this->rowHeaderStart . ":K" . $marginHeader3);

        // film
        $sheet->mergeCells("L" . $this->rowHeaderStart . ":Q" . $this->rowHeaderStart);
        $sheet->mergeCells("L" . $marginHeader2 . ":N" . $marginHeader2);
        $sheet->mergeCells("O" . $marginHeader2 . ":Q" . $marginHeader2);

        // expose
        $sheet->mergeCells("R" . $this->rowHeaderStart . ":S" . $this->rowHeaderStart);
        $sheet->mergeCells("R" . $marginHeader2 . ":R" . $marginHeader3);
        $sheet->mergeCells("S" . $marginHeader2 . ":S" . $marginHeader3);

        $sheet->mergeCells("T" . $this->rowHeaderStart . ":T" . $marginHeader3);
        $sheet->mergeCells("U" . $this->rowHeaderStart . ":U" . $marginHeader3);
        $sheet->mergeCells("V" . $this->rowHeaderStart . ":V" . $marginHeader3);
        $sheet->mergeCells("W" . $this->rowHeaderStart . ":W" . $marginHeader3);
        $sheet->mergeCells("X" . $this->rowHeaderStart . ":X" . $marginHeader3);
        $sheet->mergeCells("Y" . $this->rowHeaderStart . ":Y" . $marginHeader3);
        $sheet->mergeCells("Z" . $this->rowHeaderStart . ":Z" . $marginHeader3);
        $sheet->mergeCells("AA" . $this->rowHeaderStart . ":AA" . $marginHeader3);
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

                $filmSmallColumn = "L";
                $filmMediumColumn = "M";
                $filmLargeColumn = "N";
                $filmRejectSmallColumn = "O";
                $filmRejectMediumColumn = "P";
                $filmRejectLargeColumn = "Q";

                $event->sheet->setCellValue($filmSmallColumn . $cellLast, "=SUM(" . $filmSmallColumn . $this->rowBodyStart . ":" . $filmSmallColumn . $rowLast . ")");
                $event->sheet->setCellValue($filmMediumColumn . $cellLast, "=SUM(" . $filmMediumColumn . $this->rowBodyStart . ":" . $filmMediumColumn . $rowLast . ")");
                $event->sheet->setCellValue($filmLargeColumn . $cellLast, "=SUM(" . $filmLargeColumn . $this->rowBodyStart . ":" . $filmLargeColumn . $rowLast . ")");
                $event->sheet->setCellValue($filmRejectSmallColumn . $cellLast, "=SUM(" . $filmRejectSmallColumn . $this->rowBodyStart . ":" . $filmRejectSmallColumn . $rowLast . ")");
                $event->sheet->setCellValue($filmRejectMediumColumn . $cellLast, "=SUM(" . $filmRejectMediumColumn . $this->rowBodyStart . ":" . $filmRejectMediumColumn . $rowLast . ")");
                $event->sheet->setCellValue($filmRejectLargeColumn . $cellLast, "=SUM(" . $filmRejectLargeColumn . $this->rowBodyStart . ":" . $filmRejectLargeColumn . $rowLast . ")");
            }
        ];
    }
}
