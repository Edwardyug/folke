<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class templates_undercategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'category',
        'control',
    ];
}
