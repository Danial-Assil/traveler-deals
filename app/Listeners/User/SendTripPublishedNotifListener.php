<?php

namespace App\Listeners\User;

use App\Events\User\TripPublished; 
use App\Notifications\User\SendTripPublishedNotif; 

class SendTripPublishedNotifListener
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
    public function handle(TripPublished $event)
    {
        $event->trip->user->notify(new SendTripPublishedNotif($event->trip));

    }
}
