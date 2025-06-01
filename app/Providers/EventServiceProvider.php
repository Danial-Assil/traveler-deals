<?php

namespace App\Providers;

use App\Events\User\NewOrderOffer;
use App\Events\User\NewTripRequest;
use App\Events\User\OrderOfferAccepted;
use App\Events\User\OrderPayed;
use App\Events\User\OrderPickedUp;
use App\Events\User\TravelerPayedOrder;
use App\Events\User\TripPublished;
use App\Events\User\TripRequestAccepted;
use App\Listeners\User\SendNewOrderOfferNotifListener;
use App\Listeners\User\SendNewTripRequestNotifListener;
use App\Listeners\User\SendOfferAcceptedNotifListener;
use App\Listeners\User\SendOrderPayedNotifListener;
use App\Listeners\User\SendOrderPickedUpNotifListener;
use App\Listeners\User\SendRequestAcceptedNotifListener;
use App\Listeners\User\SendTravelerPayedOrderNotifListener;
use App\Listeners\User\SendTripPublishedNotifListener; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        OrderPayed::class => [
            SendOrderPayedNotifListener::class,
        ],
        TravelerPayedOrder::class => [
            SendTravelerPayedOrderNotifListener::class,
        ],
        OrderPickedUp::class => [
            SendOrderPickedUpNotifListener::class,
        ],
        TripPublished::class => [
            SendTripPublishedNotifListener::class,
        ],
        TripRequestAccepted::class => [
            SendRequestAcceptedNotifListener::class,
        ],
        NewTripRequest::class => [
            SendNewTripRequestNotifListener::class,
        ],
        OrderOfferAccepted::class => [
            SendOfferAcceptedNotifListener::class,
        ],
        NewOrderOffer::class => [
            SendNewOrderOfferNotifListener::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
