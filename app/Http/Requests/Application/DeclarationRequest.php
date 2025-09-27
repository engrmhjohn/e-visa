<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class DeclarationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'declaration_type' => 'required|in:applicant,behalf',
            'agree'            => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'declaration_type.required' => 'Please select who is filling in the form (Applicant or On behalf of Applicant).',
            'declaration_type.in'       => 'Invalid declaration type selected.',
            'agree.accepted'            => 'You must agree with the declaration before proceeding.',
        ];
    }
}
