<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationRequest extends Model
{
    protected $fillable = ['ticket_number', 'details', 'purpose', 'status', 'applicant_id'];

    // Relasi: Request milik satu Applicant
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
