<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends AppModel
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['title', 'short_description', 's_class_id', 'image', 'item_order', 'status'];
  
    public function s_class()
    {
        return $this->belongsTo(SClass::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
