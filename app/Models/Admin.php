<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $guard = 'dash';

    protected $fillable = [
        'image',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'fcm_token'
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return $this->image ? asset('uploads/' . $this->table . '/' . $this->image) : asset('assets/dash/img/no-profile-img.png');
    }
}
