<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class WorkInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 3.1 Current Occupation
            'occupation' => 'required|in:Businessperson,Company employee,Entertainer,Industrial/agricultural worker,Student,Member of parliament,Government official,Teacher,Researcher,Medical professional,Engineer/Technician,Self-employed,Unemployed,Retired,Other',

            // 3.2 Work Experience in the past five years
            'work_exp_date_from' => 'nullable|date',
            'work_exp_date_to'   => 'nullable|date|after_or_equal:work_exp_date_from',

            // Employer
            'employer_name'      => 'nullable|string|max:255',
            'employer_address'   => 'nullable|string|max:255',
            'employer_telephone' => 'nullable|string|max:50',

            // Supervisor
            'supervisor_name'      => 'nullable|string|max:255',
            'supervisor_telephone' => 'nullable|string|max:50',

            // Position & Duty
            'position_name' => 'nullable|string|max:255',
            'duty_name'     => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            // Occupation
            'occupation.required' => 'Please select your current occupation.',
            'occupation.in'       => 'Invalid occupation selected.',

            // Work experience dates
            'work_exp_date_from.date' => 'The work experience "from" date must be a valid date.',
            'work_exp_date_to.date'   => 'The work experience "to" date must be a valid date.',
            'work_exp_date_to.after_or_equal' => 'The "to" date cannot be earlier than the "from" date.',

            // Employer
            'employer_name.string'   => 'Employer name must be a valid text.',
            'employer_name.max'      => 'Employer name may not be greater than 255 characters.',
            'employer_address.string'=> 'Employer address must be a valid text.',
            'employer_address.max'   => 'Employer address may not be greater than 255 characters.',
            'employer_telephone.max' => 'Employer telephone may not exceed 50 characters.',

            // Supervisor
            'supervisor_name.string'   => 'Supervisor name must be valid text.',
            'supervisor_name.max'      => 'Supervisor name may not be greater than 255 characters.',
            'supervisor_telephone.max' => 'Supervisor telephone may not exceed 50 characters.',

            // Position & Duty
            'position_name.string' => 'Position name must be valid text.',
            'position_name.max'    => 'Position name may not be greater than 255 characters.',
            'duty_name.string'     => 'Duty name must be valid text.',
            'duty_name.max'        => 'Duty name may not be greater than 255 characters.',
        ];
    }
}
