<?php

namespace App\Http\Controllers\API;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\FormatResponse;
use Illuminate\Support\Facades\Log;

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
            "uid.unique" => "uid gagal input / uid double (unique)",
            "acc.unique" => "acc double (unique)"
        ];

        $validator = Validator::make($input, $rules, $messages);

        // jika validasi masuk ke logging slack-simrs-ris
        if ($validator->fails()) {
            Log::channel('slack-simrs-ris-error')->critical('Validasi gagal', [
                'request' => [
                    'uid' => $request->uid,
                    'name' => $request->name,
                    'patientid' => $request->patientid,
                    'mrn' => $request->mrn,
                    'modality' => $request->xray_type_code,
                    'prosedur' => $request->prosedur
                ],
                'response' => $validator->errors()
            ]);
            return FormatResponse::error($validator->errors(), "Validasi gagal", 422);
        }

        $order = Order::create($input);

        Log::channel('slack-simrs-ris-success')->info('Berhasil memasukkan data', [
            'request' => [
                'uid' => $request->uid,
                'name' => $request->name,
                'patient_id' => $request->patientid,
                'mrn' => $request->mrn,
                'modality' => $request->xray_type_code,
                'prosedur' => $request->prosedur
            ],
            'response' => [
                'true' => 'Berhasil memasukkan data'
            ]
        ]);

        return FormatResponse::success($order, "Berhasil memasukkan data", 201);
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
