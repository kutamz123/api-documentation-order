<?php

namespace App;

use DateTime;
use App\Order;
use App\Study;
use App\Workload;
use App\WorkloadBHP;
use Illuminate\Support\Str;
use App\Casts\DefaultValueCast;
use App\Casts\DefaultValueDateCast;
use App\Casts\DefaultValueDateTimeCast;
use App\Casts\DefaultValueTimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'pat_sex' => DefaultValueCast::class,

        // (table study) untuk excel
        'study_datetime' => DefaultValueDateTimeCast::class,
        'accession_no' => DefaultValueCast::class,
        'ref_physician' => DefaultValueCast::class,
        'study_desc' => DefaultValueCast::class,
        'mods_in_study' => DefaultValueCast::class,
        'updated_time' => DefaultValueDateTimeCast::class,

        // (table workload) untuk excel
        'status' => DefaultValueCast::class,
        'fill' => DefaultValueCast::class,
        'approved_at' => DefaultValueDateTimeCast::class,
        'approve_updated_at' => DefaultValueDateTimeCast::class,
        'priority_doctor' => DefaultValueCast::class,

        // (table workload bhp) untuk excel
        'film_small' => DefaultValueCast::class,
        'film_medium' => DefaultValueCast::class,
        'film_large' => DefaultValueCast::class,
        'film_reject_small' => DefaultValueCast::class,
        'film_reject_medium' => DefaultValueCast::class,
        'film_reject_large' => DefaultValueCast::class,
        're_photo' => DefaultValueCast::class,
        'kv' => DefaultValueCast::class,
        'mas' => DefaultValueCast::class,

        // (table order) untuk excel
        'patientid' => DefaultValueCast::class,
        'name_dep' => DefaultValueCast::class,
        'named' => DefaultValueCast::class,
        'radiographer_name' => DefaultValueCast::class,
        'dokrad_name' => DefaultValueCast::class,
        'create_time' => DefaultValueDateTimeCast::class,
        'schedule_date' => DefaultValueDateCast::class,
        'schedule_time' => DefaultValueTimeCast::class,
        'priority' => DefaultValueCast::class,
        'pat_state' => DefaultValueCast::class,
        'contrast_allergies' => DefaultValueCast::class,
        'spc_needs' => DefaultValueCast::class,
        'payment' => DefaultValueCast::class,
        'examed_at' => DefaultValueDateTimeCast::class
    ];

    // spend time untuk excel (join)
    public function getSpendTimeAttribute()
    {
        if ($this->status == 'APPROVED' || $this->status == 'approved') {
            $interval = strtotime($this->approved_at) - strtotime($this->study_datetime);
            $hour = floor($interval / (60 * 60));
            $minute = $interval - $hour * (60 * 60);
            $minute = $minute / 60;
            $spendTime = "{$hour} jam {$minute} menit";
        } else {
            $spendTime = '-';
        }

        return $spendTime;
    }

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

    public function scopeDownloadExcel($query, $fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName)
    {
        $ris = 'intimedika_base';
        $pacsio = 'pacsio';
        $mppsio = 'mppsio';
        return $query
            ->join($pacsio . '.study', 'patient.pk', '=', 'study.patient_fk')
            ->join($ris . '.xray_workload', 'study.study_iuid', '=', $ris . '.xray_workload.uid')
            ->join($ris . '.xray_order', 'study.study_iuid', '=', $ris . '.xray_order.uid')
            ->join($ris . '.xray_workload_bhp', 'study.study_iuid', '=', $ris . '.xray_workload_bhp.uid')
            ->whereBetween('study.study_datetime', [$fromUpdatedTime, $toUpdatedTime])
            ->whereIn('mods_in_study', $modsInStudy)
            ->whereIn('priority_doctor', $priorityDoctor)
            ->whereIn('radiographer_name', $radiographerName);
    }

    public function scopeDownloadExcelOrm($query, $fromUpdatedTime, $toUpdatedTime, $modsInStudy, $priorityDoctor, $radiographerName)
    {
        $query->whereHas('study', function (Builder $query) use ($modsInStudy, $fromUpdatedTime, $toUpdatedTime) {
            $query->whereBetween('study_datetime', [$fromUpdatedTime, $toUpdatedTime])
                ->whereIn('mods_in_study', $modsInStudy);
        })->whereHas('workload', function (Builder $query) use ($priorityDoctor) {
            $query->whereIn('priority_doctor', $priorityDoctor);
        })->whereHas('order', function (Builder $query) use ($radiographerName) {
            $query->whereIn('radiographer_name', $radiographerName);
        });
    }

    public function study()
    {
        return $this->hasOne(Study::class, 'patient_fk', 'pk');
    }

    public function order()
    {
        return $this->hasOneThrough(
            Order::class,
            Study::class,
            'patient_fk', // Foreign key on the Study table...
            'uid', // Foreign key on the Workload table...
            'pk', // Local key on the patient table...
            'study_iuid' // Local key on the study table...
        );
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

    public function workloadbhp()
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
