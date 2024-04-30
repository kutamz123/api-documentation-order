<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DicomRouter extends Model
{
    use HasFactory;

    protected $primaryKey = "pk";

    protected $guarded = [];

    protected $table = "dicom_router";
}
