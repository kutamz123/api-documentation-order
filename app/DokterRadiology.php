<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterRadiology extends Model
{
    use HasFactory;

    protected $primaryKey = "pk";

    protected $fillable = [
        'dokradid',
        'dokrad_name',
        'dokrad_lastname',
        'dokrad_sex',
        'dokrad_tlp',
        'dokrad_email',
        'dokrad_img',
        'imgtemp',
        'username',
        'password',
        'otp',
        'idtele'
    ];

    protected $table = "xray_dokter_radiology";

    public $timestamps = false;
}
