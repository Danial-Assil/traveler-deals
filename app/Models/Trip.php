<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'from_place',
        'to_place',
        'from_country',
        'to_country',
        'available_weight',
        'deal_method', // [1 => by the shopper , 2 => by the traveller ]

        'departure_date',
        'departure_time',

        'arrive_date',
        'arrive_time',

        'delivery_date_from',
        'delivery_date_to',

        'pickup_place',
        'notes',
        'booking_airline',
        'booking_reference',
        'booking_first_name',
        'booking_last_name',
        'photo',
        'replied_at',
        'status', // 1 new 2 accepted 3 declined
    ];


    protected $appends = ['photo_path', 'photo_thumb_path', 'reserved_weight', 'status_txt', 'deal_method_txt'];

    public function getPhotoPathAttribute()
    {
        return $this->photo ? asset('uploads/' . $this->table . '/photos/' . $this->photo) : asset('assets/dash/img/trip.png');
    }
    public function getPhotoThumbPathAttribute()
    {
        return $this->photo ? asset('uploads/' . $this->table . '/photos/thumbs/' . $this->photo) : asset('assets/dash/img/trip.png');
    }
    public function getStatusTxtAttribute()
    {
        return $this->status == 1 && Carbon::parse($this->departure_date) >= Carbon::now()->today() ? trans('trips.inreview') : ($this->status == 2 ? trans('trips.published') : trans('trips.incomplete'));
    }
    // public function getPassportPhotoPathAttribute()
    // {
    //     return $this->photo ? asset('uploads/' . $this->table . '/passports/' . $this->photo) : asset('assets/dash/img/no-profile-img.png');
    // }
    public function getReservedWeightAttribute()
    {
        return 0;
    }
    public function getDealMethodTxtAttribute()
    {
        return $this->deal_method == 2 ? trans('orders.by_traveller')  : trans('orders.by_shopper');
    }

    public function getFrom()
    {
        return  $this->from_place;
    }

    public function getTo()
    {
        return  $this->to_place;
    }

    public function statusBadge()
    {
        $badge_color = $this->status == 1 && Carbon::parse($this->departure_date) >= Carbon::now()->today() ? 'warning' : ($this->status == 2 ? 'success' : 'info');
        return '<span class="badge badge-' . $badge_color . '">' . $this->status_txt . '</span>';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories_not_accept()
    {
        return $this->belongsToMany(Category::class, 'trip_not_categories', 'trip_id');
    }

    public function requests()
    {
        return $this->hasMany(TripRequest::class);
    }


    public function offers()
    {
        return $this->hasMany(OrderOffer::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class)->where('status', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopePublished($query)
    {
        return $query->where('status', 2);
    }
    public function scopeInActive($query)
    {
        return $query->where('status', 2)->orWhere('departure_date', '>=', Carbon::now()->today());
    }
}
