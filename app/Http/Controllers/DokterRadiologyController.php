<?php

namespace App\Http\Controllers;

use App\DokterRadiology;
use Illuminate\Http\Request;

class DokterRadiologyController extends Controller
{
    public function show($pk)
    {
        $dokterRadiology = DokterRadiology::where('pk', $pk)->first();
        $dokrad_img = isset($dokterRadiology->dokrad_img) ? asset('storage/' . $dokterRadiology->dokrad_img) : 'belum ada gambar';
        return view('dokter-radiology.show')->with('dokrad_img', $dokrad_img);
    }

    public function edit($pk)
    {
        $dokterRadiology = DokterRadiology::where('pk', $pk)->first();
        return view('dokter-radiology.edit')->with('dokterRadiology', $dokterRadiology);
    }

    public function update(Request $request)
    {
        $dokrad_img = $request->file('dokrad_img')->store('tanda-tangan', 'public');

        DokterRadiology::where('pk', $request->pk)
            ->update([
                'dokrad_img' => $dokrad_img
            ]);

        return response()->json('Berhasil!', 201);
    }
}
