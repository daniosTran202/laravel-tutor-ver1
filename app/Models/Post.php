<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['id', 'authorId', 'parentId', 'title', 'metaTitle', 'slug', 'summary', 'published', 'createdAt', 'updatedAt', 'publishedAt', 'content'];
}
