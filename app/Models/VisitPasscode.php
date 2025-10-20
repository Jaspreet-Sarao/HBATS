<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitPasscode extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id', 'code', 'expires_at', 'status', 'reason'];
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}