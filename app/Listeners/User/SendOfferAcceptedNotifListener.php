<?php

namespace App\Listeners\User;

use App\Events\User\OrderOfferAccepted;
use App\Notifications\User\SendOrderOfferAcceptedNotif; 

class SendOfferAcceptedNotifListener
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
    public function handle(OrderOfferAccepted $event)
    {
        $event->order_offer->order->user->notify(new SendOrderOfferAcceptedNotif($event->order_offer));

    }
}
