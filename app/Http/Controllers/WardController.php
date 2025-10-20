<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Ward;
use App\Models\Bed;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class WardController extends Controller
{
    
    public function index()
    {
        $wards = Ward::with(['beds','availableBeds','occupiedBeds'])->get();
        return view('admin', compact('wards'));
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:wards',
            'total_beds' => 'required|integer|min:1|max:100',
        ]);
      
    
        
        $ward= Ward::create($data);
        for ($i=1;$i <= $ward->total_beds;$i++){
            Bed::create([
        'ward_id'=>$ward->id,
        'bed_number'=>str_pad($i,3,'0',STR_PAD_LEFT),
            ]);
        }
        return back()->with('success','Ward created successfully');
    }

    
  
    public function update(Request $request, Ward $ward)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', Rule::unique('wards', 'code')->ignore($ward->id)],
            'total_beds' => ['required', 'integer', 'min:1', 'max:100'],
        ]);
        $ward->update($data);
        $current=$ward ->beds()->count();
        if($current<$ward->total_beds){
            for($i=$current+1; $i<=$ward->total_beds;$i++){
                Bed::create([
                    'ward_id'=>$ward->id,
                    'bed_number'=>str_pad($i,3,'0',STR_PAD_LEFT),
                ]);
            }
        }
        return back()->with ('success','ward updated.');
    }

    
    public function destroy(Ward $ward)
    {
        $ward->delete();
        return back()->with('success','Ward deleted successfully');
    }

}
