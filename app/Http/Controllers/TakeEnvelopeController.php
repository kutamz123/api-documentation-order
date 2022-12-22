<?php

namespace App\Http\Controllers;

use App\TakeEnvelope;
use Illuminate\Http\Request;

class TakeEnvelopeController extends Controller
{
    public function store(Request $request)
    {
        TakeEnvelope::updateOrCreate(
            [
                'uid' => $request->study_iuid
            ],
            [
                'uid' => $request->uid,
                'name' => $request->name,
                'is_taken' => $request->is_taken,
                'created_at' => $request->created_at
            ]
        );

        return response()->json(['status' => 'Berhasil!'], 201);
    }
}
