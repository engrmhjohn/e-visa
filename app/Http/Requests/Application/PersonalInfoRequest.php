<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Uploads
            'picture'            => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'passport_picture'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // 1.1 Name
            'family_name'        => 'required|string|max:255',
            'given_names'        => 'required|string|max:255',
            'other_names'        => 'nullable|string|max:255',
            'siberia_name'       => 'nullable|string|max:255',

            // 1.2 Date of birth
            'dob'                => 'required|date',

            // 1.3 Gender
            'gender'             => 'required|in:male,female',

            // 1.4 Place of birth
            'birth_country_id'   => 'required|exists:countries,id',
            'province_state'     => 'required|string|max:255',
            'city'               => 'required|string|max:255',

            // 1.5 Marital status
            'marital_status'     => 'required|in:married,divorced,single,widowed,others',

            // 1.6 Nationality and permanent residence
            'current_nationality_id' => 'required|exists:countries,id',
            'id_number'              => 'required|string|max:100',
            'other_nationality'      => 'required|in:yes,no',
            'permanent_resident_status' => 'required|in:yes,no',
            'previous_nationalities' => 'required|in:yes,no',

            // 1.7 Passport information
            'passport_type'          => 'required|in:ordinary,service,diplomatic,official,special,others',
            'passport_number'        => 'required|string|max:100',
            'issuing_country_id'     => 'required|exists:countries,id',
            'place_of_issue'         => 'required|string|max:255',
            'passport_expiration_date' => 'required|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            // Uploads
            'picture.required'           => 'Profile picture is required.',
            'picture.mimes'              => 'Profile picture must be in JPG, JPEG or PNG format.',
            'passport_picture.required'  => 'Passport data page is required.',
            'passport_picture.mimes'     => 'Passport picture must be a JPG, JPEG, PNG, or PDF file.',

            // Name
            'family_name.required'       => 'Family name is required.',
            'given_names.required'       => 'Given name(s) is required.',

            // Date of birth
            'dob.required'               => 'Date of birth is required.',
            'dob.date'                   => 'Please provide a valid date of birth.',

            // Gender
            'gender.required'            => 'Gender is required.',
            'gender.in'                  => 'Gender must be either male or female.',

            // Place of birth
            'birth_country_id.required'  => 'Birth country is required.',
            'province_state.required'    => 'Province/State is required.',
            'city.required'              => 'City is required.',

            // Marital status
            'marital_status.required'    => 'Marital status is required.',

            // Nationality
            'current_nationality_id.required' => 'Current nationality is required.',
            'id_number.required'              => 'ID/Passport number is required.',
            'other_nationality.required'      => 'Please specify if you have other nationality.',
            'permanent_resident_status.required' => 'Please specify permanent resident status.',
            'previous_nationalities.required' => 'Please specify previous nationalities information.',

            // Passport
            'passport_type.required'     => 'Passport type is required.',
            'passport_number.required'   => 'Passport number is required.',
            'issuing_country_id.required'=> 'Issuing country is required.',
            'place_of_issue.required'    => 'Place of issue is required.',
            'passport_expiration_date.required' => 'Passport expiration date is required.',
            'passport_expiration_date.after'    => 'Passport expiration date must be in the future.',
        ];
    }
}
