<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mwlitem extends Model
{
    protected $connection = 'mppsio';

    protected $table = 'mwl_item';

    protected $primaryKey = 'pk';

    protected $hidden = [
        'item_attrs'
    ];

    public function patient()
    {
        return $this->hasOne(PatientMppsio::class, 'pk', 'patient_fk');
    }
}
