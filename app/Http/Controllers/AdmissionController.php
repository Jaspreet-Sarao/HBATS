<?php

namespace App\Http\Controllers;
use App\Models\Ward;
use App\Models\Patient;
use App\Models\Bed;
use App\Models\VisitPasscode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdmissionController extends Controller
{
    public function form()
    {
      $wards =Ward::with('availableBeds')->get();
      return view('admission',compact('wards'));
    }
    public function store(Request $request)
    {
       $data = $request->validate([
        'bed_id' => ['required', Rule::exists('beds', 'id')->whereNull('patient_id')],
        'name' => 'required|string|max:255',
        'contact' => 'nullable|string|max:20',
        'emergency_contact' => 'nullable|string|max:20',
        'admission_notes' => 'nullable|string|max:1000',
        'passcode_duration' => 'required|in:24,48,72,168',
       ]);
       $patient = Patient::create([
        'name' => $data['name'],
        'patient_identifier' => strtoupper('PAT-' . str()->random(6)),
        'contact' => $data['contact'] ?? null,
        'emergency_contact' => $data['emergency_contact'] ?? null,
        'admission_notes' => $data['admission_notes'] ?? null,
        'admitted_at' => now(),
       ]);
       $bed = Bed::findOrFail($data['bed_id']);
       $bed->update(['patient_id' => $patient->id]);

       VisitPasscode::create([
        'patient_id' => $patient->id,
        'code' => strtoupper(str()->random(9)),
        'expires_at' => now()->addHours((int)$data['passcode_duration']),
        'status' => 'active',
       ]);
       return redirect()->route('dashboard')->with('success', 'Patient admitted and passcode generated.');
    }
}