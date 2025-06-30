<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'description', 'files', 'cover_image', 'slug', 'category','file_path'];

    protected $casts = [
        'files' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
