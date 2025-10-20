<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
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
            'patient_identifier'=> ['required',
            'string',
            Rule::unique('patients','patient_identifier')->ignore($this->patient)
        ],
            'contact'=> 'nullable|string|max:255',
            'emergency_contact'=> 'nullable|string|max:255',
            'admission_notes'=> 'nullable|string',
            'admitted_at'=> 'nullable|date',
            'discharged_at'=> 'nullable|date',
        ];
    }
}
