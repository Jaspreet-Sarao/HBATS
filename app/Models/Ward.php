<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'total_beds'];
    public function beds()
    {
        return $this->hasMany(Bed::class);
    }
    public function availableBeds()
    {
        return $this->beds()->whereNull('patient_id');
    }
    public function occupiedBeds()
    {
        return $this->beds()->whereNotNull('patient_id');
    }
}

