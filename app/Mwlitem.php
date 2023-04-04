<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mwlitem extends Model
{
    // protected $fillable = ['pk', 'patient_fk', 'study_iuid', 'accession_no', 'modality'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'study_iuid';

    protected $table = 'mwl_item';

    protected $connection = 'mppsio';

    protected $hidden = [
        "sps_status",
        "station_name",
        "perf_phys_fn_sx",
        "perf_phys_gn_sx",
        "perf_phys_i_name",
        "perf_phys_p_name",
        "item_attrs"
    ];
}
