<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRequest extends AppModel
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'trip_id',
        'reason',
        'target_price',
        'status',  // [1 => new , 2 => accepted , 3 => declined , 4 => canceld from user, 5 => canceld from system ]
    ];


    protected $appends = ['is_expired', 'expired_in', 'status_txt'];

    public function getIsExpiredAttribute()
    {
        return intval(Carbon::now()->diffInMinutes($this->created_at->addHours(72)) / 60) <= 72 ? 0 : 1;
    }

    public function getExpiredInAttribute()
    {
        $all_minutes = Carbon::now()->diffInMinutes($this->created_at->addHours(72));
        $hour = intval($all_minutes / 60);
        $minutes = $all_minutes % 60;
        return $this->is_expired ? '' : $hour . ":" . $minutes;
    }

    public function statusTxt()
    {
        $status = '';
        if ($this->status == 1 && $this->is_expired) {
            $status = 'new';
        } else if ($this->status == 2) {
            $status = 'accepted';
        } else if ($this->status == 3) {
            $status = 'declined';
        } else if ($this->status == 4) {
            $status = 'canceled from user';
        } else if ($this->status == 5) {
            $status = 'canceled from system';
        } else {
            $status = 'expired';
        }
        return  $status;
    }

    public function statusBadge()
    {
        $type = '';
        if ($this->statusTxt() == 'new') {
            $type = 'warning';
        } else if ($this->statusTxt() == 'accepted') {
            $type = 'success';
        } else if ($this->statusTxt() == 'declined') {
            $type = 'danger';
        } else {
            $type = 'secondary';
        }
        return  '<span class="badge badge-' . $type . '">' . $this->statusTxt() . '</span';
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
