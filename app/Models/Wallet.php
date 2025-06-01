<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deposits()
    {
        return $this->hasMany(WalletDeposit::class);
    } 
    public function withdraws()
    {
        return $this->hasMany(WalletWithdraw::class);
    } 
}
