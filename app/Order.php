<?php

namespace App;

use App\Casts\DefaultValueCast;
use App\Casts\DefaultValueDateCast;
use App\Casts\DefaultValueTimeCast;
use App\Casts\DefaultValueDateTimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pk';

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
        "dep_id",
        "name_dep",
        "id_modality",
        "xray_type_code",
        "id_prosedur",
        "prosedur",
        "harga_prosedur",
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
        "id_payment",
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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
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

    public function dokterRadiology()
    {
        return $this->hasOne(DokterRadiology::class, "dokradid", "dokradid");
    }
}
