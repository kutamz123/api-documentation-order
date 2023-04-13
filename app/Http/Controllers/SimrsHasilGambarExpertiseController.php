<?php

namespace App\Http\Controllers;

use App\Study;
use App\RenameLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\API\FormatResponse;

class SimrsHasilGambarExpertiseController extends Controller
{

    public $serverPort;
    public $server;

    public function __construct()
    {
        if (isset($_SERVER['HTTPS'])) {
            $serverPort = 'https://' . $_SERVER['HTTP_HOST'];
            $server = 'https://' . $_SERVER['SERVER_NAME'];
        } else {
            $serverPort = 'http://' . $_SERVER['HTTP_HOST'];
            $server = 'http://' . $_SERVER['SERVER_NAME'];
        }

        $this->serverPort = $serverPort;
        $this->server = $server;
    }

    public function expertise($acc, $mrn)
    {
        $study = Study::where('accession_no', $acc)->whereRelation('patient', 'pat_id', $mrn)->first();
        $study_iuid = $study->study_iuid ?? 0;
        $status = Str::lower($study->workload->status ?? 0);

        $link = RenameLink::first();

        if (!$study) {
            echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                                title: 'Pasien belum bridging dengan simrs',
                                text:  '',
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        }, 10);
                        window.setTimeout(function(){
                            window.close();
                        }, 1300);
                    </script>";
            exit();
        } else if ($status == 'waiting') {
            echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                                title: 'Pasien belum diexpertise',
                                text:  '',
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        }, 10);
                        window.setTimeout(function(){
                            window.close();
                        }, 1300);
                    </script>";
            exit();
        } else if ($status == 'approved') {
            return redirect()->away("$this->server:8089/$link->link_simrs_expertise/radiology/pdf/expertise.php?uid={$study_iuid}");
        } else {
            echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                                title: 'Error',
                                text:  '',
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        }, 10);
                        window.setTimeout(function(){
                            window.close();
                        }, 1300);
                    </script>";
            exit();
        }
    }

    public function gambarDicom($acc, $mrn)
    {
        $study = Study::where('accession_no', $acc)->whereRelation('patient', 'pat_id', $mrn)->first();
        $study_iuid = $study->study_iuid ?? 0;

        $link = RenameLink::first();

        if (!$study) {
            echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                                title: 'Pasien belum bridging dengan simrs',
                                text:  '',
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        }, 10);
                        window.setTimeout(function(){
                            window.close();
                        }, 1300);
                    </script>";
            exit();
        } else if ($study) {
            return redirect()->away("$this->server:19898/$link->link_simrs_dicom/viewer.html?studyUID={$study_iuid}");
        } else {
            echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                                title: 'Error',
                                text:  '',
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        }, 10);
                        window.setTimeout(function(){
                            window.close();
                        }, 1300);
                    </script>";
            exit();
        }
    }

    public function jsonDicomExpertise($acc, $mrn)
    {
        $study = Study::with(['patient', 'workload'])->where('accession_no', $acc)->whereRelation('patient', 'pat_id', $mrn)->first();

        if (!$study) {
            return FormatResponse::error(null, 'Pasien belum bridging dengan simrs', 404);
        }

        return FormatResponse::success([
            'acc' => $study->accession_no,
            'mrn' => $study->patient->pat_id,
            'pat_name' => $study->patient->pat_name,
            'pat_sex' => $study->patient->pat_sex,
            'study_iuid' => $study->study_iuid,
            'mods_in_study' => $study->mods_in_study,
            'study_desc' => $study->study_desc_pacsio,
            'updated_time' => $study->updated_time,
            'status' => $study->workload->status,
            'approved_at' => $study->workload->approved_at,
            'fill' => html_entity_decode(strip_tags($study->workload->fill)),
            'link_dicom' =>  "{$this->serverPort}/simrs-dicom/{$acc}/{$mrn}",
        ], "Berhasil ditemukan", 200);
    }
}
