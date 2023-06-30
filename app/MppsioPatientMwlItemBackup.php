<?php

namespace App;

use App\Casts\DefaultValueCast;
use App\Casts\DefaultValueDateCast;
use App\Casts\DefaultValueDateTimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MppsioPatientMwlItemBackup extends Model
{
    use HasFactory;

    protected $table = "mppsio_patient_mwl_item_backup";

    protected $primaryKey = 'pk';

    protected $fillable = [
        "pk",
        "merge_fk",
        "pat_id",
        "pat_id_issuer",
        "pat_name",
        "pat_fn_sx",
        "pat_gn_sx",
        "pat_i_name",
        "pat_p_name",
        "pat_birthdate",
        "pat_sex",
        "pat_custom1",
        "pat_custom2",
        "pat_custom3",
        "patient_fk",
        "sps_status",
        "sps_id",
        "start_datetime",
        "station_aet",
        "station_name",
        "modality",
        "perf_physician",
        "perf_phys_fn_sx",
        "perf_phys_gn_sx",
        "perf_phys_i_name",
        "perf_phys_p_name",
        "req_proc_id",
        "accession_no",
        "study_iuid",
        "updated_time",
        "created_time",
    ];

    public $timestamps = false;

    protected $hidden = [
        'item_attrs'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'merge_fk' => DefaultValueCast::class,
        'pat_id' => DefaultValueCast::class,
        'pat_id_issuer' => DefaultValueCast::class,
        'pat_name' => DefaultValueCast::class,
        'pat_fn_sx' => DefaultValueCast::class,
        'pat_gn_sx' => DefaultValueCast::class,
        'pat_i_name' => DefaultValueCast::class,
        'pat_p_name' => DefaultValueCast::class,
        'pat_birthdate' => DefaultValueDateCast::class,
        'pat_sex' => DefaultValueCast::class,
        'pat_custom1' => DefaultValueCast::class,
        'pat_custom2' => DefaultValueCast::class,
        'pat_custom3' => DefaultValueCast::class,
        'patient_fk' => DefaultValueCast::class,
        'sps_status' => DefaultValueCast::class,
        'sps_id' => DefaultValueCast::class,
        'start_datetime' => DefaultValueDateTimeCast::class,
        'station_aet' => DefaultValueCast::class,
        'station_name' => DefaultValueCast::class,
        'modality' => DefaultValueCast::class,
        'perf_physician' => DefaultValueCast::class,
        'perf_phys_fn_sx' => DefaultValueCast::class,
        'perf_phys_gn_sx' => DefaultValueCast::class,
        'perf_phys_i_name' => DefaultValueCast::class,
        'perf_phys_p_name' => DefaultValueCast::class,
        'req_proc_id' => DefaultValueCast::class,
        'accession_no' => DefaultValueCast::class,
        'study_iuid' => DefaultValueCast::class,
        'updated_time' => DefaultValueDateTimeCast::class,
        'created_time' => DefaultValueDateTimeCast::class,
    ];
}
