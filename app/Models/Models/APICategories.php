<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APICategories extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'city',
        'title',
        'icon',
        'slug',
    ];
}
