<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storevisit_passcodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'patient_id'=>'required|exists:patients,id',
            'code'=> 'required|string|unique:visit_passcodes,code',
            'expires_at'=>'required|date|after:now',
            'status'=> 'required|in:active,invalid',
            'reason'=>'nullable|string',
        ];
    }
}
