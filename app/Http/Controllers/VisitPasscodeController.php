<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\VisitPasscode;
use App\Http\Requests\Storevisit_passcodeRequest;
use App\Http\Requests\Updatevisit_passcodeRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VisitPasscodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('passcode');
    }
public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|max:255']);
        
        $searchTerm = $request->q;
        
        $patient = Patient::with(['bed.ward', 'passcodes' => function($query) {
            $query->where('status', 'active')->where('expires_at', '>', now());
        }])
        ->where(function($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('patient_identifier', 'like', "%{$searchTerm}%")
                  ->orWhereHas('bed', function($bedQuery) use ($searchTerm) {
                      $bedQuery->where('bed_number', 'like', "%{$searchTerm}%");
                  });
        })
        ->first();
        
        if (!$patient) {
            return view('passcode')->with('error', 'No patient found matching your search.');
        }
        
        return view('passcode', compact('patient'));
    }


    
    public function generate(Request $request, Patient $patient)

   {
    $request->validate(['expiry' => 'required|in:24,48,72,168']);
    VisitPasscode::create([
        'patient_id'=>$patient->id,
        'code'=> strtoupper(str()->random(9)),
        'expires_at'=>now()->addHours((int)$request -> expiry),
        'status'=>'active',
    ]);
    return back()->with ('success','New passcode generated.');

   }
    public function invalidate(Request $request, Patient $patient)
    {
       $request->validate(['reason' => 'nullable|string|max:500']);
       $active=$patient->passcodes()->where('status','active')->first();
       if ($active)$active->update(['status'=>'invalid','reason'=>$request->reason]);
       return back()->with ('success','Passcode Invalidated.');
    }
}

    