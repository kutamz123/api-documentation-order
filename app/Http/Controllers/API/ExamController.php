<?php

namespace App\Http\Controllers\API;

use App\Exam;
use App\Order;
use App\Mwlitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\FormatResponse;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $orderUid = Order::where("uid", $request->input("uid"));

        if (!$orderUid->first()) {
            return FormatResponse::error(NULL, "uid tidak ditemukan", 404);
        }

        $input = $request->all();

        $rules = [
            "uid" => "required|unique:App\Exam,uid",
            "acc" => "required|unique:App\Exam,acc",
            "patientid" => "required",
            "mrn" => "required",
            "name" => "required",
            "lastname" => "nullable",
            "address" => "nullable",
            "sex" => "required",
            "birth_date" => "required",
            "weight" => "nullable",
            "name_dep" => "required",
            "xray_type_code" => "required",
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
            "create_time" => "required",
            "schedule_date" => "required",
            "schedule_time" => "required",
            "contrast" => "nullable",
            "priority" => "nullable",
            "pat_state" => "required",
            "contrast_allergies" => "nullable",
            "spc_needs" => "nullable",
            "payment" => "required",
            "arrive_date" => "nullable",
            "arrive_time" => "nullable",
            "fromorder" => "required",
        ];

        $messages = [
            "uid.unique" => "uid gagal input / uid double (unique)",
            "acc.unique" => "acc double (unique)"
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return FormatResponse::error($validator->errors(), "Validasi gagal", 422);
        }

        $order = Exam::create($input);

        $orderUid->update([
            "fromorder" => "simrssend"
        ]);

        $orderUid->delete();

        return FormatResponse::success($order, "Berhasil memasukkan data", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('xray_exam')->where("uid", $id)->delete();
            Mwlitem::where("study_iuid", $id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Err',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
