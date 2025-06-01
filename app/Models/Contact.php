<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends AppModel
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'email',
        'subject',
        'message',
        'status', 
    ];

    protected $appends = [ 'status_txt'];
    public function getStatusTxtAttribute()
    {
        return  $this->status == 1 ? "&#10003; " . trans('contacts.answered') : "&#9203; " . trans('contacts.waiting');
    }

 
}
