<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class ContactUs extends AppModel
{
    use HasFactory, Translatable;

    protected $fillable = [
        'email',
        'phone',
        'mobile',
        'fax',
        'map',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    public $translatedAttributes = [
        'title',
    ];
    
    
}