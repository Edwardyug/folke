<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APICity extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
    ];
}
