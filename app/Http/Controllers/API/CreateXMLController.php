<?php

namespace App\Http\Controllers\API;

use DateTime;
use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CreateXMLController extends Controller
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        function specialCharacters($value)
        {
            return htmlspecialchars($value);
        }

        $birthDate = new Carbon($this->order->birth_date);
        $birthDate = $birthDate->format("Ymd");

        // age
        $birth_date = new DateTime($this->order->birth_date);
        $today = new DateTime(date('Y-m-d'));
        $diff = $today->diff($birth_date);
        $age = $diff->y;

        $scheduleDateTime = new Carbon($this->order->schedule_date . ' ' . $this->order->schedule_time);
        $scheduleDate = $scheduleDateTime->format("Ymd");
        $scheduleTime = $scheduleDateTime->format("His");
        $weight = $this->order->weight ?? 0;

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
        $admission = 'DCM-' . $generatesps;

        $radiographerName = specialCharacters($this->order->radiographer_name) ?? 'Default Radiographer';
        $contrast = specialCharacters($this->order->contrast) ?? 'Default Contrast';
        $contrastAllergies = specialCharacters($this->order->contrast_allergies) ?? 'NA';
        $prosedur = specialCharacters($this->order->prosedur);
        $acc = specialCharacters($this->order->acc);
        $dokradName = specialCharacters($this->order->dokrad_name);
        $priority = specialCharacters($this->order->priority);
        $nameDep = specialCharacters($this->order->name_dep);
        $patState = specialCharacters($this->order->pat_state) ?? 'NA';
        $spcNeeds = specialCharacters($this->order->spc_needs);
        $name = specialCharacters($this->order->name);
        $named = specialCharacters($this->order->named);
        $xrayTypeCode = $this->order->xray_type_code;
        $uid = $this->order->uid;
        $sex = $this->order->sex;
        $mrn = $this->order->mrn;
        $patientid = $this->order->patientid;
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
                        <attr tag="00400001">ANGELL_CCDDR</attr> <!-- DCMPACS -->
                        <!-- Scheduled Procedure Step Start Date -->
                        <attr tag="00400002">$scheduleDate</attr>
                        <!-- Scheduled Procedure Step Start Time -->
                        <attr tag="00400003">$scheduleTime</attr>
                        <!-- Modality -->
                        <attr tag="00080060">$xrayTypeCode</attr>
                        <!-- Scheduled Performing Physician's Name -->
                        <attr tag="00400006">$radiographerName</attr>
                        <!-- Scheduled Procedure Step Description -->
                        <attr tag="00400007">$prosedur</attr>
                        <!-- Scheduled Procedure Step Location -->
                        <attr tag="00400011">ANGELL_CCDDR</attr> <!-- Scheduled Procedure Step Location -->
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
                <attr tag="00321060">$prosedur</attr>
                <!-- Requested Procedure Code Sequence -->
                <attr tag="00321064">
                    <item>
                        <!-- Code Value -->
                        <attr tag="00080100">PROC-1205</attr>
                        <!-- Coding Scheme Designator -->
                        <attr tag="00080102">DCM</attr>
                        <!-- Code Meaning -->
                        <attr tag="00080104">$prosedur</attr>
                    </item>
                </attr>
                <!-- Study Instance UID -->
                <attr tag="0020000D">$uid</attr>
                <!-- Requested Procedure Priority -->
                <attr tag="00401003">$priority</attr>
                <!-- Accession Number -->
                <attr tag="00080050">$acc</attr>
                <!-- Requesting Physician -->
                <attr tag="00321032">$dokradName</attr>
                <!-- Requesting Service -->
                <attr tag="00321033">$prosedur</attr> <!-- $nameDep -->
                <!-- Referring Physician's Name -->
                <attr tag="00080090">$named</attr>
                <!-- Study Description -->
                <attr tag="00081030">$prosedur</attr>
                <!-- Admission ID -->
                <attr tag="00380010">$admission</attr> <!-- ADM-1234 -->
                <!-- Current Patient Location -->
                <attr tag="00380300">$nameDep</attr>
                <!-- Patient's Name -->
                <attr tag="00100010">$name</attr>
                <!-- Patient's Age -->
                <attr tag="00101010">$age</attr>
                <!-- Patient ID -->
                <attr tag="00100020">$mrn</attr>
                <!-- Pat id issuer -->
                <attr tag="00100021">$patientid</attr><!-- DCMPACS -->
                <!-- Patients Birth Date -->
                <attr tag="00100030">$birthDate</attr>
                <!-- Patient's Sex -->
                <attr tag="00100040">$sex</attr>
                <!-- Patient's Weight -->
                <attr tag="00101030">$weight</attr>
                <!-- Confidentiality constraint on patient data -->
                <attr tag="00403001">V</attr>
                <!-- Patient State -->
                <attr tag="00380500">$patState</attr>
                <!-- Pregnancy Status -->
                <attr tag="001021C0">0000</attr>
                <!-- Medical Alerts -->
                <attr tag="00102000">NA</attr>
                <!-- Contrast Allergies -->
                <attr tag="00102110">$contrastAllergies</attr>
                <!-- Special Needs -->
                <attr tag="00380050">$spcNeeds</attr>
            </dataset>
            XML;

        $xml = simplexml_load_string($xmlstr);

        // updated examed_at untuk RIS, untuk SIMRS ada di created orderObserver
        Order::where('uid', $uid)->update(['examed_at' => NOW()]);

        file_put_contents('risworklist.xml', $xml->asXML());

        exec('c:\Windows\System32\cmd.exe /c START 69.bat');
    }
}
