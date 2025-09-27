<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class TravelInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 6.1 Visa Category
            'visa_category' => 'required|in:tourist,business,work',

            // 6.1B & 6.1C Hotel info (required if tourist/business)
            'hotel_name'    => 'nullable|string|max:255',
            'hotel_address' => 'nullable|string|max:255',

            // 6.1D Work
            'company_approval_letter' => 'nullable|string|max:255',

            // 6.2 Inviting Person / Organization
            'inviting_name'         => 'required|string|max:255',
            'inviting_relationship' => 'required|string|max:255',
            'inviting_phone_number' => 'required|string|max:20',
            'inviting_email'        => 'nullable|email|max:255',
            'inviting_city'         => 'required|string|max:100',
            'inviting_district'     => 'nullable|string|max:100',
            'inviting_post_code'    => 'nullable|string|max:20',

            // 6.3 Emergency Contact
            'emergency_contact_family_name'  => 'required|string|max:100',
            'emergency_contact_givenname'    => 'required|string|max:100',
            'emergency_contact_relationship' => 'required|string|max:100',
            'emergency_contact_phone_number' => 'required|string|max:20',
            'emergency_contact_email'        => 'nullable|email|max:255',

            // 6.4 Who will pay
            'travel_payer' => 'required|in:self,other,organization',

            // 6.5 Same passport
            'same_passport' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            // Visa Category
            'visa_category.required' => 'Please select a visa category.',
            'visa_category.in'       => 'Visa category must be either Tourist, Business, or Work.',

            // Inviting person
            'inviting_name.required'         => 'Please provide the name of the inviting person/organization.',
            'inviting_relationship.required' => 'Please specify your relationship with the inviting person/organization.',
            'inviting_phone_number.required' => 'Inviting person\'s phone number is required.',
            'inviting_email.email'           => 'Please enter a valid email for the inviting person.',
            'inviting_city.required'         => 'Please enter the city of the inviting person/organization.',

            // Emergency contact
            'emergency_contact_family_name.required'  => 'Emergency contact family name is required.',
            'emergency_contact_givenname.required'    => 'Emergency contact given name is required.',
            'emergency_contact_relationship.required' => 'Emergency contact relationship is required.',
            'emergency_contact_phone_number.required' => 'Emergency contact phone number is required.',
            'emergency_contact_email.email'           => 'Please enter a valid email for the emergency contact.',

            // Travel payer
            'travel_payer.required' => 'Please select who will pay for this travel.',
            'travel_payer.in'       => 'Travel payer must be self, other, or organization.',
        ];
    }
}
