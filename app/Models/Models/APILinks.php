<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APILinks extends Model
{
    use HasFactory;
    protected $fillable = [
        'user',
        'link',
        'type',
    ];
}
