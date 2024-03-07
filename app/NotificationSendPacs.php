<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSendPacs extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'to',
        'count',
        'response'
    ];

    protected $table = "notification_send_pacs";
}
