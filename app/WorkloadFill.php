<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkloadFill extends Model
{
    use HasFactory;

    protected $primaryKey = "pk";

    protected $fillable = [
        "uid",
        "fill",
        "is_default"
    ];

    protected $table = "xray_workload_fill";

    protected $hidden = [
        "pk"
    ];

    public $timestamps = false;

    public function workload()
    {
        return $this->hasOne(Workload::class, 'uid', 'uid');
    }
}
