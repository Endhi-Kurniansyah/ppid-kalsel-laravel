<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationRequest extends Model
{
    use HasFactory;

    // Kita masukkan SEMUA kolom agar bisa diisi (Mass Assignment)
    protected $fillable = [
        // Data Diri
        'name',
        'nik',
        'ktp_file',
        'email',
        'phone',
        'address',
        'job',

        // Data Request
        'ticket_number',
        'details',
        'purpose',
        'get_method',
        'delivery_method',

        // Admin
        'status',
        'admin_note',
        'reply_file',
    ];

    // HAPUS function applicant() karena kita tidak pakai tabel applicant terpisah lagi.

    // Opsional: Helper untuk warna status badge di Admin Panel nanti
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark', // Kuning (Menunggu)
            'processed' => 'bg-info text-dark',  // Biru Muda (Diproses)
            'finished' => 'bg-success',          // Hijau (Selesai)
            'rejected' => 'bg-danger',           // Merah (Ditolak)
            default => 'bg-secondary',
        };
    }
    public function objection()
    {
        return $this->hasOne(Objection::class);
    }
}
