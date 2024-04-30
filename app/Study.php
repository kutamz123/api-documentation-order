<?php

namespace App;

use App\Casts\DefaultValueCast;
use App\Casts\DefaultValueDateTimeCast;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pk';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pacsio.study';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "accession_no",
        "ref_physician",
        "study_desc",
        "mods_in_study"
    ];

    protected $hidden = [
        "accno_issuer_fk",
        "study_id",
        "ref_phys_fn_sx",
        "ref_phys_gn_sx",
        "ref_phys_i_name",
        "ref_phys_p_name",
        "study_custom1",
        "study_custom2",
        "study_custom3",
        "study_status_id",
        "cuids_in_study",
        "ext_retr_aet",
        "fileset_iuid",
        "fileset_id",
        "availability",
        "study_status",
        "checked_time",
        "chargeId",
        "totalCharge",
        "study_custom1billld",
        "invoiceNo",
        "batchNo",
        "billId",
        "created_time",
        "study_attrs"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'study_datetime' => DefaultValueDateTimeCast::class,
        'accession_no' => DefaultValueCast::class,
        'ref_physician' => DefaultValueCast::class,
        'study_desc' => DefaultValueCast::class,
        'mods_in_study' => DefaultValueCast::class,
        'updated_time' => DefaultValueDateTimeCast::class,
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_fk', 'pk')->withDefault([
            "pat_id" => "-",
            "pat_name" => "-",
            "pat_birthdate" => "-",
            "pat_sex" => "-",
        ]);
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'uid', 'study_iuid')->withDefault([
            "dokradid" => null,
            "dokrad_name" => null,
            "priority" => null
        ]);
    }

    public function workload()
    {
        return $this->hasOne(Workload::class, 'uid', 'study_iuid');
    }

    public function dicomRouter()
    {
        return $this->hasOne(DicomRouter::class, 'uid', 'study_iuid');
    }
}
