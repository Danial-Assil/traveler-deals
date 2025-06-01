<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends AppModel
{
    use HasFactory ;
    protected $fillable = [
        'link',
        'type',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ]; 
}