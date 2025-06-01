<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'course_id', 'user_id', 'status',
        'enrollmentable_id', 'enrollmentable_type' // by code 
    ];

    protected $appends = ['method', 'method_txt'];

    public function getMethodAttribute()
    {
        return $this->enrollmentable_type == 'App\Models\Code' ? 1 : 2;
    }
    public function getMethodTxtAttribute()
    {
        return $this->method == 1 ? 'By Code' : '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
