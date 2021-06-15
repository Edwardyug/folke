<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIPublicationProperties extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'text',
        'publicationID',
    ];
}
