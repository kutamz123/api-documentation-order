<?php

namespace App;

use DateTime;
use App\Order;
use App\Study;
use App\Patient;
use App\DokterRadiology;
use App\NotificationUnread;
use App\Casts\DefaultValueCast;
use App\Casts\DefaultValueDateCast;
use App\Casts\DefaultValueTimeCast;
use App\Casts\DefaultValueDateTimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Workload extends Model
{
    use Notifiable;

    protected $primaryKey = "pk";

    protected $fillable = [
        "uid",
        "accession_no",
        "status",
        "pk_dokter_radiology",
        "fill",
        "approved_at",
        "approved_updated_at",
        "study_datetime_pacsio",
        "study_desc_pacsio",
        "updated_time_pacsio",
        "priority_doctor"
    ];

    protected $table = "xray_workload";

    protected $hidden = [
        "pk", "id"
    ];

    public $timestamps = false;

    public function notificationUnreads()
    {
        return $this->hasMany(NotificationUnread::class, 'uid', 'uid');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'accession_no' => DefaultValueCast::class,
        'status' => DefaultValueCast::class,
        // 'fill' => DefaultValueCast::class,
        'approved_at' => DefaultValueDateTimeCast::class,
        'approve_updated_at' => DefaultValueDateTimeCast::class,
        'priority_doctor' => DefaultValueCast::class
    ];

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

    public function dokterRadiology()
    {
        return $this->hasOne(DokterRadiology::class, "pk", "pk_dokter_radiology")->withDefault([
            "dokradid" => null,
            "dokrad_name" => null,
        ]);
    }

    public function order()
    {
        return $this->hasOne(Order::class, "uid", "uid")->withDefault(
            ["dokradid" => null]
        );
    }

    public function study()
    {
        return $this->hasOne(Study::class, "study_iuid", "uid");
    }

    public function workloadFill()
    {
        return $this->hasMany(WorkloadFill::class, 'uid', 'uid');
    }

    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            Study::class,
            'study_iuid', // Foreign key on the Study table...
            'pk', // Foreign key on the Patient table...
            'uid', // Local key on the patient table...
            'patient_fk' // Local key on the study table...
        );
    }
}
