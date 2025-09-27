<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visa Application Summary - {{ $application->tracking_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<style type="text/css">
    body {
        font-family: "Roboto", sans-serif;
        font-size: 12px;
        line-height: 1.4;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .text-center {
        text-align: center !important;
    }

    .text-right {
        text-align: right !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-30 {
        width: 30%;
    }

    .w-70 {
        width: 70%;
    }

    .logo img {
        max-width: 150px;
        max-height: 80px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        padding: 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 11px;
        font-weight: bold;
    }

    table tr td {
        font-size: 10px;
    }

    .section-title {
        background: #2c3e50;
        color: white;
        padding: 8px;
        font-size: 13px;
        font-weight: bold;
        margin-top: 15px;
    }

    .photo-container {
        text-align: center;
        margin: 10px 0;
    }

    .photo-container img {
        max-width: 120px;
        max-height: 150px;
        border: 1px solid #ddd;
    }

    .passport-container {
        text-align: center;
        margin: 10px 0;
    }

    .passport-container img {
        max-width: 100%;
        height: auto;
    }


    .signature-area {
        margin-top: 50px;
        border-top: 1px solid #000;
        width: 300px;
        text-align: center;
        padding-top: 5px;
    }

    .page-break {
        page-break-after: always;
    }

</style>

<body>
    <!-- Header Section -->
    <div class="header">
        <div class="logo text-center">
            <div class="barcode-section text-center mt-3">
                <div style="margin-bottom: 10px;">
                    <!-- For PDF, we use base64 encoded image -->
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($application->tracking_number, 'C128', 2, 60, array(0,0,0), true) }}" alt="Barcode">
                </div>
            </div>
        </div>
        <div class="head-title">
            <h1 class="text-center m-0 p-0">Visa Application Summary</h1>
        </div>
    </div>

    <!-- Application Overview -->
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            <tr>
                <td class="w-50">
                    <p class="m-0 text-bold">Application Date: <span class="gray-color">{{ $application->created_at->format('d F Y') }}</span></p>
                    <p class="m-0 text-bold">Current Status: <span class="gray-color">{{ ucfirst($application->status) }}</span></p>
                </td>
                <td class="w-50">
                    <p class="m-0 text-bold">Tracking Number: <span class="gray-color">{{ $application->tracking_number }}</span></p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Step 1: Personal Information -->
    <div class="section-title">1. Personal Information</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            <tr>
                <td class="w-70">
                    @if($application->personalInfo)
                    <div class="box-text">
                        <p class="m-0" style="font-size: 14px;"><strong>Family Name:</strong> {{ $application->personalInfo->family_name }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Given Name:</strong> {{ $application->personalInfo->given_names }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Other Name:</strong> {{ $application->personalInfo->other_names }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Siberia Name:</strong> {{ $application->personalInfo->siberia_name }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Date of Birth:</strong> {{ $application->personalInfo->dob->format('d F Y') }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Gender:</strong> {{ ucfirst($application->personalInfo->gender) }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Place of Birth:</strong> {{ $application->personalInfo->birthCountry->name ?? '' }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Province/State:</strong> {{ $application->personalInfo->province_state }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>City:</strong> {{ $application->personalInfo->city }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Marital Status:</strong> {{ ucfirst($application->personalInfo->marital_status) }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Current Nationality:</strong> {{ $application->personalInfo->currentNationality->name ?? '' }}
                        <p class="m-0" style="font-size: 14px;"><strong>ID Number:</strong> {{ $application->personalInfo->id_number }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Other Nationality:</strong> {{ ucfirst($application->personalInfo->other_nationality) }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Permanent Resident Status:</strong> {{ ucfirst($application->personalInfo->permanent_resident_status) }}</p>
                        <p class="m-0" style="font-size: 14px;"> <strong>Previous Nationalities:</strong> {{ ucfirst($application->personalInfo->previous_nationalities) }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Passport Type:</strong> {{ ucfirst($application->personalInfo->passport_type) }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Passport Number:</strong> {{ $application->personalInfo->passport_number }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Issuing Country:</strong> {{ $application->personalInfo->issuingCountry->name ?? '' }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Place of Issue:</strong> {{ $application->personalInfo->place_of_issue }}</p>
                        <p class="m-0" style="font-size: 14px;"><strong>Passport Expiry:</strong> {{ $application->personalInfo->passport_expiration_date->format('d F Y') }}</p>
                    </div>
                    @else
                    <p class="gray-color">No personal information provided.</p>
                    @endif
                </td>
                <td class="w-30">
                    @if($application->personalInfo && $application->personalInfo->picture)
                    <div class="photo-container">
                        <img src="{{asset($application->personalInfo->picture) }}" alt="Applicant Photo" style="max-height: 150px;">
                    </div>
                    @endif
                </td>
            </tr>
            @if($application->personalInfo && $application->personalInfo->passport_picture)
            <tr>
                <td colspan="4">
                    <div class="passport-container">
                        <img src="{{asset($application->personalInfo->passport_picture) }}" alt="Passport Photo">
                    </div>
                </td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Step 2: Visa Type -->
    <div class="section-title">2. Visa Type & Purpose</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            @if($application->visaType)
            <tr>
                <th class="w-20">Visa Type</th>
                <th class="w-20">Tourist Type</th>
                <th class="w-20">Service Type</th>
                <th class="w-20">Validity</th>
                <th class="w-20">Entries</th>
            </tr>
            <tr>
                <td>{{ $application->visaType->visa_type }}</td>
                <td>{{ ucfirst($application->visaType->tourist_type ?? 'N/A' )}}</td>
                <td>{{ ucfirst($application->visaType->service_type) }}</td>
                <td>{{ $application->visaType->visa_validity }} months</td>
                <td>{{ ucfirst($application->visaType->entries) }}</td>
            </tr>
            @else
            <tr>
                <td colspan="4" class="gray-color text-center">No visa information provided.</td>
            </tr>
            @endif
        </table>
        <strong>
            <p class="mb-0">*Max Duration of Stay {{ $application->visaType->max_duration_stay }} days</p>
        </strong>
    </div>

    <!-- Step 3: Work Information -->
    <div class="section-title">3. Work Information</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            @if($application->workInfo)
            <tr>
                <td class="w-50">
                    <p><strong>Employer Information:</strong></p>
                    <p class="m-0">Current Occupation: {{ $application->workInfo->occupation }}</p>
                    <p class="m-0">Experience (Past 5 Years): {{ $application->workInfo->work_exp_date_from->format('d F Y') }}
                        -
                        {{ $application->workInfo->work_exp_date_to->format('d F Y') }}</p>
                    <p class="m-0">Employer Name: {{ $application->workInfo->employer_name ?? 'N/A' }}</p>
                    <p class="m-0">Telephone: {{ $application->workInfo->employer_address ?? 'N/A' }}</p>
                    <p class="m-0">Address: {{ $application->workInfo->employer_telephone ?? 'N/A' }}</p>
                    <p class="m-0">Position: {{ $application->workInfo->position_name ?? 'N/A' }}</p>
                    <p class="m-0">Duty: {{ $application->workInfo->duty_name ?? 'N/A' }}</p>
                </td>
                <td class="w-50">
                    <p><strong>Supervisor Information:</strong></p>
                    <p class="m-0">Supervisor Name: {{ $application->workInfo->supervisor_name ?? 'N/A' }}</p>
                    <p class="m-0">Telephone: {{ $application->workInfo->supervisor_telephone ?? 'N/A' }}</p>
                </td>
            </tr>
            @else
            <tr>
                <td colspan="2" class="gray-color text-center">No Work information provided.</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Step 4: Education Information -->
    <div class="section-title">4. Education Information</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            @if($application->educationInfo)
            <tr>
                <th class="w-40">Institute</th>
                <th class="w-30">Degree</th>
                <th class="w-30">Major</th>
            </tr>
            <tr>
                <td>{{ $application->educationInfo->institute_name }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $application->educationInfo->degree_name)) }}</td>
                <td>{{ $application->educationInfo->major_degree ?? 'N/A' }}</td>
            </tr>
            @else
            <tr>
                <td colspan="3" class="gray-color text-center">No education information provided.</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Step 5: Family Information -->
    <div class="section-title">5. Family Information</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            @if($application->familyInfo)
            <tr>
                <td class="w-25">
                    <p><strong>Contact Information:</strong></p>
                    <p class="m-0">Current Home Address: {{ $application->familyInfo->current_home_address }}</p>
                    <p class="m-0">Phone: {{ $application->familyInfo->home_phone_number ?? 'N/A' }}</p>
                    <p class="m-0">Mobile: {{ $application->familyInfo->home_mobile_number }}</p>
                    <p class="m-0">Email: {{ $application->familyInfo->home_email ?? 'N/A' }}</p>
                </td>
                <td class="w-25">
                    <p><strong>Fathers Information:</strong></p>
                    <p class="m-0">Family Name: {{ $application->familyInfo->father_family_name }}</p>
                    <p class="m-0">Given Name: {{ $application->familyInfo->father_givenname }}</p>
                    <p class="m-0">Nationality: {{ $application->familyInfo->fatherNationality->name ?? '' }}</p>
                    <p class="m-0">Date of Birth: {{ $application->familyInfo->father_dob->format('d F Y') }}</p>
                    <p class="m-0">Siberia Origin: {{ $application->familyInfo->father_siberia_origin ? 'Yes' : 'No' }}</p>
                </td>
                <td class="w-25">
                    <p><strong>Mother Information:</strong></p>
                    <p class="m-0">Family Name: {{ $application->familyInfo->mother_family_name }}</p>
                    <p class="m-0">Given Name: {{ $application->familyInfo->mother_givenname }}</p>
                    <p class="m-0">Nationality: {{ $application->familyInfo->motherNationality->name ?? '' }}</p>
                    <p class="m-0">Date of Birth: {{ $application->familyInfo->mother_dob->format('d F Y') }}</p>
                    <p class="m-0">Siberia Origin: {{ $application->familyInfo->mother_siberia_origin ? 'Yes' : 'No' }}</p>
                </td>
                <td class="w-25">
                    <p><strong>Child Information:</strong></p>
                    <p class="m-0">Family Name: {{ $application->familyInfo->children_family_name }}</p>
                    <p class="m-0">Given Name: {{ $application->familyInfo->children_givenname }}</p>
                    <p class="m-0">Nationality: {{ $application->familyInfo->childrenNationality->name ?? '' }}</p>
                    <p class="m-0">Date of Birth: {{ $application->familyInfo->children_dob->format('d F Y') }}</p>
                </td>
            </tr>
            @else
            <tr>
                <td colspan="2" class="gray-color text-center">No family information provided.</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Step 6: Travel Information -->
    <div class="section-title">6. Travel Information</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            @if($application->travelInfo)
            <tr>
                <td class="w-25">
                    <p><strong>Travel Information:</strong></p>
                    <p class="m-0">Visa Category: {{ ucfirst($application->travelInfo->visa_category) }}</p>
                    <p class="m-0">Travel Payer: {{ ucfirst($application->travelInfo->travel_payer) }}</p>
                    <p class="m-0">Same Passport: {{ $application->travelInfo->same_passport ? 'Yes' : 'No' }}</p>
                    @if(in_array($application->travelInfo->visa_category, ['tourist', 'business']))
                    <p class="m-0">Hotel Name: {{ $application->travelInfo->hotel_name ?? 'N/A' }}</p>
                    <p class="m-0">Hotel Address: {{ $application->travelInfo->hotel_address ?? 'N/A' }}</p>
                    @endif
                    @if($application->travelInfo->visa_category === 'work')
                    <img src="{{ storage_path('app/public/' . $application->travelInfo->company_approval_letter) }}" alt="Approval Letter">
                    @endif
                </td>
                <td class="w-50">
                    <p><strong>Inviting Person / Organization:</strong></p>
                    <p class="m-0">Name: {{ $application->travelInfo->inviting_name }}</p>
                    <p class="m-0">Relationship: {{ $application->travelInfo->inviting_relationship }}</p>
                    <p class="m-0">Email: {{ $application->travelInfo->inviting_email ?? 'N/A' }}</p>
                    <p class="m-0">Phone: {{ $application->travelInfo->inviting_phone_number }}</p>
                    <p class="m-0">City: {{ $application->travelInfo->inviting_city }}</p>
                    <p class="m-0">District: {{ $application->travelInfo->inviting_district ?? 'N/A' }}</p>
                    <p class="m-0">Post Code: {{ $application->travelInfo->inviting_post_code ?? 'N/A' }}</p>
                </td>
                <td class="w-25">
                    <p><strong>Emergency Contact:</strong></p>
                    <p class="m-0">Family Name: {{ $application->travelInfo->emergency_contact_family_name }}</p>
                    <p class="m-0">Given Name: {{ $application->travelInfo->emergency_contact_givenname }}</p>
                    <p class="m-0">Relationship: {{ $application->travelInfo->emergency_contact_relationship }}</p>
                    <p class="m-0">Phone: {{ $application->travelInfo->emergency_contact_phone_number }}</p>
                    <p class="m-0">Email: {{ $application->travelInfo->emergency_contact_email ?? 'N/A' }}</p>
                </td>
            </tr>
            @else
            <tr>
                <td colspan="2" class="gray-color text-center">No Travel information provided.</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Step 7: Previous Travel Information -->
    <div class="section-title">7. Previous Travel Information</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            @if($application->previousTravelInfo)
            <tr>
                <td class="w-100">
                    <p class="m-0">Have you ever been to Siberia? {{ ucfirst($application->previousTravelInfo->travel_siberia ?? 'N/A') }}</p>
                    <p class="m-0">Have you ever gotten a Siberia visa? {{ ucfirst($application->previousTravelInfo->previous_siberia_visa ?? 'N/A') }}</p>
                    <p class="m-0">Do you have any valid visa issued by other countries? {{ ucfirst($application->previousTravelInfo->other_country_visa ?? 'N/A') }}</p>
                    <p class="m-0">Have you visited any countries in the last 12 months? {{ ucfirst($application->previousTravelInfo->visited_last_12_months ?? 'N/A') }}</p>
                </td>
            </tr>
            @else
            <tr>
                <td colspan="2" class="gray-color text-center">No Previous Travel information provided.</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Step 8: Other  Information -->
    <div class="section-title">8. Other Information</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            @if($application->otherInfo)
            <tr>
                <td class="w-25">
                    <p class="m-0">Refused Visa {{ ucfirst($application->otherInfo->refused_visa ?? 'N/A') }}</p>
                    <p class="m-0">Visa Canceled {{ ucfirst($application->otherInfo->visa_canceled ?? 'N/A') }}</p>
                    <p class="m-0">Illegal Entry {{ ucfirst($application->otherInfo->illegal_entry ?? 'N/A') }}</p>
                </td>
                <td class="w-25">
                    <p class="m-0">Criminal Record {{ ucfirst($application->otherInfo->criminal_record ?? 'N/A') }}</p>
                    <p class="m-0">Health Issue {{ ucfirst($application->otherInfo->health_issue ?? 'N/A') }}</p>
                    <p class="m-0">Epidemic Visit {{ ucfirst($application->otherInfo->epidemic_visit ?? 'N/A') }}</p>
                </td>
                <td class="w-25">
                    <p class="m-0">Special Skill {{ ucfirst($application->otherInfo->special_skill ?? 'N/A') }}</p>
                    <p class="m-0">Military Service {{ ucfirst($application->otherInfo->military_service ?? 'N/A') }}</p>
                    <p class="m-0">Paramilitary {{ ucfirst($application->otherInfo->paramilitary ?? 'N/A') }}</p>
                </td>
                <td class="w-25">
                    <p class="m-0">Organization Work {{ ucfirst($application->otherInfo->organization_work ?? 'N/A') }}</p>
                    <p class="m-0">VOther Declaration {{ ucfirst($application->otherInfo->other_declaration ?? 'N/A') }}</p>
                </td>
            </tr>
            @else
            <tr>
                <td colspan="2" class="gray-color text-center">No Other information provided.</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Step 9: Declaration -->
    <div class="section-title">9. Declaration</div>
    <div class="table-section w-100 mt-10">
        <table class="table w-100">
            @if($application->declaration)
            <tr>
                <td class="w-100">
                    <p class="m-0"> <strong>Declaration Type:</strong>
                        {{ ucfirst($application->declaration->declaration_type ?? 'N/A') }}</p>
                    <p class="m-0"> <strong>Agreed:</strong>
                        {{ $application->declaration->agree ? 'Yes' : 'No' }}</p>
                </td>
            </tr>
            @else
            <tr>
                <td colspan="2" class="gray-color text-center">No Declaration provided.</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Footer -->
    <div class="footer" style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px;">
        <p>Generated on: {{ now()->format('d F Y g:i A') }}</p>
    </div>
</body>
</html>