<?php

namespace App\Listeners\User;
 
use App\Events\User\TravelerPayedOrder;
use App\Notifications\User\SendTravelerPayedOrderNotif;

class SendTravelerPayedOrderNotifListener
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

    public function handle(TravelerPayedOrder $event)
    {
        $event->deal->order->user->notify(new SendTravelerPayedOrderNotif($event->deal));
    }
}
