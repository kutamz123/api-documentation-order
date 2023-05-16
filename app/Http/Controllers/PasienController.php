<?php

namespace App\Http\Controllers;

use App\HostnamePublik;
use App\Study;
use App\Patient;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function show(Request $request, $uid)
    {
        $study = Study::where('study_iuid', $uid)->firstOrFail();

        $hostname = HostnamePublik::first();

        return view("pasien", [
            "study" => $study,
            "hostname" => $hostname
        ]);
    }
}
