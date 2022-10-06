<?php

namespace App;

use DateTime;
use App\NotificationUnread;
use App\Casts\DefaultValueCast;
use App\Casts\DefaultValueDateCast;
use App\Casts\DefaultValueTimeCast;
use App\Casts\DefaultValueDateTimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WorkloadRadiographer extends Model
{
    use Notifiable;

    protected $primaryKey = "pk";

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
        "arrive_time",
        "arrive_date",
        "fromorder"
    ];

    protected $table = "xray_workload_radiographer";

    protected $hidden = [
        "pk", "id"
    ];

    public $timestamps = false;

    public function dokterRadiology()
    {
        return $this->hasOne(DokterRadiology::class, 'dokradid', 'dokradid');
    }

    public function notificationUnreads()
    {
        return $this->hasMany(NotificationUnread::class, 'uid', 'uid');
    }

    public function scopeDownloadExcel($query, $fromUpdatedTime, $toUpdatedTime, $xrayTypeCode, $patienttype, $radiographerName)
    {
        return $query->whereBetween('updated_time', [$fromUpdatedTime, $toUpdatedTime])
            ->whereIn('xray_type_code', $xrayTypeCode)
            ->whereIn('patienttype', $patienttype)
            ->whereIn('radiographer_name', $radiographerName);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'acc' => DefaultValueCast::class,
        'patientid' => DefaultValueCast::class,
        'mrn' => DefaultValueCast::class,
        'name' => DefaultValueCast::class,
        'address' => DefaultValueCast::class,
        'sex' => DefaultValueCast::class,
        'birth_date' => DefaultValueCast::class,
        'weight' => DefaultValueCast::class,
        'name_dep' => DefaultValueCast::class,
        'xray_type_code' => DefaultValueCast::class,
        'prosedur' => DefaultValueCast::class,
        'dokterid' => DefaultValueCast::class,
        'named' => DefaultValueCast::class,
        'email' => DefaultValueCast::class,
        'radiographer_name' => DefaultValueCast::class,
        'dokrad_name' => DefaultValueCast::class,
        'contrast' => DefaultValueCast::class,
        'priority' => DefaultValueCast::class,
        'pat_state' => DefaultValueCast::class,
        'contrast_allergies' => DefaultValueCast::class,
        'spc_needs' => DefaultValueCast::class,
        'payment' => DefaultValueCast::class,
        'fill' => DefaultValueCast::class,
        'status' => DefaultValueCast::class,
        'num_instances' => DefaultValueCast::class,
        'num_series' => DefaultValueCast::class,
        'filmsize8' => DefaultValueCast::class,
        'filmsize10' => DefaultValueCast::class,
        'filmreject8' => DefaultValueCast::class,
        'filmreject10' => DefaultValueCast::class,
        'kv' => DefaultValueCast::class,
        'mas' => DefaultValueCast::class,
        'xray_type' => DefaultValueCast::class,
        'patienttype' => DefaultValueCast::class,
        'rephoto' => DefaultValueCast::class,
        'operator' => DefaultValueCast::class,
        'schedule_time' => DefaultValueTimeCast::class,
        'schedule_date' => DefaultValueDateCast::class,
        'complete_time' => DefaultValueTimeCast::class,
        'complete_date' => DefaultValueDateCast::class,
        'arrive_time' => DefaultValueTimeCast::class,
        'arrive_date' => DefaultValueDateCast::class,
        'approve_time' => DefaultValueTimeCast::class,
        'approve_date' => DefaultValueDateCast::class,
        'birth_date' => DefaultValueDateCast::class,
        'updated_time' => DefaultValueDateTimeCast::class,
        'create_time' => DefaultValueDateTimeCast::class
    ];

    public function getAgeAttribute()
    {
        $birthDate = $this->birth_date;
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

    public function getSpendTimeAttribute()
    {
        if ($this->status == 'APPROVED' || $this->status == 'approved') {
            $interval = strtotime($this->approve_date . ' ' . $this->approve_time) - strtotime($this->updated_time);
            $hour = floor($interval / (60 * 60));
            $minute = $interval - $hour * (60 * 60);
            $minute = $minute / 60;
            $spendTime = "{$hour} jam {$minute} menit";
        } else {
            $spendTime = '-';
        }

        return $spendTime;
    }
}
