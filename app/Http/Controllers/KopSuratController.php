<?php

namespace App\Http\Controllers;

use App\KopSurat;
use Illuminate\Http\Request;

class KopSuratController extends Controller
{
    public function index()
    {
        $kopSurat = KopSurat::first();
        $kop = isset($kopSurat->image) ? asset('storage/' . $kopSurat->image) : 'belum ada gambar';
        return view('kop-surat.index')->with('kop', $kop);
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
