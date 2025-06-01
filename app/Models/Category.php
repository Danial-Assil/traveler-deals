<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Category extends AppModel
{
    use HasFactory, Translatable;
    
    protected $appends = [];
    protected $fillable = ['id'];
    public $translatedAttributes = [
        'title',
    ];
}
