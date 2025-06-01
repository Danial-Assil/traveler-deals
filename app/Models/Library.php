<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Library extends AppModel
{

    protected $guarded = ['id'];
    protected $fillable  = ['title', 'description', 'address', 'image', 'mobile', 'status'];
    protected $hidden = [
        'editable', 'deleteable', 'created_by', 'updated_by', 'status', 'created_at', 'updated_at', 'image_folder', 'image', 'codes'
    ];
    public function codes()
    {
        return $this->hasMany(CourseCode::class);
    }
}
