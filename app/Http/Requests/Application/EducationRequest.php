<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'institute_name' => 'required|string|max:255',
            'degree_name' => 'required|in:Technical secondary school/high school or equivalent,Junior college/undergraduate degree or equivalent,Masters degree or equivalent,Doctoral degree or above,Other',
            'major_degree' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            // Institute
            'institute_name.required' => 'Please enter the name of your institute.',
            'institute_name.string'   => 'Institute name must be valid text.',
            'institute_name.max'      => 'Institute name may not exceed 255 characters.',

            // Degree
            'degree_name.required' => 'Please select your highest diploma/degree.',
            'degree_name.in'       => 'Invalid degree option selected.',

            // Major
            'major_degree.string' => 'Major field must be valid text.',
            'major_degree.max'    => 'Major field may not exceed 255 characters.',
        ];
    }
}
