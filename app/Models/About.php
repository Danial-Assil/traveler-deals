<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class About extends AppModel
{
    use HasFactory, Translatable;
    
    public $translatedAttributes = [
        'title',
    ];

}
