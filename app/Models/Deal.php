<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends AppModel
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'trip_id',
        'qr_code', // unique
        'dealable_id',
        'dealable_type',
        'reward',
        'amount',
        'estimated_total',
        'traveler_payed',  // 1 => traveler has payed , 0 => no  (default)
        'traveler_payed_at',  // datetime of traveler has payed
        'shopper_payed', // 0 => no (default) , 1 => yes
        'shopper_payed_at', // null (default)
        'shopper_rated',
        'traveler_rated',
        'status' // 0 => canceled , 1 => active , 2 => payed,  3 => picked , 4 => delivered 
    ];

    protected $appends = ['status_txt', 'from', 'to'];
    public function getStatusTxtAttribute()
    {
        return $this->status != 0 ? ($this->status == 1 ? trans('orders.active') : ($this->status == 2 ? trans('orders.picked') : trans('orders.delevered'))) : trans('orders.canceled');
    }
    public function getFromAttribute()
    {
        return $this->trip->from_country . ', ' . $this->trip->from_city;
    }

    public function getToAttribute()
    {
        return $this->trip->to_country . ', ' . $this->trip->to_city;
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user_trip()
    {
        return $this->trip->user;
    }

    public function user_order()
    {
        return $this->order->user;
    }

    public function dealableble()
    {
        return $this->morphTo();
    }

    public function statuses()
    {
        return $this->hasMany(DealStatus::class);
    }

    // 1 => The shopper has made the payment.  // type 1 => Shopper

    // 2 => The Traveler picked up the item.  // type 2 => Traveler

    // 3 => The shopper confirmed the delivery.  // type 1 => Shopper

    // 4 => Rate the shopper  // type 1 => Shopper
    // 4 => Rate the traveler  // type 2 => Traveler

    public function next_steps()
    {
        $steps = [
            'The Traveler picked up the item.',
            'The shopper confirmed the delivery.', 
        ];
        // cancel 
        if ($this->status == 4 || $this->statuses->max('new_status') > 4) {
            return [];
        }
        if ($this->order->deal_method == 1) {
            array_unshift($steps, 'The Traveler has made the payment.');
        }

        if ($this->statuses->max('new_status') == 4)
            return array_splice($steps, 3);
        if ($this->statuses->max('new_status') == 3)
            return array_splice($steps, 2);
        else if ($this->statuses->max('new_status') == 2)
            return array_splice($steps, 1);
        return $steps;
    }
}
