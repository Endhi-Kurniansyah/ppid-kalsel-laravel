<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'parent_id', 'order', 'is_active'];

    // RELASI: Menu ini punya banyak Anak (Sub-menu)
    public function children()
    {
        // Diurutkan berdasarkan 'order' biar rapi
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order', 'asc');
    }

    // RELASI: Menu ini punya satu Induk (Parent)
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // FUNGSI BANTUAN: Cek apakah menu ini punya anak?
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
}
