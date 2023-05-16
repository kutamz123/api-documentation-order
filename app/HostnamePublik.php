<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostnamePublik extends Model
{
    use HasFactory;

    protected $table = "xray_hostname_publik";

    protected $fillable = [
        "ip_publik",
    ];
}
