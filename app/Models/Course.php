<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends AppModel
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable  = ['title', 'short_description', 'description', 'qr_code', 'cost', 'status', 'image', 'subject_id', 'teacher_id'];
    protected $appends = ['image_path', 'image_thumb_path', 'image_folder'];
    public function getImageFolderAttribute()
    {
        return $this->image ?  'uploads/courses/' . $this->id  : null;
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function tutorials()
    {
        return $this->hasMany(CourseTutorial::class);
    }
    public function ratings()
    {
        return $this->belongsToMany(User::class, 'course_ratings')->withPivot('rating');
    }
    public function codes()
    {
        return $this->hasMany(CourseCode::class);
    }
}
