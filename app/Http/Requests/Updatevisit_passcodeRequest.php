<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Updatevisit_passcodeRequest extends FormRequest
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
            'patient_id'=>'required|exists:patients,id',
            'code'=> ['required',
            'string',
            Rule::unique('visit_passcodes','code')->ignore($this->visit_passcode)],
            'expires_at'=>'required|date|after:now',
            'status'=> 'required|in:active,invalid',
            'reason'=>'nullable|string',
        ];
    }
}
