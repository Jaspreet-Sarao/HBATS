<?php

namespace App\Http\Controllers;
use App\Models\Patient;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DischargeController extends Controller
{
   
    public function form()
    {
        return view('discharge');
    }
    public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|max:255']);
        $q = $request->q;
        
        $patient = Patient::with('bed.ward')
            ->where('name', 'like', "%{$q}%")
            ->orWhere('patient_identifier', 'like', "%{$q}%")
            ->orWhereHas('bed', function($query) use ($q) {
                $query->where('bed_number', 'like', "%{$q}%");
            })
            ->whereNull('discharged_at') // Only show patients who haven't been discharged
            ->first();
            
        if (!$patient) {
            return view('discharge')->with('error', 'No active patient found matching your search.');
        }
        
        return view('discharge', compact('patient', 'q'));
    }
    public function complete(Request $request, Patient $patient)
    {
        // Validate the request
        $request->validate([
            'discharge_time' => 'required|date',
            'discharge_type' => 'required|in:home,transfer,ama,deceased',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Check if patient is already discharged
        if ($patient->discharged_at) {
            return redirect()->route('discharge.form')->with('error', 'Patient has already been discharged.');
        }

        // Update patient discharge information
        $patient->update([
            'discharged_at' => $request->discharge_time,
            'discharge_type' => $request->discharge_type,
            'discharge_notes' => $request->notes
        ]);

        // Free up the bed
        if ($patient->bed) {
            $patient->bed->update(['patient_id' => null]);
        }

        // Invalidate all active passcodes
        $patient->passcodes()->where('status', 'active')->update(['status' => 'invalid']);

        return redirect()->route('dashboard')->with('success', 'Patient discharged successfully.');
    }
    }