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
        'fill' => DefaultValueCast::class,
        'approved_at' => DefaultValueDateTimeCast::class,
        'approve_updated_at' => DefaultValueDateTimeCast::class,
        'priority_doctor' => DefaultValueCast::class
    ];

    public function getSpendTimeAttribute()
    {
        if ($this->status == 'APPROVED' || $this->status == 'approved') {
            $interval = strtotime($this->approved_at) - strtotime($this->updated_time);
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
