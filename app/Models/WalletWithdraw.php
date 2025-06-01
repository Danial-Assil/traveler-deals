<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletWithdraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'wallet_id',
        'amount',
        'trans_token',
        'email'
    ];
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
