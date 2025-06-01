<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends Model 
{
    use HasFactory;
    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'status',
        'type', 
        'read_at',
    ];

     
}
