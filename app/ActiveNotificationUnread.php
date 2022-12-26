<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveNotificationUnread extends Model
{
    use HasFactory;

    protected $table = "active_notification_unread";

    protected $fillable = [
        'is_active'
    ];
}
