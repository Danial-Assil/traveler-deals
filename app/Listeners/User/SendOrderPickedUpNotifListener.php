<?php

namespace App\Listeners\User;
 
use App\Events\User\OrderPickedUp; 
use App\Notifications\User\SendOrderPickedUpNotif;

class SendOrderPickedUpNotifListener
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

    public function handle(OrderPickedUp $event)
    {
        $event->order->user->notify(new SendOrderPickedUpNotif($event->order));
    }
}
