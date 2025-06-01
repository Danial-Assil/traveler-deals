<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends AppModel
{
    use HasFactory;
    protected $guard = 'teacher'; 
    protected $guarded = ['id'];
    protected $fillable  = [
        'username',
        'password',
        'name',
        'short_description',
        'email',
        'mobile',
        'image',
        'status'
    ];

    protected $hidden = [
        'password',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
