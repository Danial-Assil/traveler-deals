<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends AppModel
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'category_id',
        'with_box',
        'link',
        'name',
        'quantity',
        'price',
        'weight',
        'photo',
        'unit' // [ 1 => g , 2 => kg ]
    ];

    protected $appends = ['status_txt', 'unit_txt'];


    public function getUnitTxtAttribute()
    {
        return $this->unit == 1  ? 'kg' : 'g';
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(OrderItemImage::class);
    }
}
