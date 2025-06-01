<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealStatus extends AppModel
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'new_status',
        'type', // [ 1 => Shopper ,2 => Traveler]
        'status'
    ];


    /*
        [ 
           
            1 => The shopper has made the payment.  // type 1 => Shopper
 
            2 => The Traveler has made the payment.  // type 2 => Traveler
 
            3 => The Traveler picked up the item.  // type 2 => Traveler

            4 => The shopper confirmed the delivery.  // type 1 => Shopper

            5 => Rate the traveler  // type 1 => Shopper
            5 => Rate the shopper  // type 2 => Traveler

            6 => The order was not delivered to the Traveler  // type 2 => Traveler

            7 => There is an issue with receiving the order   // type 2 => Traveler

            8 => The shopper canceled the offer  // type 1 => Shopper
            8 => The traveler canceled the request // type 2 => Traveler

        ]
        */

    protected $appends = ['status_txt'];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function deal_txt()
    {
        $txt = '';
        if ($this->new_status == 1) {
            $txt = 'The shopper has made the payment.';
        } else if ($this->new_status == 2) {
            $txt = 'The Traveler has made the payment.';
        } else if ($this->new_status == 3) {
            $txt = 'The Traveler picked up the item.';
        } else if ($this->new_status == 4) {
            $txt = 'The shopper confirmed the delivery.';
        } else if ($this->new_status == 5 && $this->type == 1) {
            $txt = 'Rate the shopper.';
        } else if ($this->new_status == 5 && $this->type == 2) {
            $txt = 'Rate the traveler.';
        } else if ($this->new_status == 6) {
            $txt = 'The order was not delivered to the Traveler.';
        } else if ($this->new_status == 7) {
            $txt = 'There is an issue with receiving the order ';
        } else if ($this->new_status == 8) {
            if ($this->type == 1) {
                $txt = 'The shopper canceled the offer.';
            } else {
                $txt = 'The traveler canceled the request.';
            }
        }
        return $txt;
    }
}
