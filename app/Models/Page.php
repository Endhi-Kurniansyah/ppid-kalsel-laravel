<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    // HANYA INI SAJA ISINYA.
    // JANGAN tulis: protected $content; (HAPUS BARIS INI)

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'is_static', // Jika ada
        'is_locked', // <--- TAMBAHKAN INI
    ];
}
