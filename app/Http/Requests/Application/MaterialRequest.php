<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $fileRule = 'file|mimes:jpg,jpeg,png,pdf|max:2048'; // 2MB max

        return [
            // Other country visas (multi slot)
            'other_country_visa1' => "required|$fileRule",
            'other_country_visa2' => "nullable|$fileRule",
            'other_country_visa3' => "nullable|$fileRule",
            'other_country_visa4' => "nullable|$fileRule",
            'other_country_visa5' => "nullable|$fileRule",
            'other_country_visa6' => "nullable|$fileRule",

            // Itinerary
            'itinerary_siberia' => "required|$fileRule",

            // Hotel requirement
            'hote_requirement' => "required|$fileRule",

            // Bank statements (multi slot)
            'bank_statement1' => "required|$fileRule",
            'bank_statement2' => "nullable|$fileRule",
            'bank_statement3' => "nullable|$fileRule",
            'bank_statement4' => "nullable|$fileRule",

            // Air ticket
            'air_ticket' => "required|$fileRule",

            // Invitation letter
            'invitation_letter' => "required|$fileRule",
        ];
    }

    public function messages(): array
    {
        return [
            // Other country visas
            'other_country_visa1.required' => 'Please upload at least one valid visa from another country.',
            'other_country_visa1.mimes'    => 'Visa file must be JPG, JPEG, PNG or PDF format.',
            'other_country_visa1.max'      => 'Visa file size must not exceed 2MB.',

            // Itinerary
            'itinerary_siberia.required' => 'Please upload your itinerary in Siberia.',
            'itinerary_siberia.mimes'    => 'Itinerary file must be JPG, JPEG, PNG or PDF format.',
            'itinerary_siberia.max'      => 'Itinerary file size must not exceed 2MB.',

            // Hotel
            'hote_requirement.required' => 'Hotel reservation with complete payment is required.',
            'hote_requirement.mimes'    => 'Hotel reservation must be JPG, JPEG, PNG or PDF.',
            'hote_requirement.max'      => 'Hotel reservation file size must not exceed 2MB.',

            // Bank statements
            'bank_statement1.required' => 'At least one bank statement is required.',
            'bank_statement1.mimes'    => 'Bank statement must be JPG, JPEG, PNG or PDF.',
            'bank_statement1.max'      => 'Bank statement file must not exceed 2MB.',

            // Air ticket
            'air_ticket.required' => 'Round trip air ticket is required.',
            'air_ticket.mimes'    => 'Air ticket must be JPG, JPEG, PNG or PDF.',
            'air_ticket.max'      => 'Air ticket file must not exceed 2MB.',

            // Invitation letter
            'invitation_letter.required' => 'Invitation letter is required.',
            'invitation_letter.mimes'    => 'Invitation letter must be JPG, JPEG, PNG or PDF.',
            'invitation_letter.max'      => 'Invitation letter file must not exceed 2MB.',
        ];
    }
}
