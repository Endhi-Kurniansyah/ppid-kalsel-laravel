<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_request_id',
        'objection_code',
        'reason',
        'description',
        'status',
        'admin_note'
    ];

    // Relasi: Setiap keberatan pasti punya 1 data permohonan asal
    public function request()
    {
        return $this->belongsTo(InformationRequest::class, 'information_request_id');
    }
}
