<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIPhotos extends Model
{
    use HasFactory;
    protected $fillable = [
        'publications',
        'link_img',
    ];
}
