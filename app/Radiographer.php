<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radiographer extends Model
{
    use HasFactory;

    protected $table = "xray_radiographer";

    protected $fillable = [
        'radiographer_id',
        'radiographer_name',
        'radiographer_lastname',
        'radiographer_sex',
        'radiographer_tlp',
        'username',
        'radiographer_email',
        'password'
    ];

    protected $hidden = [
        "username", "password"
    ];
}
