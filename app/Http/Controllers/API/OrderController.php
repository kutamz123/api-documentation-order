<?php

namespace App\Http\Controllers\API;

use App\Order;
use App\Study;
use App\Mwlitem;
use App\Workload;
use App\WorkloadBHP;
use App\OrderSimrsBackup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\SimrsRisEvent;
use Illuminate\Support\Facades\DB;
use App\MppsioPatientMwlItemBackup;
use Illuminate\Support\Facades\Log;
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
        $mrn = $request->input('mrn');
        $xrayTypeCode = $request->input('xray_type_code');
        $idProsedur = $request->input('id_prosedur');
        $acc = $request->input('acc');
        $dateNow = date('Ymd');
        $random = rand(1, 999);
        $idProsedurNumber = filter_var($idProsedur, FILTER_SANITIZE_NUMBER_INT);

        // xray type code
        $xray_type_code = Str::upper($xrayTypeCode);
        $request['xray_type_code'] = $xray_type_code;

        // uid
        $uid = "1.2.40.0.13.1.{$mrn}.{$dateNow}.{$acc}{$idProsedurNumber}{$random}";
        $request['uid'] = $uid;

        // sex
        $sex = $request->input('sex');
        if ($sex == "L" || $sex == "l") {
            $request['sex'] = "M";
        } else if ($sex == "P" || $sex == "p") {
            $request['sex'] = "F";
        } else {
            $request['sex'] = $sex;
        }

        $input = $request->all();

        $rules = [
            "uid" => "required|unique:App\Order,uid",
            "acc" => "required|unique:App\Order,acc|numeric",
            "patientid" => "required",
            "mrn" => "required|numeric",
            "name" => "required",
            "lastname" => "nullable",
            "address" => "nullable",
            "sex" => "required",
            "birth_date" => "required|date_format:Y-m-d",
            "weight" => "nullable",
            "dep_id" => "required",
            "name_dep" => "required",
            "id_modality" => "required",
            "xray_type_code" => "required|alpha_dash",
            "id_prosedur" => "required",
            "prosedur" => "required",
            "harga_prosedur" => "required|numeric|digits_between:0,9999999999",
            "dokterid" => "required",
            "named" => "required",
            "lastnamed" => "nullable",
            "email" => "nullable",
            "radiographer_id" => "nullable",
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
            "pat_state" => "nullable",
            "contrast_allergies" => "nullable",
            "spc_needs" => "nullable",
            "id_payment" => "required",
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
            SimrsRisEvent::dispatch('false', $request->url(), $request->method(), $request->all(), $validator->errors());
            return FormatResponse::error($validator->errors(), "Validasi gagal", 422);
        }

        DB::transaction(function () use ($input) {
            Order::create($input);

            OrderSimrsBackup::create($input);
        });

        SimrsRisEvent::dispatch('true', $request->url(), $request->method(), $request->all(), true);

        return FormatResponse::success(true, 'Berhasil memasukkan data', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByExamedAt(Request $request)
    {
        $input = $request->all();

        $rules = [
            "examed_at" => "required|date|date_format:Y-m-d",
        ];

        $messages = [
            "examed_at.date" => "Format Wajib Tanggal",
            "examed_at.date_format" => "Format Wajib Y-m-d"
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return FormatResponse::error($validator->errors(), "Validasi gagal", 422);
        }

        $data = Order::with(["study", "workload"])->whereBetween("examed_at", ["$request->examed_at 00:00:01", "$request->examed_at 23:59:59"])
            ->where("fromorder", "SIMRS")->get();

        if ($data->isEmpty()) {
            return FormatResponse::error(NULL, "$request->examed_at tidak ditemukan", 404);
        }

        return FormatResponse::success($data, "$request->examed_at berhasil ditemukan", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($acc, $mrn)
    {
        $data = Order::with(["study", "workload"])->where("acc", $acc)->where('mrn', $mrn)->first();

        if (!$data) {
            return FormatResponse::error(NULL, "acc tidak ditemukan", 404);
        }

        return FormatResponse::success($data, "acc berhasil ditemukan", 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validationUpdateSimrs(Request $request)
    {
        $order = Order::where('acc', $request->accession_no)
            ->where('mrn', $request->pat_id)
            ->where('fromorder', 'SIMRS')
            ->first();

        $dataLog = [
            'uid_simrs' => $order->uid ?? '',
            'uid_study' => $request->study_iuid,
            'accession_no' => $request->accession_no,
            'acc' => $order->acc ?? '',
            'pat_id' => $request->pat_id,
            'mrn' => $order->mrn ?? '',
            'dokradid' => $order->dokradid ?? '',
            'dokrad_name' => $order->dokrad_name ?? ''
        ];

        if ($order == true) {
            $mods_in_study = $request->query("mods_in_study") == "CT\\SR" ? "CT" : $request->query("mods_in_study");
            if ($mods_in_study != $order->xray_type_code) {
                Log::error('(validasi) update uid by acc dan modality tidak sama', $dataLog);

                $response = response()->json(
                    [
                        'status' => 'validation',
                        'name' => $order->name,
                        'xray_type_code' => $order->xray_type_code,
                        'prosedur' => $order->prosedur
                    ],
                    200
                );
            } else {
                $response = $this->updateSimrs($request);
            }
        } else if ($order == null) {
            Log::error('(validasi) update uid by acc dan mrn tidak sama', $dataLog);

            $response = response()->json('acc dan mrn tidak sama dengan simrs', 404);
        } else {
            Log::error('(gagal) update uid by acc, uid sudah di update', $dataLog);

            $response = response()->json('uid sudah di update', 404);
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSimrs(Request $request)
    {
        try {
            // mencari uid yang sama.
            $uidExist = Order::where("uid", $request->study_iuid)->first();

            // jika uid ada di xray_order, maka update uid menjadi uid lama.
            if ($uidExist) {
                $dateNow = date('YmdHis');
                $random = rand(1, 999);
                $uidChange = $uidExist->mrn . $dateNow . $random;
                Order::where("uid", $uidExist->uid)->update([
                    "uid" => $uidChange
                ]);
                Log::info("updateSimrs", ["uidExist" => "kesalahan input yang menyebabkan uid double : " . $uidChange]);
            }

            // mencari accession number yang sama
            $accessionNoExist = Study::where("accession_no", $request->accession_no)->first();
            if ($accessionNoExist) {
                Study::where("accession_no", $accessionNoExist->accession_no)->update([
                    "accession_no" => NULL
                ]);
            }

            $order = Order::where('acc', $request->accession_no)
                ->where('mrn', $request->pat_id)
                ->where('fromorder', 'SIMRS')
                ->first();

            $dataLog = [
                'uid_simrs' => $order->uid ?? '',
                'uid_study' => $request->study_iuid,
                'accession_no' => $request->accession_no,
                'acc' => $order->acc ?? '',
                'pat_id' => $request->pat_id,
                'mrn' => $order->mrn ?? '',
                'dokradid' => $order->dokradid ?? '',
                'dokrad_name' => $order->dokrad_name ?? ''
            ];

            // cek apakah uid dari change doctor ada ?
            $uidChangeDoctor = Order::where('uid', $request->study_iuid)
                ->where('acc', '')
                ->where('fromorder', NULL)
                ->first();

            // kalo ada. hapus row berdasarkan uid dan ambil dokradid dan dokrad_name
            if ($uidChangeDoctor == true) {
                $uidChangeDoctor->forceDelete($request->study_iuid);
                Log::info('hapus uid change doctor', [
                    'uidChangeDoctor' => $request->study_iuid,
                    'dokradid' => $uidChangeDoctor->dokradid,
                    'dokrad_name' => $uidChangeDoctor->dokrad_name
                ]);
            }

            // update uid, dokradid, dokrad_name (kondisi)
            Order::where('acc', $request->accession_no)
                ->where('mrn', $request->pat_id)
                ->where('fromorder', 'SIMRS')
                ->update([
                    'uid' => $request->study_iuid,
                    'dokradid' => $uidChangeDoctor->dokradid ?? $order->dokradid,
                    'dokrad_name' => $uidChangeDoctor->dokrad_name ?? $order->dokrad_name
                ]);

            $study = Study::where('study_iuid', $request->study_iuid)
                ->update([
                    'accession_no' => $request->accession_no,
                    'study_desc' => $order->prosedur,
                    'ref_physician' => $order->named
                ]);

            Workload::where('uid', $request->study_iuid)
                ->update([
                    'study_desc_pacsio' => $order->prosedur,
                    'accession_no' => $request->accession_no,
                ]);

            WorkloadBHP::updateOrCreate(
                [
                    'uid' => $request->study_iuid
                ],
                [
                    'acc' => $request->accession_no
                ]
            );

            // cek study iuid
            $study = Study::where('study_iuid', $request->study_iuid)->first();

            // hapus mwl item berdasarkan study iuid atau accession no
            $mwlItem = Mwlitem::where('study_iuid', $request->study_iuid)->orWhere('accession_no', $request->accession_no);
            $mwlItem->delete();

            $study->patient()->update([
                'pat_id' => $request->pat_id,
                'pat_name' => $order->name,
                'pat_sex' => $order->sex,
                'pat_birthdate' => date('Ymd', strtotime($order->birth_date)),
            ]);

            Log::info('(sukses) update uid by acc', $dataLog);

            return response()->json('uid berhasil di update', 200);
        } catch (\Illuminate\Database\QueryException $th) {
            Log::error(__FUNCTION__, [$th->getMessage()]);
            return response()->json('uid sudah digunakan, silahkan cek Accession Number', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($acc, $mrn)
    {
        $delete = Order::where("acc", $acc)->where('mrn', $mrn)->first();
        $deleteSimrs = OrderSimrsBackup::where("acc", $acc)->where('mrn', $mrn)->first();
        $deleteMppsioSimrs = MppsioPatientMwlItemBackup::where("accession_no", $acc)->where('pat_id', $mrn)->first();
        $mwlItem = Mwlitem::where('accession_no', $acc)->first();

        if (!$delete) {
            $response = FormatResponse::error(NULL, "Gagal! acc $acc tidak ada", 404);
        } else {
            DB::transaction(function () use ($delete, $deleteSimrs, $deleteMppsioSimrs, $mwlItem) {
                $delete->forceDelete();
                $deleteSimrs == true ? $deleteSimrs->forceDelete() : "";
                $deleteMppsioSimrs == true ? $deleteMppsioSimrs->forceDelete() : "";
                $mwlItem == true ? $mwlItem->forceDelete() : "";
            });

            $response = FormatResponse::success(true, "Berhasil menghapus data", 200);
        }

        return $response;
    }
}
