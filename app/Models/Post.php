<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'image', 'views', 'user_id', 'category_id'];

    // Relasi: Berita dimiliki oleh satu User (Penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Berita masuk ke satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
