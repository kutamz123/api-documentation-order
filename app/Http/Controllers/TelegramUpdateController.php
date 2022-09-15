<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NotificationChannels\Telegram\TelegramUpdates;

class TelegramUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Response is an array of updates.
        $updates = TelegramUpdates::create()
            // (Optional). Get's the latest update. NOTE: All previous updates will be forgotten using this method.
            // ->latest()

            // (Optional). Limit to 2 updates (By default, updates starting with the earliest unconfirmed update are returned).
            ->limit()

            // (Optional). Add more params to the request.
            ->options([
                'timeout' => 0,
            ])
            ->get();

        dd($updates);
    }
}
