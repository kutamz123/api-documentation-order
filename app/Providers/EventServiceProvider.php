<?php

namespace App\Providers;

use App\Order;
use App\Events\SimrsRisEvent;
use App\Events\MiddlewareEvent;
use App\Events\RisModalityEvent;
use App\Observers\OrderObserver;
use App\Events\ModalityPacsEvent;
use App\Listeners\LogTxtListener;
use App\Events\AuthenticationEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\LogSlackSimrsRisListener;
use App\Listeners\LogNotificationTxtListener;
use App\Listeners\LogSlackRisModalityListener;
use App\Listeners\LogSlackModalityPacsListener;
use App\Listeners\CreateNotificationUnreadListener;
use Illuminate\Notifications\Events\NotificationSent;
use App\Listeners\LogSlackAuthenticationTokenListener;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AuthenticationEvent::class => [
            LogTxtListener::class,
            // LogSlackAuthenticationTokenListener::class
        ],
        SimrsRisEvent::class => [
            LogTxtListener::class,
            // tidak menggunakan queue
            LogSlackSimrsRisListener::class,
        ],
        RisModalityEvent::class => [
            LogTxtListener::class,
            // LogSlackRisModalityListener::class
        ],
        ModalityPacsEvent::class => [
            LogTxtListener::class,
            // LogSlackModalityPacsListener::class
        ],
        NotificationSent::class => [
            LogNotificationTxtListener::class,
            CreateNotificationUnreadListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        parent::boot();
    }
}
