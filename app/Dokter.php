<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = "xray_dokter";

    protected $fillable = [
        'dokterid',
        'named',
    ];
}
