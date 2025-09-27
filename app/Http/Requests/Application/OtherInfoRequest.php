<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class OtherInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'refused_visa'       => 'nullable|in:yes,no',
            'visa_canceled'      => 'nullable|in:yes,no',
            'illegal_entry'      => 'nullable|in:yes,no',
            'criminal_record'    => 'nullable|in:yes,no',
            'health_issue'       => 'nullable|in:yes,no',
            'epidemic_visit'     => 'nullable|in:yes,no',
            'special_skill'      => 'nullable|in:yes,no',
            'military_service'   => 'nullable|in:yes,no',
            'paramilitary'       => 'nullable|in:yes,no',
            'organization_work'  => 'nullable|in:yes,no',
            'other_declaration'  => 'nullable|in:yes,no',
        ];
    }

    public function messages(): array
    {
        return [
            'refused_visa.in'      => 'Please answer Yes or No for "Have you ever been refused a visa?".',
            'visa_canceled.in'     => 'Please answer Yes or No for "Has your visa ever been canceled?".',
            'illegal_entry.in'     => 'Please answer Yes or No for "Have you ever made an illegal entry or overstayed in a country?".',
            'criminal_record.in'   => 'Please answer Yes or No for "Do you have any criminal record?".',
            'health_issue.in'      => 'Please answer Yes or No for "Do you have any serious health issues?".',
            'epidemic_visit.in'    => 'Please answer Yes or No for "Have you visited epidemic areas in the past?".',
            'special_skill.in'     => 'Please answer Yes or No for "Do you possess any special skills?".',
            'military_service.in'  => 'Please answer Yes or No for "Have you ever served in the military?".',
            'paramilitary.in'      => 'Please answer Yes or No for "Have you ever been involved in any paramilitary activities?".',
            'organization_work.in' => 'Please answer Yes or No for "Have you worked with any organizations related to security or defense?".',
            'other_declaration.in' => 'Please answer Yes or No for "Do you have any other declaration to make?".',
        ];
    }
}
