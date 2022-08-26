<?php

namespace App;

use App\Study;
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

    public function study()
    {
        return $this->hasOne(Study::class, 'patient_fk', 'pk');
    }
}
