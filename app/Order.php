<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

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
        "fromorder",
        "examed_at"
    ];

    protected $table = "xray_order";

    protected $hidden = [
        "pk", "id"
    ];

    // const CREATED_AT = 'examed_at';
    // const UPDATED_AT = null;

    public $timestamps = false;
}
