<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends AppModel
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'from_place',
        'to_place',
        'from_country',
        'to_country',
        'before_date',
        'name',
        'reward', // traveler reward
        'deal_method', // [1 => by the shopper , 2 => by the traveller ] 
        'total_weight',
        'total_price',
        'fees', // our fees
        'payment_processing', // payment processing for deal_method 
        'estimated_total', // total value
        'notes',
        'status', // 1 => new , 2 => reserved , 3 => in_transit , 4 => received , 5 => inactive
    ];

    protected $appends = ['image_path', 'image_path_thumb', 'status_txt', 'delivery_type_txt', 'deal_method_txt'];

    public function getImagePathThumbAttribute()
    {
        return count($this->order_items) > 0 && count($this->order_items->first()->images) > 0 ? $this->order_items->first()->images->first()->image_thumb_path : asset('assets/dash/img/order.png');
    }

    public function getImagePathAttribute()
    {
        return count($this->order_items) > 0 && count($this->order_items->first()->images) > 0 ? $this->order_items->first()->images->first()->image_path : asset('assets/dash/img/order.png');
    }

    public function getDeliveryTypeTxtAttribute()
    {
        return $this->delivery_type == 1 ? trans('orders.face_to_face')  : trans('orders.by_shopper');
    }
    public function getDealMethodTxtAttribute()
    {
        return $this->deal_method == 2 ? trans('orders.by_traveller')  : trans('orders.by_shopper');
    }

    public function getStatusTxtAttribute()
    {
        return $this->status != 5 ? ($this->status == 1 ? trans('orders.new') : ($this->status == 2 ? trans('orders.reserved') : ($this->status == 3 ? trans('orders.order_in_transit') : trans('orders.order_received')))) : trans('orders.inactive');
    }

    public function getFrom()
    {
        return  $this->from_place;
    }

    public function getTo()
    {
        return  $this->to_place;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function current_deal()
    {
        return $this->deals->where('status', '!=', 0)->first();
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }



    public function offers()
    {
        return $this->hasMany(OrderOffer::class);
    }

    public function requests()
    {
        return $this->hasMany(TripRequest::class);
    }
}
