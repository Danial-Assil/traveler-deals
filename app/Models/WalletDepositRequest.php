<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletDepositRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'wallet_id',
        'amount',
        'full_name',
        'whatsapp_number',
        'pref_payment_method',
        'payment_method', // actual payment method
        'country',
    ];
}
