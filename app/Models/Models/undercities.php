<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class undercities extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'city_id',
    ];
}
