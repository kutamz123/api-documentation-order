<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
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
    protected $table = 'pacsio.study';

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

    protected $fillable = [
        "accession_no",
        "ref_physician",
        "study_desc",
        "mods_in_study"
    ];
}
