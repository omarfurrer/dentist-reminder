<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAppointmentWithPatientRequest extends FormRequest {

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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'nullable|required_without:patient_id',
            'last_name' => 'nullable|required_without:patient_id',
            'mobile_number' => 'nullable|required_without:patient_id',
            'patient_id' => 'nullable|required_without_all:first_name,last_name,mobile_number|exists:patients,id',
            'time' => 'required|date',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Illuminate\Support\Facades\Session::flash('add_appointment_redirection', true);
        return parent::failedValidation($validator);
    }

}
