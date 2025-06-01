<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class QuestionOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id', 'user_id', 'status',
        'enrollmentable_id', 'enrollmentable_type' // by code 
    ]; 
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
