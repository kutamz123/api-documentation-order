<?php

namespace App\Http\Controllers;

use App\KopSurat;
use Illuminate\Http\Request;

class KopSuratController extends Controller
{
    public function index()
    {
        return view('kop-surat.index')->with('kopSurat', KopSurat::first());
    }

    public function create()
    {
        return view('kop-surat.create');
    }

    public function store(Request $request)
    {
        $image = $request->file('image')->store('kop-surat', 'public');

        KopSurat::updateOrCreate(
            [
                'kode_image' => $request->kode_image,
            ],
            [
                'image' => $image
            ]
        );

        return response()->json('Berhasil!', 201);
    }
}
