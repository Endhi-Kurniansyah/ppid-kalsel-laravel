<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'nik_ktp',
        'name',
        'email',
        'phone',
        'address',
        'job',
        'type',
        'ktp_file_path'
    ];

    // Relasi: Pemohon bisa punya banyak Request
    public function informationRequests()
    {
        return $this->hasMany(InformationRequest::class);
    }
}
