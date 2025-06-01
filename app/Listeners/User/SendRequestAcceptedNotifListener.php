<?php

namespace App\Listeners\User;

use App\Events\User\TripRequestAccepted;
use App\Notifications\User\SendTripRequestAcceptedNotif;

class SendRequestAcceptedNotifListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RequestAccepted  $event
     * @return void
     */
    public function handle(TripRequestAccepted $event)
    {
        $event->trip_request->order->user->notify(new SendTripRequestAcceptedNotif($event->trip_request));

    }
}
