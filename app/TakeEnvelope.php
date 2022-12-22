<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeEnvelope extends Model
{
    use HasFactory;

    protected $primaryKey = "pk";

    protected $fillable = [
        "pk",
        "uid",
        "name",
        "is_taken",
        "created_at"
    ];

    protected $table = "xray_take_envelope";
}
