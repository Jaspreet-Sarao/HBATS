<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'patient_identifier', 'contact', 'emergency_contact', 'admission_notes', 'admitted_at', 'discharged_at', 'discharge_type', 'discharge_notes'];
    
    protected $casts = [
        'admitted_at' => 'datetime',
        'discharged_at' => 'datetime',
    ];
    public function bed()
    {
        return $this->hasOne(Bed::class);
    }
    public function passcodes()
    {
        return $this->hasMany(VisitPasscode::class);
    }
    public function getIsAdmittedAttribute()
    {
        return is_null($this->discharged_at);
    }
}
