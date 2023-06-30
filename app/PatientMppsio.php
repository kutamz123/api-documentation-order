<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMppsio extends Model
{
    use HasFactory;

    protected $connection = 'mppsio';

    protected $table = 'patient';

    protected $primaryKey = 'pk';

    public $timestamps = false;

    protected $hidden = [
        "pat_attrs"
    ];
}
