<?php

namespace App;

use App\Study;
use Illuminate\Support\Str;
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
        "pat_attrs"
    ];

    /**
     * Menghilangkan karakter ^^^^ pada kolom pat_name
     */
    public function getPatNameAttribute($value)
    {
        return Str::replaceLast("^^^^", "", $value);
    }

    /**
     * Mengubah format d-m-Y kolom pat_birthdate
     */
    public function getPatBirthdateAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    /**
     * Mengubah format d-m-Y kolom updated_time
     */
    public function getUpdatedTimeAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function study()
    {
        return $this->hasOne(Study::class, 'patient_fk', 'pk');
    }
}
