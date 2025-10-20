<?php

namespace App\Http\Controllers;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Patient;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
   
    public function index(Request $request)
    {
        $wards = Ward::with(['beds.patient'])->get();
        $totalBeds = Bed::count();
        $occupied = Bed::whereNotNull('patient_id')->count();
        $available = $totalBeds - $occupied;
        $rate = $totalBeds ? round(($occupied/$totalBeds)*100, 1): 0;
        
        return view('dashboard', compact('wards', 'totalBeds', 'occupied', 'available', 'rate'));
    }
}
    