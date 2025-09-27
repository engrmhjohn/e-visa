<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class PreviousTravelInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'travel_siberia'            => 'nullable|in:yes,no',
            'previous_siberia_visa'   => 'nullable|in:yes,no',
            'other_country_visa'      => 'nullable|in:yes,no',
            'visited_last_12_months'  => 'nullable|in:yes,no',
        ];
    }

    public function messages(): array
    {
        return [
            'travel_siberia.in'           => 'Answer must be Yes or No for "Have you ever been to Siberia?".',
            'previous_siberia_visa.in'  => 'Answer must be Yes or No for "Have you ever gotten a Siberian visa?".',
            'other_country_visa.in'     => 'Answer must be Yes or No for "Do you have any valid visa issued by other countries?".',
            'visited_last_12_months.in' => 'Answer must be Yes or No for "Have you visited any countries in the last 12 months?".',
        ];
    }
}
