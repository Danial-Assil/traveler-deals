<?php

namespace App\Listeners\User;

use App\Events\User\OrderDelivered;  
use App\Notifications\User\SendOrderDeliveredNotif; 

class SendOrderDeliveredNotifListener
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

    public function handle(OrderDelivered $event)
    {
        $event->deal->order->user->notify(new SendOrderDeliveredNotif($event->deal));
    }
}
