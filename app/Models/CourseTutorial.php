<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CourseTutorial extends AppModel
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable  = ['title', 'short_description', 'description', 'image', 'video', 'course_id', 'item_order', 'status'];
    protected $appends = ['image_path', 'image_thumb_path', 'image_folder', 'video_path', 'video_thumb_path', 'video_folder', 'duration'];
    public function getImageFolderAttribute()
    {
        return $this->image ? $this->course->image_folder . '/tutorials' : null;
    }

    public function getVideoPathAttribute()
    {
        return $this->video ? asset($this->video_folder  . '/' . $this->video)  : null;
    }

    public function getVideoThumbPathAttribute()
    {
        return $this->video ? asset($this->video_folder . '/thumbs/' . $this->video) : null;
    }

    public function getVideoFolderAttribute()
    {
        return $this->video ?  asset('/dash/courses/' . $this->course->id . '/tutorials')  : null;
    }

    public function getDurationAttribute()
    {
        $getID3 = new \getID3;
        $file = $getID3->analyze( storage_path('app/courses/' . $this->course_id  . '/tutorials/' . $this->video));
        // storage_path('app/courses/' . $id  . '/tutorials/' . $filename)
        $duration = '';
        $durationInSeconds = isset($file['playtime_seconds']) ? ceil($file['playtime_seconds']) : 0;
        $days = floor($durationInSeconds / 86400);
        $durationInSeconds -= $days * 86400;
        $hours = floor($durationInSeconds / 3600);
        $durationInSeconds -= $hours * 3600;
        $minutes = floor($durationInSeconds / 60);
        $seconds = $durationInSeconds - $minutes * 60;

        if ($days > 0) {
            $duration .= $days . ' ' . trans('dash.days');
        }
        if ($hours > 0) {
            $duration .= ' ' . $hours . ' ' . trans('dash.hours');
        }
        if ($minutes > 0) {
            $duration .= ' ' . $minutes . ' ' . trans('dash.minutes');
        }
        if ($seconds > 0) {
            $duration .= ' ' . $seconds . ' ' . trans('dash.seconds');
        }
        return $duration;
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
