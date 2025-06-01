<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'is_used', // boolean 
        'user_id', // nullable
        'library_id',
        'course_id',
    ];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function library()
    {
        return $this->belongsTo(Library::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
