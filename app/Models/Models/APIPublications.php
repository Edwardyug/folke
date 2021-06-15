<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIPublications extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'title',
        'description',
        'price',
        'icon',
        'address',
        'lat',
        'lon',
        'img_map',
        'slug',
        'user',
        'under_category',
        'stop_publish_at',
        'publish_at',
        'is_published',
        ];
}
