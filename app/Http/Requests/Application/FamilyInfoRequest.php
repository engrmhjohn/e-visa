<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class FamilyInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 5.1 Current home address
            'current_home_address'   => 'required|string|max:255',

            // 5.2 Phone Number
            'home_phone_number'      => 'nullable|string|max:20',

            // 5.3 Mobile Phone Number
            'home_mobile_number'     => 'required|string|max:20',

            // 5.4 Email
            'home_email'             => 'nullable|email|max:255',

            // Father
            'father_family_name'     => 'required|string|max:100',
            'father_givenname'       => 'required|string|max:100',
            'father_nationality_id'  => 'required|exists:countries,id',
            'father_dob'             => 'required|date',
            'father_siberia_origin'        => 'boolean',

            // Mother
            'mother_family_name'     => 'required|string|max:100',
            'mother_givenname'       => 'required|string|max:100',
            'mother_nationality_id'  => 'required|exists:countries,id',
            'mother_dob'             => 'required|date',
            'mother_siberia_origin'        => 'boolean',

            // Children (optional)
            'children_family_name'   => 'nullable|string|max:100',
            'children_givenname'     => 'nullable|string|max:100',
            'children_nationality_id'=> 'nullable|exists:countries,id',
            'children_dob'           => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            // Address & Contacts
            'current_home_address.required' => 'Please provide your current home address.',
            'home_mobile_number.required'  => 'Mobile phone number is required.',
            'home_email.email'             => 'Please enter a valid email address.',

            // Father
            'father_family_name.required'    => 'Father\'s family name is required.',
            'father_givenname.required'      => 'Father\'s given name is required.',
            'father_nationality_id.required' => 'Please select father\'s nationality.',
            'father_nationality_id.exists'   => 'Invalid nationality selected for father.',
            'father_dob.required'            => 'Please provide father\'s date of birth.',
            'father_dob.date'                => 'Father\'s date of birth must be a valid date.',

            // Mother
            'mother_family_name.required'    => 'Mother\'s family name is required.',
            'mother_givenname.required'      => 'Mother\'s given name is required.',
            'mother_nationality_id.required' => 'Please select mother\'s nationality.',
            'mother_nationality_id.exists'   => 'Invalid nationality selected for mother.',
            'mother_dob.required'            => 'Please provide mother\'s date of birth.',
            'mother_dob.date'                => 'Mother\'s date of birth must be a valid date.',

            // Children
            'children_nationality_id.exists' => 'Invalid nationality selected for child.',
            'children_dob.date'              => 'Child\'s date of birth must be a valid date.',
        ];
    }
}
