<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class VisaTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 2.1 Type of visa & main purpose
            'visa_type'     => 'required|in:Tourism,Business,Work Permit,Temporary Work',

            // Tourist type (only if visa_type = L)
            'tourist_type'  => 'nullable|in:tourist,business,work_permit',

            // 2.2 Service type
            'service_type'  => 'required|in:individual,group',

            // 2.3 Visa Application Info
            'visa_validity'     => 'required|integer|min:1|max:120', // max 10 years in months
            'max_duration_stay' => 'required|integer|min:1|max:365', // max 1 year stay
            'entries'           => 'required|in:single,multiple,work_permit',
        ];
    }

    public function messages(): array
    {
        return [
            // Visa type
            'visa_type.required' => 'Please select the type of visa you are applying for.',
            'visa_type.in'       => 'Invalid visa type selected.',

            // Tourist type
            'tourist_type.in'    => 'Tourist type must be tourist, business, or work permit.',

            // Service type
            'service_type.required' => 'Please select a service type (normal or express).',
            'service_type.in'       => 'Invalid service type selected.',

            // Visa validity
            'visa_validity.required' => 'Visa validity (in months) is required.',
            'visa_validity.integer'  => 'Visa validity must be a number.',
            'visa_validity.min'      => 'Visa validity must be at least 1 month.',
            'visa_validity.max'      => 'Visa validity cannot exceed 120 months (10 years).',

            // Max duration stay
            'max_duration_stay.required' => 'Maximum duration of stay is required.',
            'max_duration_stay.integer'  => 'Duration of stay must be a number.',
            'max_duration_stay.min'      => 'Duration of stay must be at least 1 day.',
            'max_duration_stay.max'      => 'Duration of stay cannot exceed 365 days.',

            // Entries
            'entries.required' => 'Please specify the type of entry.',
            'entries.in'       => 'Entries must be single, multiple, or work permit.',
        ];
    }
}
