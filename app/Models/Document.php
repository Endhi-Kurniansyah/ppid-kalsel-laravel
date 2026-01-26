<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // === BAGIAN PENTING ===
    // Kita harus mengizinkan kolom 'category' untuk diisi.
    // Pastikan 'category_id' diganti jadi 'category'.

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'category', // <-- INI KUNCINYA (Dulu category_id)
        // 'user_id', // Kita hapus dulu biar gak ribet login
        // 'published_date' // Kita hapus karena pakai created_at
    ];

    // Hapus atau Komentari fungsi relasi di bawah ini
    // karena tabel category dan users sudah tidak kita hubungkan lagi

    /* public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    */
}
