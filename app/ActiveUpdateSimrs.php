<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveUpdateSimrs extends Model
{
    use HasFactory;

    protected $table = "active_update_simrs";

    protected $fillable = [
        'is_active'
    ];
}
