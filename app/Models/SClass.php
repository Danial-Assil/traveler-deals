<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SClass extends AppModel
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['title', 'item_order', 'status'];
    
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
