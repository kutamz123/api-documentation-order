<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveNotificationSendPacs extends Model
{
    use HasFactory;

    protected $table = "active_notification_send_pacs";

    protected $fillable = [
        'is_active_telegram',
        'is_active_mail'
    ];
}
