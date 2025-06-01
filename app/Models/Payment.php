<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'type', // 1 => by wallet,  2 => electronic 
        'trans_token', // nullable if wallet payment 
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
