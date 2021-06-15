<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIUnderCategories extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'category',
    ];
}
