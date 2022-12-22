<?php

namespace App\Http\Controllers;

use App\PatientRis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\FormatResponse;

class PatientRisController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $rules = [
            "mrn" => "required|unique:App\PatientRis,mrn",
            "name" => "required",
            "sex" => "required",
            "birth_date" => "required|date_format:Y-m-d",
            "weight" => "nullable",
            "address" => "nullable",
            "note" => "nullable",
            "phone" => "nullable",
            "email" => "nullable",
        ];

        $messages = [
            "mrn.unique" => "mrn double (unique)"
        ];

        $validator = Validator::make($input, $rules, $messages);

        // jika validasi gagal ke logging slack-simrs-ris-error
        if ($validator->fails()) {
            $patientRis = PatientRis::where('mrn', $request->mrn)->first();
            return response()->json([
                'status' => $validator->errors(),
                'mrn' => $patientRis->mrn,
                'name' => $patientRis->name
            ], 422);
        }

        $patientRis = PatientRis::create($input);

        return response()->json([
            'status' => 'Berhasil!',
            'pk' => $patientRis->pk
        ], 201);
    }
}
