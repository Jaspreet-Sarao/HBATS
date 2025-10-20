<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:255',
            'patient_indentifier'=> 'required|string|unique:patients,patient_identifier',
            'contact'=> 'nullable|string|max:255',
            'emergency_contact'=> 'nullable|string|max:255',
            'admission_notes'=> 'nullable|string',
            'admitted_at'=> 'nullable|date',
            'discharged_at'=> 'nullable|date',
        ];
    }
}
