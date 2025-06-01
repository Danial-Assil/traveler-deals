<?php

namespace App\Models;


class ReviewRating extends AppModel
{

    protected $fillable = [
        'deal_id',
        'user_id',  // the user that rating the other user 
        'rated_id',
        'comment',
        'star_rating',
        'status'
    ];

    // user that rated  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // user that was rated
    public function rated()
    {
        return $this->belongsTo(User::class, 'rated_id', 'id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
