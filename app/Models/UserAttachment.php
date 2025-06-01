<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type', // type of attachment [ id - passport ]
        'file',
        'verified_at',
        'is_verified', // if the attach accepted
        'reply_txt', // reply from the admin if the attach rejected
        'replyed_at',
    ];

    protected $appends = ['file_path', 'file_folder', 'file_thumb_path'];

    public function getFilePathAttribute()
    {
        return $this->file ? route('storage.file', [$this->file_folder,  $this->file]) : asset('assets/dash/img/trip.png');
    }
    public function getFileThumbPathAttribute()
    {
        return $this->file ? route('storage.file', [$this->file_folder,   $this->file]) : asset('assets/dash/img/trip.png');
    }
    public function getFileFolderAttribute()
    {
        return 'users/' . $this->user_id . '/' . $this->type;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
