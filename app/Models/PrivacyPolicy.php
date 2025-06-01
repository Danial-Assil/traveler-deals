<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class PrivacyPolicy extends AppModel
{
    use HasFactory, Translatable;

    public $translatedAttributes = [
        'title', 'description'
    ];
}
