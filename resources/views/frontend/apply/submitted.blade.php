@extends('frontend.master')
@section('title', 'Form submitted Successfully | E-Visa')
@section('content')
<div class="container py-5">
    <div class="row mb-3">
        <div class="col-lg-12 mb-3">
            <div class="journey-timeline aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="timeline-item">
                    <div class="year">Thank you for your application!</div>
                    <div class="description">Your application has been submitted successfully. Your application Tracking No is: <strong>#{{ $application->tracking_number }}</strong></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="barcode-image mb-2">
                {!! DNS1D::getBarcodeHTML($application->tracking_number, 'C128', 2, 60) !!}
                <small class="text-muted font-monospace">Tracking No: {{ $application->tracking_number }}</small>
            </div>
            <div class="qr-code">
                {!! DNS2D::getBarcodeHTML($application->tracking_number, 'QRCODE', 3, 3) !!}
                <small class="text-muted">Scan to track</small>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-3 col-lg-3 border-end form-sidebar">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-1-tab" data-bs-toggle="pill" data-bs-target="#v-pills-1" type="button" role="tab">1. Personal information</button>
                <button class="nav-link" id="v-pills-2-tab" data-bs-toggle="pill" data-bs-target="#v-pills-2" type="button" role="tab">2. Type of visa</button>
                <button class="nav-link" id="v-pills-3-tab" data-bs-toggle="pill" data-bs-target="#v-pills-3" type="button" role="tab">3. Work information</button>
                <button class="nav-link" id="v-pills-4-tab" data-bs-toggle="pill" data-bs-target="#v-pills-4" type="button" role="tab">4. Education</button>
                <button class="nav-link" id="v-pills-5-tab" data-bs-toggle="pill" data-bs-target="#v-pills-5" type="button" role="tab">5. Family information</button>
                <button class="nav-link" id="v-pills-6-tab" data-bs-toggle="pill" data-bs-target="#v-pills-6" type="button" role="tab">6. Travel information</button>
                <button class="nav-link" id="v-pills-7-tab" data-bs-toggle="pill" data-bs-target="#v-pills-7" type="button" role="tab">7. Previous travel info</button>
                <button class="nav-link" id="v-pills-8-tab" data-bs-toggle="pill" data-bs-target="#v-pills-8" type="button" role="tab">8. Other information</button>
                <button class="nav-link" id="v-pills-9-tab" data-bs-toggle="pill" data-bs-target="#v-pills-9" type="button" role="tab">9. Declaration</button>
                <button class="nav-link" id="v-pills-10-tab" data-bs-toggle="pill" data-bs-target="#v-pills-10" type="button" role="tab">10. Upload Materials</button>
            </div>
        </div>
        <div class="col-md-9 col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-person"></i>
                                                        <h4 class="fw-bold">Personal information</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Family Name:</strong> {{ $application->personalInfo->family_name }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Given Names:</strong> {{ $application->personalInfo->given_names }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Other Names:</strong> {{ $application->personalInfo->other_names }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Siberia Names:</strong> {{ $application->personalInfo->siberia_name }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Date of Birth:</strong> {{ $application->personalInfo->dob->format('d F Y') }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Gender:</strong> {{ ucfirst($application->personalInfo->gender) }}
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Birth Country:</strong> {{ $application->personalInfo->birthCountry->name ?? '' }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Province/State:</strong> {{ $application->personalInfo->province_state }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>City:</strong> {{ $application->personalInfo->city }}
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Marital Status:</strong> {{ ucfirst($application->personalInfo->marital_status) }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Current Nationality:</strong> {{ $application->personalInfo->currentNationality->name ?? '' }}
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>ID Number:</strong> {{ $application->personalInfo->id_number }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Other Nationality:</strong> {{ ucfirst($application->personalInfo->other_nationality) }}
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Permanent Resident Status:</strong> {{ ucfirst($application->personalInfo->permanent_resident_status) }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Previous Nationalities:</strong> {{ ucfirst($application->personalInfo->previous_nationalities) }}
                                                            </div>
                                                        </div>

                                                        {{-- Passport Info --}}
                                                        <hr>
                                                        <h5>Passport Information</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Passport Type:</strong> {{ ucfirst($application->personalInfo->passport_type) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Passport Number:</strong> {{ $application->personalInfo->passport_number }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Issuing Country:</strong> {{ $application->personalInfo->issuingCountry->name ?? '' }}
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Place of Issue:</strong> {{ $application->personalInfo->place_of_issue }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Expiration Date:</strong> {{ $application->personalInfo->passport_expiration_date }}
                                                            </div>
                                                        </div>

                                                        {{-- Uploaded Images --}}
                                                        <hr>
                                                        <h5>Uploads</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Profile Picture:</strong><br>
                                                                <img src="{{ asset($application->personalInfo->picture) }}" alt="Profile" class="img-thumbnail" style="max-width:150px;">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Passport Picture:</strong><br>
                                                                <img src="{{ asset($application->personalInfo->passport_picture) }}" alt="Passport" class="img-thumbnail" style="max-width:150px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-passport"></i>
                                                        <h4 class="fw-bold">Type of visa</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <strong>Visa Type:</strong> {{ $application->visaType->visa_type ?? 'N/A'}}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Tourist Type:</strong>
                                                                {{ $application->visaType->tourist_type ?? 'N/A' }}
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Service Type:</strong> {{ ucfirst($application->visaType->service_type) }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Entries:</strong> {{ ucfirst($application->visaType->entries) }}
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Visa Validity:</strong> {{ $application->visaType->visa_validity }} months
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Max Duration of Stay:</strong> {{ $application->visaType->max_duration_stay }} days
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-person-workspace"></i>
                                                        <h4 class="fw-bold">3. Work information</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Current Occupation:</strong> {{ $application->workInfo->occupation }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Work Experience (Past 5 Years):</strong>
                                                                {{ $application->workInfo->work_exp_date_from->format('d F Y') }}
                                                                -
                                                                {{ $application->workInfo->work_exp_date_to->format('d F Y') }}
                                                            </div>
                                                        </div>

                                                        <h6 class="text-primary">Employer</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Name:</strong> {{ $application->workInfo->employer_name ?? 'N/A' }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Address:</strong> {{ $application->workInfo->employer_address ?? 'N/A' }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Telephone:</strong> {{ $application->workInfo->employer_telephone ?? 'N/A' }}
                                                            </div>
                                                        </div>

                                                        <h6 class="text-primary">Supervisor</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Name:</strong> {{ $application->workInfo->supervisor_name ?? 'N/A' }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Telephone:</strong> {{ $application->workInfo->supervisor_telephone ?? 'N/A' }}
                                                            </div>
                                                        </div>

                                                        <h6 class="text-primary">Position & Duty</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Position:</strong> {{ $application->workInfo->position_name ?? 'N/A' }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Duty:</strong> {{ $application->workInfo->duty_name ?? 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-mortarboard"></i>
                                                        <h4 class="fw-bold">4. Education</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <strong>Institute Name:</strong> {{ $application->educationInfo->institute_name }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Degree:</strong> {{ $application->educationInfo->degree_name }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Major:</strong> {{ $application->educationInfo->major_degree ?? 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-5-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-people"></i>
                                                        <h4 class="fw-bold">5. Family Information</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        {{-- Contact --}}
                                                        <h6 class="text-primary">Contact</h6>
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Current Home Address:</strong> {{ $application->familyInfo->current_home_address }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Mobile Number:</strong> {{ $application->familyInfo->home_mobile_number }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Home Phone Number:</strong> {{ $application->familyInfo->home_phone_number ?? 'N/A' }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Email:</strong> {{ $application->familyInfo->home_email ?? 'N/A' }}
                                                            </div>
                                                        </div>

                                                        {{-- Father --}}
                                                        <hr>
                                                        <h6 class="text-primary">Father</h6>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Family Name:</strong> {{ $application->familyInfo->father_family_name }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Given Name:</strong> {{ $application->familyInfo->father_givenname }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Nationality:</strong> {{ $application->familyInfo->fatherNationality->name ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Date of Birth:</strong> {{ $application->familyInfo->father_dob->format('d F Y') }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>In Siberia:</strong> {{ $application->familyInfo->father_siberia_origin ? 'Yes' : 'No' }}
                                                            </div>
                                                        </div>

                                                        {{-- Mother --}}
                                                        <hr>
                                                        <h6 class="text-primary">Mother</h6>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Family Name:</strong> {{ $application->familyInfo->mother_family_name }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Given Name:</strong> {{ $application->familyInfo->mother_givenname }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Nationality:</strong> {{ $application->familyInfo->motherNationality->name ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Date of Birth:</strong> {{ $application->familyInfo->mother_dob->format('d F Y') }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>In Siberia:</strong> {{ $application->familyInfo->mother_siberia_origin ? 'Yes' : 'No' }}
                                                            </div>
                                                        </div>

                                                        {{-- Child --}}
                                                        @if($application->familyInfo->children_family_name)
                                                        <hr>
                                                        <h6 class="text-primary">Child</h6>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Family Name:</strong> {{ $application->familyInfo->children_family_name }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Given Name:</strong> {{ $application->familyInfo->children_givenname }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Nationality:</strong> {{ $application->familyInfo->childrenNationality->name ?? '' }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Date of Birth:</strong> {{ $application->familyInfo->children_dob ? $application->familyInfo->children_dob->format('d F Y') : 'N/A' }}
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-6-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-airplane"></i>
                                                        <h4 class="fw-bold">6. Travel Information</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        {{-- Visa Category --}}
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Visa Category:</strong> {{ ucfirst($application->travelInfo->visa_category) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Travel Payer:</strong> {{ ucfirst($application->travelInfo->travel_payer) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Same Passport:</strong> {{ $application->travelInfo->same_passport ? 'Yes' : 'No' }}
                                                            </div>
                                                        </div>

                                                        {{-- Hotel Info (for Tourist/Business) --}}
                                                        @if(in_array($application->travelInfo->visa_category, ['tourist', 'business']))
                                                        <h6 class="text-primary">Hotel Information</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Hotel Name:</strong> {{ $application->travelInfo->hotel_name ?? 'N/A' }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Hotel Address:</strong> {{ $application->travelInfo->hotel_address ?? 'N/A' }}
                                                            </div>
                                                        </div>
                                                        @endif

                                                        {{-- Work Approval Letter (for Work visa) --}}
                                                        @if($application->travelInfo->visa_category === 'work')
                                                        <h6 class="text-primary">Company Approval Letter</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                @if($application->travelInfo->company_approval_letter)
                                                                <a href="{{ asset($application->travelInfo->company_approval_letter) }}" target="_blank">View Approval Letter</a>
                                                                @else
                                                                N/A
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @endif

                                                        {{-- Inviting Person/Organization --}}
                                                        <h6 class="text-primary">Inviting Person / Organization in Siberia</h6>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Name:</strong> {{ $application->travelInfo->inviting_name }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Relationship:</strong> {{ $application->travelInfo->inviting_relationship }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Phone:</strong> {{ $application->travelInfo->inviting_phone_number }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Email:</strong> {{ $application->travelInfo->inviting_email ?? 'N/A' }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>City:</strong> {{ $application->travelInfo->inviting_city }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>District:</strong> {{ $application->travelInfo->inviting_district ?? 'N/A' }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Post Code:</strong> {{ $application->travelInfo->inviting_post_code ?? 'N/A' }}
                                                            </div>
                                                        </div>

                                                        {{-- Emergency Contact --}}
                                                        <h6 class="text-primary">Emergency Contact</h6>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Family Name:</strong> {{ $application->travelInfo->emergency_contact_family_name }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Given Name:</strong> {{ $application->travelInfo->emergency_contact_givenname }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Relationship:</strong> {{ $application->travelInfo->emergency_contact_relationship }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <strong>Phone:</strong> {{ $application->travelInfo->emergency_contact_phone_number }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Email:</strong> {{ $application->travelInfo->emergency_contact_email ?? 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-7" role="tabpanel" aria-labelledby="v-pills-7-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-airplane"></i>
                                                        <h4 class="fw-bold">7. Previous Travel Info</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <strong>Have you ever been to Siberia?</strong>
                                                                {{ ucfirst($application->previousTravelInfo->travel_siberia ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Have you ever gotten a Siberia visa?</strong>
                                                                {{ ucfirst($application->previousTravelInfo->previous_siberia_visa ?? 'N/A') }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <strong>Do you have any valid visa issued by other countries?</strong>
                                                                {{ ucfirst($application->previousTravelInfo->other_country_visa ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Have you visited any countries in the last 12 months?</strong>
                                                                {{ ucfirst($application->previousTravelInfo->visited_last_12_months ?? 'N/A') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-8" role="tabpanel" aria-labelledby="v-pills-8-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-bar-chart"></i>
                                                        <h4 class="fw-bold">8. Other Information</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <strong>Refused Visa:</strong> {{ ucfirst($application->otherInfo->refused_visa ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Visa Canceled:</strong> {{ ucfirst($application->otherInfo->visa_canceled ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Illegal Entry:</strong> {{ ucfirst($application->otherInfo->illegal_entry ?? 'N/A') }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <strong>Criminal Record:</strong> {{ ucfirst($application->otherInfo->criminal_record ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Health Issue:</strong> {{ ucfirst($application->otherInfo->health_issue ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Epidemic Visit:</strong> {{ ucfirst($application->otherInfo->epidemic_visit ?? 'N/A') }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <strong>Special Skill:</strong> {{ ucfirst($application->otherInfo->special_skill ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Military Service:</strong> {{ ucfirst($application->otherInfo->military_service ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Paramilitary:</strong> {{ ucfirst($application->otherInfo->paramilitary ?? 'N/A') }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <strong>Organization Work:</strong> {{ ucfirst($application->otherInfo->organization_work ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Other Declaration:</strong> {{ ucfirst($application->otherInfo->other_declaration ?? 'N/A') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-9" role="tabpanel" aria-labelledby="v-pills-9-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-check-circle"></i>
                                                        <h4 class="fw-bold">9. Declaration</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <strong>Declaration Type:</strong>
                                                                {{ ucfirst($application->declaration->declaration_type ?? 'N/A') }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Agreed:</strong>
                                                                {{ $application->declaration->agree ? 'Yes' : 'No' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-10" role="tabpanel" aria-labelledby="v-pills-10-tab">
                    <div class="skills">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="skills-grid">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="skill-card">
                                                    <div class="skill-header">
                                                        <i class="bi bi-cloud-arrow-up"></i>
                                                        <h4 class="fw-bold">10. Uploaded Materials</h4>
                                                    </div>
                                                    <div class="skill-body">
                                                        {{-- Other Country Visas --}}
                                                        @if($application->materials && ($application->materials->other_country_visa1 || $application->materials->other_country_visa2 || $application->materials->other_country_visa3 || $application->materials->other_country_visa4 || $application->materials->other_country_visa5 || $application->materials->other_country_visa6))
                                                        <h6 class="text-primary mt-4">Other Country Visas</h6>

                                                        @if($application->materials->other_country_visa1)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Other Country Visa 1:</strong><br>
                                                            @if(pathinfo($application->materials->other_country_visa1, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->other_country_visa1) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->other_country_visa1) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->other_country_visa2)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Other Country Visa 2:</strong><br>
                                                            @if(pathinfo($application->materials->other_country_visa2, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->other_country_visa2) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->other_country_visa2) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->other_country_visa3)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Other Country Visa 3:</strong><br>
                                                            @if(pathinfo($application->materials->other_country_visa3, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->other_country_visa3) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->other_country_visa3) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->other_country_visa4)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Other Country Visa 4:</strong><br>
                                                            @if(pathinfo($application->materials->other_country_visa4, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->other_country_visa4) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->other_country_visa4) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->other_country_visa5)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Other Country Visa 5:</strong><br>
                                                            @if(pathinfo($application->materials->other_country_visa5, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->other_country_visa5) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->other_country_visa5) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->other_country_visa6)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Other Country Visa 6:</strong><br>
                                                            @if(pathinfo($application->materials->other_country_visa6, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->other_country_visa6) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->other_country_visa6) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif
                                                        @endif

                                                        {{-- Bank Statements --}}
                                                        @if($application->materials && ($application->materials->bank_statement1 || $application->materials->bank_statement2 || $application->materials->bank_statement3 || $application->materials->bank_statement4))
                                                        <h6 class="text-primary mt-4">Bank Statements</h6>

                                                        @if($application->materials->bank_statement1)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Bank Statement 1:</strong><br>
                                                            @if(pathinfo($application->materials->bank_statement1, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->bank_statement1) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->bank_statement1) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->bank_statement2)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Bank Statement 2:</strong><br>
                                                            @if(pathinfo($application->materials->bank_statement2, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->bank_statement2) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->bank_statement2) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->bank_statement3)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Bank Statement 3:</strong><br>
                                                            @if(pathinfo($application->materials->bank_statement3, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->bank_statement3) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->bank_statement3) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->bank_statement4)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Bank Statement 4:</strong><br>
                                                            @if(pathinfo($application->materials->bank_statement4, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->bank_statement4) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->bank_statement4) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif
                                                        @endif

                                                        {{-- Other Documents --}}
                                                        @if($application->materials && ($application->materials->itinerary_china || $application->materials->hote_requirement || $application->materials->air_ticket || $application->materials->invitation_letter))
                                                        <h6 class="text-primary mt-4">Other Documents</h6>

                                                        @if($application->materials->itinerary_china)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Itinerary China:</strong><br>
                                                            @if(pathinfo($application->materials->itinerary_china, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->itinerary_china) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->itinerary_china) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->hote_requirement)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Hotel Requirement:</strong><br>
                                                            @if(pathinfo($application->materials->hote_requirement, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->hote_requirement) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->hote_requirement) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->air_ticket)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Air Ticket:</strong><br>
                                                            @if(pathinfo($application->materials->air_ticket, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->air_ticket) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->air_ticket) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif

                                                        @if($application->materials->invitation_letter)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <strong>Invitation Letter:</strong><br>
                                                            @if(pathinfo($application->materials->invitation_letter, PATHINFO_EXTENSION) == 'pdf')
                                                            <iframe src="{{ asset($application->materials->invitation_letter) }}" width="100%" height="400px"></iframe>
                                                            @else
                                                            <img src="{{ asset($application->materials->invitation_letter) }}" class="img-fluid" style="max-height: 400px;">
                                                            @endif
                                                        </div>
                                                        @endif
                                                        @endif

                                                        {{-- No Documents Message --}}
                                                        @if(!$application->materials || (!$application->materials->other_country_visa1 && !$application->materials->other_country_visa2 && !$application->materials->other_country_visa3 && !$application->materials->other_country_visa4 && !$application->materials->other_country_visa5 && !$application->materials->other_country_visa6 && !$application->materials->bank_statement1 && !$application->materials->bank_statement2 && !$application->materials->bank_statement3 && !$application->materials->bank_statement4 && !$application->materials->itinerary_china && !$application->materials->hote_requirement && !$application->materials->air_ticket && !$application->materials->invitation_letter))
                                                        <div class="alert alert-info mt-3">
                                                            <i class="fas fa-info-circle me-2"></i>No documents uploaded for this application.
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
