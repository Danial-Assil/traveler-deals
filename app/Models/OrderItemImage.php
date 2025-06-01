<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrderItemImage extends AppModel
{
    use HasFactory;
    protected $fillable = [
        'order_item_id',
        'image',
    ];

    protected $appends = ['image_path', 'image_thumb_path', 'image_folder'];
    public function getImagePathAttribute()
    {
        return $this->image ? asset($this->image_folder . '/' . $this->image) : asset('assets/dash/img/no-profile-img.png');
    }
    public function getImageThumbPathAttribute()
    {
        return $this->image ? asset($this->image_folder . '/thumbs/' . $this->image) :  asset('assets/dash/img/no-profile-img.png');
    }

    public function getImageFolderAttribute()
    {
        return  'uploads/orders/' . Carbon::parse($this->created_at)->format('Y-m');
    }

    public function order_item()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
