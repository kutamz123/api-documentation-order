<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mwlitem extends Model
{
    // protected $fillable = ['pk', 'patient_fk', 'study_iuid', 'accession_no', 'modality'];
    protected $table = 'mwl_item';
    protected $connection = 'mppsio';
    protected $hidden = [
        "sps_status",
        "station_name",
        "perf_phys_fn_sx",
        "perf_phys_gn_sx",
        "perf_phys_i_name",
        "perf_phys_p_name",
        "item_attrs"
    ];
}
