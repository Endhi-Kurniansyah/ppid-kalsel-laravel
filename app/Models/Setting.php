<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Ini PENTING agar kita bisa simpan data ke kolom 'key' dan 'value'
    protected $fillable = ['key', 'value'];
}
