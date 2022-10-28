<?php

namespace App;

use DateTime;
use App\Study;
use Illuminate\Support\Str;
use App\Casts\DefaultValueCast;
use App\Casts\DefaultValueDateCast;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
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
    protected $table = 'pacsio.patient';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "pat_id",
        "pat_name",
        "pat_birthdate",
        "pat_custom1",
        "pat_sex"
    ];

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

    protected $hidden = [
        "merge_fk",
        "pat_id_issuer",
        "pat_fn_sx",
        "pat_gn_sx",
        "pat_i_name",
        "pat_p_name",
        "pat_custom2",
        "pat_custom3",
        "pat_attrs",
        "updated_time",
        "created_time"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pat_id' => DefaultValueCast::class,
        'pat_name' => DefaultValueCast::class,
        'pat_birthdate' => DefaultValueDateCast::class,
        'pat_sex' => DefaultValueCast::class
    ];

    public function getAgeAttribute()
    {
        $birthDate = $this->pat_birthdate;
        if ($birthDate != '-') {
            $birthDate = new DateTime($birthDate);
            $today = new DateTime(date('Y-m-d'));
            $diff = $today->diff($birthDate);
            $age = $diff->y . 'Y' . ' ' . $diff->m . 'M' . ' ' . $diff->d . 'D';
        } else {
            $age = '-';
        }

        return $age;
    }

    public function scopeDownloadExcel($query, $fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerID)
    {
        $ris = 'intimedika_base';
        $pacsio = 'pacsio';
        $mppsio = 'mppsio';
        return $query
            ->join($pacsio . '.study', 'patient.pk', '=', 'study.patient_fk')
            ->leftJoin($ris . '.xray_workload', 'study.study_iuid', '=', $ris . '.xray_workload.uid')
            ->leftJoin($ris . '.xray_order', 'study.study_iuid', '=', $ris . '.xray_order.uid')
            ->leftJoin($ris . '.xray_workload_bhp', 'study.study_iuid', '=', $ris . '.xray_workload_bhp.uid')
            ->whereBetween('study.updated_time', [$fromUpdatedTime, $toUpdatedTime])
            ->whereIn('mods_in_study', $modsInStudy)
            ->whereIn('priority_doctor', $priorityDoctor)
            ->whereIn('radiographer_id', $radiographerID);
    }

    public function study()
    {
        return $this->hasOne(Study::class, 'patient_fk', 'pk');
    }

    public function workload()
    {
        return $this->hasOneThrough(
            Workload::class,
            Study::class,
            'patient_fk', // Foreign key on the Study table...
            'uid', // Foreign key on the Workload table...
            'pk', // Local key on the patient table...
            'study_iuid' // Local key on the study table...
        );
    }

    public function workloadBhp()
    {
        return $this->hasOneThrough(
            WorkloadBHP::class,
            Study::class,
            'patient_fk', // Foreign key on the Study table...
            'uid', // Foreign key on the WorkloadBHP table...
            'pk', // Local key on the patient table...
            'study_iuid' // Local key on the study table...
        );
    }
}
