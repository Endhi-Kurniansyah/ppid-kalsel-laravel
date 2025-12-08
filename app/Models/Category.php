<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'type'];

    // Relasi: Satu kategori bisa punya banyak berita
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Relasi: Satu kategori bisa punya banyak dokumen
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
