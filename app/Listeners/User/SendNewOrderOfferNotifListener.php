<?php

namespace App\Listeners\User;

use App\Events\User\NewOrderOffer;
use App\Notifications\User\SendNewOrderOfferNotif;


class SendNewOrderOfferNotifListener
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

    public function handle(NewOrderOffer $event)
    {
        $event->order_offer->order->user->notify(new SendNewOrderOfferNotif($event->order_offer));
    }
}
