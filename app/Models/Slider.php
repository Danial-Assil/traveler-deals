<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends AppModel
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable  = ['image'];
}
