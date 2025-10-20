<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\VisitPasscode;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Show the visitor portal
     */
    public function index()
    {
        return view('visitor');
    }

    /**
     * Search for patient with passcode
     */
    public function search(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'passcode' => 'required|string|max:20',
        ]);

        $patientName = $request->patient_name;
        $passcode = strtoupper($request->passcode);

        // Find patient by name and active passcode
        $patient = Patient::where('name', 'like', "%{$patientName}%")
            ->whereHas('passcodes', function($query) use ($passcode) {
                $query->where('code', $passcode)
                      ->where('status', 'active')
                      ->where('expires_at', '>', now());
            })
            ->with(['bed.ward', 'passcodes' => function($query) use ($passcode) {
                $query->where('code', $passcode);
            }])
            ->first();

        if ($patient) {
            return view('visitor', compact('patient', 'patientName', 'passcode'))
                ->with('success', 'Patient found successfully!');
        }

        return view('visitor', compact('patientName', 'passcode'))
            ->with('error', 'Patient not found or passcode is invalid/expired.');
    }
}

