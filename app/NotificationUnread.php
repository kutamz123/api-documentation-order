<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUnread extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'to',
        'count'
    ];

    protected $table = "notification_unread";
}
