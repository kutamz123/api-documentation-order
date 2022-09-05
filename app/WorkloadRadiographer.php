<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkloadRadiographer extends Model
{

    protected $fillable = [
        "uid",
        "acc",
        "patientid",
        "mrn",
        "name",
        "lastname",
        "address",
        "sex",
        "birth_date",
        "weight",
        "name_dep",
        "xray_type_code",
        "typename",
        "type",
        "prosedur",
        "dokterid",
        "named",
        "lastnamed",
        "email",
        "radiographer_id",
        "radiographer_name",
        "radiographer_lastname",
        "dokradid",
        "dokrad_name",
        "dokrad_lastname",
        "create_time",
        "schedule_date",
        "schedule_time",
        "contrast",
        "priority",
        "pat_state",
        "contrast_allergies",
        "spc_needs",
        "payment",
        "fromorder"
    ];

    protected $table = "xray_workload_radiographer";

    protected $hidden = [
        "pk", "id"
    ];

    public $timestamps = false;
}
