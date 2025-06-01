<?php

namespace App\Listeners\User;

use App\Events\User\NewTripRequest; 
use App\Notifications\User\SendNewTripRequestNotif;

class SendPayDealNotifListener
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

    public function handle(NewTripRequest $event)
    {
        $event->trip_request->trip->user->notify(new SendNewTripRequestNotif($event->trip_request));
    }
}
