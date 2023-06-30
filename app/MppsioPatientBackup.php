<?php

namespace App;

use App\Casts\DefaultValueCast;
use App\Casts\DefaultValueDateCast;
use App\Casts\DefaultValueDateTimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MppsioPatientBackup extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
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
        "updated_time",
        "created_time",
    ];

    protected $table = "mppsio_patient_backup";

    protected $hidden = [
        "pat_attrs"
    ];

    public $timestamps = false;

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
        'updated_time' => DefaultValueDateTimeCast::class,
        'created_time' => DefaultValueDateTimeCast::class,
    ];
}
