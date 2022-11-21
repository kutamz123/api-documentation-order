<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = "xray_department";

    protected $fillable = [
        'dep_id',
        'name_dep'
    ];
}
