<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveDicomRouter extends Model
{
    use HasFactory;

    protected $table = "active_dicom_router";

    protected $fillable = [
        'is_active'
    ];
}
