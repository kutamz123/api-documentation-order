<?php

namespace App\Observers;

use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function creating(Order $order)
    {
        $birthDate = new Carbon($order->birth_date);
        $birthDate = $birthDate->format("Ymd");
        $scheduleDateTime = new Carbon($order->schedule_date . ' ' . $order->schedule_time);
        $scheduleDate = $scheduleDateTime->format("Ymd");
        $scheduleTime = $scheduleDateTime->format("His");
        $radiographer_name = $order->radiographer_name ?? '-';
        $weight = $order->weight ?? 0;
        $contrast = $order->contrast ?? '-';
        $contrastAllergies = $order->contrast_allergies ?? '-';

        $spsId = DB::connection('mppsio')
            ->table('mwl_item')
            ->select('sps_id')
            ->orderBy('pk', 'desc')
            ->limit(1)
            ->value('sps_id');

        if ($spsId == null) {
            $spsId = 'SPS-xx3';
        }

        $replaceSpsId = Str::replace('SPS-xx', '', $spsId);
        $generatesps = $replaceSpsId + 1;

        $codevalue = 'PROT-2018';
        $procid = 'SPS-xx' . $generatesps;
        $rp = 'RP-00' . $generatesps;

        $xmlstr = <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <!DOCTYPE dataset [
            <!ELEMENT dataset (attr*)>
            <!ELEMENT attr (#PCDATA | item)*>
            <!ELEMENT item (#PCDATA | attr)*>
            <!ATTLIST attr tag CDATA #REQUIRED>
            ]>
            <dataset>
                <!-- Specific Character Set -->
                <attr tag="00080005">ISO_IR 192</attr>
                <!-- Scheduled Procedure Step Sequence -->
                <attr tag="00400100">
                    <item>
                        <!-- Scheduled Station AE Title -->
                        <attr tag="00400001">DCMPACS</attr>
                        <!-- Scheduled Procedure Step Start Date -->
                        <attr tag="00400002">$scheduleDate</attr>
                        <!-- Scheduled Procedure Step Start Time -->
                        <attr tag="00400003">$scheduleTime</attr>
                        <!-- Modality -->
                        <attr tag="00080060">$order->xray_type_code</attr>
                        <!-- Scheduled Performing Physician's Name -->
                        <attr tag="00400006">$radiographer_name</attr>
                        <!-- Scheduled Procedure Step Description -->
                        <attr tag="00400007">$order->prosedur</attr>
                        <!-- Scheduled Procedure Step Location -->
                        <attr tag="00400011">Scheduled Procedure Step Location</attr>
                        <!-- Scheduled Protocol Code Sequence -->
                        <attr tag="00400008">
                            <item>
                                <!-- Code Value -->
                                <attr tag="00080100">$codevalue</attr>
                                <!-- Coding Scheme Designator -->
                                <attr tag="00080102">DCM</attr>
                                <!-- Code Meaning -->
                                <attr tag="00080104">NA</attr>
                            </item>
                        </attr>
                        <!-- Pre-Medication -->
                        <attr tag="00400012">Pre-Medication</attr>
                        <!-- Scheduled Procedure Step ID -->
                        <attr tag="00400009">$procid</attr>
                        <!-- Requested Contrast Agent -->
                        <attr tag="00321070">$contrast</attr>
                        <!-- Scheduled Procedure Step Status -->
                        <attr tag="00400020">SCHEDULED</attr>
                    </item>
                </attr>
                <!-- Requested Procedure ID -->
                <attr tag="00401001">$rp</attr>
                <!-- Requested Procedure Description -->
                <attr tag="00321060">$order->prosedur</attr>
                <!-- Requested Procedure Code Sequence -->
                <attr tag="00321064">
                    <item>
                        <!-- Code Value -->
                        <attr tag="00080100">PROC-1205</attr>
                        <!-- Coding Scheme Designator -->
                        <attr tag="00080102">DCM</attr>
                        <!-- Code Meaning -->
                        <attr tag="00080104">$order->prosedur</attr>
                    </item>
                </attr>
                <!-- Study Instance UID -->
                <attr tag="0020000D">$order->uid</attr>
                <!-- Requested Procedure Priority -->
                <attr tag="00401003">$order->priority</attr>
                <!-- Accession Number -->
                <attr tag="00080050">$order->acc</attr>
                <!-- Requesting Physician -->
                <attr tag="00321032">$order->dokrad_name</attr>
                <!-- Requesting Service -->
                <attr tag="00321033">$order->name_dep</attr>
                <!-- Referring Physician's Name -->
                <attr tag="00080090">$order->named</attr>
                <!-- Admission ID -->
                <attr tag="00380010">ADM-1234</attr>
                <!-- Current Patient Location -->
                <attr tag="00380300">$order->name_dep</attr>
                <!-- Patient's Name -->
                <attr tag="00100010">$order->name</attr>
                <!-- Patient ID -->
                <attr tag="00100020">$order->patientid</attr>
                <!-- Patients Birth Date -->
                <attr tag="00100030">$birthDate</attr>
                <!-- Patient's Sex -->
                <attr tag="00100040">$order->sex</attr>
                <!-- Patient's Weight -->
                <attr tag="00101030">$weight</attr>
                <!-- Confidentiality constraint on patient data -->
                <attr tag="00403001">V</attr>
                <!-- Patient State -->
                <attr tag="00380500">$order->pat_state</attr>
                <!-- Pregnancy Status -->
                <attr tag="001021C0">0000</attr>
                <!-- Medical Alerts -->
                <attr tag="00102000">-</attr>
                <!-- Contrast Allergies -->
                <attr tag="00102110">$contrastAllergies</attr>
                <!-- Special Needs -->
                <attr tag="00380050">$order->spc_needs</attr>
            </dataset>
            XML;

        $xml = simplexml_load_string($xmlstr);

        file_put_contents('risworklist.xml', $xml->asXML());

        exec('c:\Windows\System32\cmd.exe /c START 69.bat');
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
