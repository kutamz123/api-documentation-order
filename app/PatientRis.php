<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRis extends Model
{
    use HasFactory;

    protected $primaryKey = "pk";

    protected $fillable = [
        "patientid",
        "mrn",
        "name",
        "sex",
        "birth_date",
        "weight",
        "address",
        "phone",
        "email",
        "note",
    ];

    protected $table = "xray_patient";
}
