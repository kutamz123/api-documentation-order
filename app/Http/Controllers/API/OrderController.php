<?php

namespace App\Http\Controllers\API;

use App\Order;
use Carbon\Carbon;
use App\Jobs\LogSimrsRisJob;
use Illuminate\Http\Request;
use App\Events\SimrsRisEvent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\FormatResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $reqUid = $request->input("uid");

        $orders = Order::paginate(500);

        if ($reqUid) {
            $order = Order::where("uid", $reqUid)->first();
            if ($order)
                return FormatResponse::success($order, "uid berhasil ditemukan", 200);
            else
                return FormatResponse::error(null, "uid gagal ditemukan", 400);
        }

        return FormatResponse::success($orders, "Berhasil menampilkan data", 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();

        $rules = [
            "uid" => "required|unique:App\Order,uid",
            "acc" => "required|unique:App\Order,acc",
            "patientid" => "required",
            "mrn" => "required",
            "name" => "required",
            "lastname" => "nullable",
            "address" => "nullable",
            "sex" => "required",
            "birth_date" => "required|date_format:Y-m-d",
            "weight" => "nullable",
            "name_dep" => "required",
            "xray_type_code" => "required",
            "typename" => "nullable",
            "type" => "nullable",
            "prosedur" => "required",
            "dokterid" => "required",
            "named" => "required",
            "lastnamed" => "nullable",
            "email" => "nullable",
            "radiogrpaher_id" => "nullable",
            "radiographer_name" => "nullable",
            "radiographer_lastname" => "nullable",
            "dokradid" => "nullable",
            "dokrad_name" => "nullable",
            "dokrad_lastname" => "nullable",
            "create_time" => "required|date_format:Y-m-d H:i:s",
            "schedule_date" => "required|date_format:Y-m-d",
            "schedule_time" => "required|date_format:H:i:s",
            "contrast" => "nullable",
            "priority" => "nullable",
            "pat_state" => "required",
            "contrast_allergies" => "nullable",
            "spc_needs" => "nullable",
            "payment" => "required",
            "fromorder" => "required",
        ];

        $messages = [
            "uid.unique" => "uid gagal input atau uid double (unique)",
            "acc.unique" => "acc double (unique)"
        ];

        $validator = Validator::make($input, $rules, $messages);

        // jika validasi gagal ke logging slack-simrs-ris-error
        if ($validator->fails()) {
            // LogSimrsRisJob::dispatch('false', $request->method(), $request->all(), $validator->errors());
            SimrsRisEvent::dispatch('false', $request->url(), $request->method(), $request->all(), $validator->errors());
            return FormatResponse::error($validator->errors(), "Validasi gagal", 422);
        }

        DB::transaction(function () use ($request, $input) {

            $patientid = $request->patientid;
            $name = $request->name;
            $birthDate = new Carbon($request->birth_date);
            $birthDate = $birthDate->format("Ymd");
            $sex = $request->sex;
            $xrayTypeCode = $request->xray_type_code;
            $prosedur = $request->prosedur;
            $uid = $request->uid;
            $acc =  $request->acc;
            $scheduleDate = new Carbon($request->schedule_date);
            $scheduleDate = $scheduleDate->format("Ymd");
            $scheduleTime = new Carbon($request->schedule_time);
            $scheduleTime = $scheduleTime->format("His");
            $named = $request->named;
            $dokrad_name = $request->dokrad_name;
            $weight = $request->weight;
            $name_dep = $request->name_dep;
            $contrast = $request->contrast;
            $contrastAllergies = $request->contrast_allergies;
            $priority = $request->priority;
            $patState = $request->pat_state;
            $spcNeeds = $request->spc_needs;

            $mwlItems = DB::select('SELECT sps_id FROM mppsio.mwl_item ORDER BY pk DESC LIMIT 1');
            $mwlItem = collect($mwlItems)->pluck("sps_id");
            $spsId = str_replace('SPS-xx', '', $mwlItem[0]);
            $generatesps = $spsId + 1;

            if ($generatesps == 1) {
                $generatesps = 3;
            }
            $codevalue = 'PROT-2018';
            $procid = 'SPS-xx' . $generatesps;
            $rp = 'RP-00' . $generatesps;

            dd($procid);

            $radiographer_name = "";

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
                        <attr tag="00080060">$xrayTypeCode</attr>
                        <!-- Scheduled Performing Physician's Name -->
                        <attr tag="00400006">$radiographer_name</attr>
                        <!-- Scheduled Procedure Step Description -->
                        <attr tag="00400007">$prosedur</attr>
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
                <attr tag="00321032">$dokrad_name</attr>
                <!-- Requesting Service -->
                <attr tag="00321033">$name_dep</attr>
                <!-- Referring Physician's Name -->
                <attr tag="00080090">$named</attr>
                <!-- Admission ID -->
                <attr tag="00380010">ADM-1234</attr>
                <!-- Current Patient Location -->
                <attr tag="00380300">$name_dep</attr>
                <!-- Patient's Name -->
                <attr tag="00100010">$name</attr>
                <!-- Patient ID -->
                <attr tag="00100020">$patientid</attr>
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
                <attr tag="00102000">-</attr>
                <!-- Contrast Allergies -->
                <attr tag="00102110">$contrastAllergies</attr>
                <!-- Special Needs -->
                <attr tag="00380050">$spcNeeds</attr>
            </dataset>
            XML;

            $xml = simplexml_load_string($xmlstr);

            file_put_contents('risworklist.xml', $xml->asXML());

            Order::create($input);

            exec('c:\Windows\System32\cmd.exe /c START 69.bat');

            SimrsRisEvent::dispatch('true', $request->url(), $request->method(), $request->all(), true);
        });

        return FormatResponse::success(true, 'Berhasil memasukkan data', 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uid)
    {
        $data = Order::where("uid", $uid)->first();

        if (!$data) {
            return FormatResponse::error(NULL, "uid tidak ditemukan", 404);
        }

        return FormatResponse::success($data, "uid berhasil ditemukan", 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Order::where("uid", $id);

        $delete->delete();

        return FormatResponse::success($delete, "Berhasil menghapus data", 200);
    }
}
