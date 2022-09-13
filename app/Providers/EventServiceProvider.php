<?php

namespace App\Providers;

use App\Events\MiddlewareEvent;
use App\Listeners\LogTxtListener;
use App\Events\AuthenticationEvent;
use App\Events\RisModalityEvent;
use App\Events\SimrsRisEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\LogSlackAuthenticationTokenListener;
use App\Listeners\LogSlackRisModalityEvent;
use App\Listeners\LogSlackSimrsRisListener;
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
        MiddlewareEvent::class => [
            LogTxtListener::class
        ],
        AuthenticationEvent::class => [
            LogTxtListener::class,
            LogSlackAuthenticationTokenListener::class
        ],
        SimrsRisEvent::class => [
            LogSlackSimrsRisListener::class
        ],
        RisModalityEvent::class => [
            LogTxtListener::class,
            LogSlackRisModalityEvent::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
