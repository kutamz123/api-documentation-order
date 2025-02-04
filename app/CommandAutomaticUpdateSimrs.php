<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandAutomaticUpdateSimrs extends Model
{
    use HasFactory;

    protected $table = "command_automatic_update_simrs";

    protected $guarded = [
        'pk'
    ];
}
