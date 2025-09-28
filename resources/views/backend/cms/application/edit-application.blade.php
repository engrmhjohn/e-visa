@extends('backend.master')
@section('title', 'Edit Application :: E-Visa')
@section('content')
<div class="page-inner mt-5 pt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Edit Application
                            </h4>
                            <div>
                                <span class="badge bg-light text-dark shadow">Tracking: {{ $application->tracking_number }}</span>
                                <span class="badge bg-success ms-2 shadow">Status: {{ ucfirst($application->status) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @for($i = 1; $i <= 10; $i++) <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => $i]) }}" class="nav-link {{ $currentStep == $i ? 'active text-white' : '' }} 
                                              {{ $application->current_step >= $i ? 'completed' : '' }}">
                                        {{ $i }}. {{ $stepNames[$i] }}
                                        </a>
                                        @endfor
                                </div>
                            </div>
                            <div class="col-md-9 col-lg-9">
                                @if(session('success'))
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <div>
                                        {{ session('success') }}
                                    </div>
                                </div>
                                @endif

                                @if(session('error'))
                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <div>
                                        {{ session('error') }}
                                    </div>
                                </div>
                                @endif
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade {{ $currentStep == 1 ? 'show active' : '' }}" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                                        <form id="personalInfoForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 1]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="row g-3">
                                                <div class="col-lg-3 col-md-4">
                                                    <label for="picture" class="form-label required-field">Upload Picture (JPG, PNG) (max. 1MB)</label>
                                                    <input type="file" id="picture" name="picture" class="dropify @error('picture') is-invalid @enderror" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png" data-height="150" accept="image/*" @if($existingData && $existingData->picture) data-default-file="{{ asset($existingData->picture) }}" @endif />
                                                    @error('picture')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-4 col-md-6">
                                                    <label for="passport_picture" class="form-label required-field">Data page of the passport (JPG, PNG) (max. 5MB)</label>
                                                    <input type="file" id="passport_picture" name="passport_picture" class="dropify @error('passport_picture') is-invalid @enderror" data-max-file-size="5M" data-allowed-file-extensions="jpg jpeg png" data-height="150" accept="image/*" @if($existingData && $existingData->passport_picture) data-default-file="{{ asset($existingData->passport_picture) }}" @endif />
                                                    @error('passport_picture')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <strong>1.1 Name</strong>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="family_name" class="form-label required-field">1.1A Family name</label>
                                                    <input type="text" class="form-control @error('family_name') is-invalid @enderror" id="family_name" name="family_name" value="{{ old('family_name', $existingData->family_name ?? '') }}" required>
                                                    @error('family_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="given_names" class="form-label required-field">1.1B Given name(s)</label>
                                                    <input type="text" class="form-control @error('given_names') is-invalid @enderror" id="given_names" name="given_names" value="{{ old('given_names', $existingData->given_names ?? '') }}" required>
                                                    @error('given_names')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="other_names" class="form-label">1.1C Other name(s) or former name(s)</label>
                                                    <input type="text" class="form-control @error('other_names') is-invalid @enderror" id="other_names" name="other_names" value="{{ old('other_names', $existingData->other_names ?? '') }}">
                                                    @error('other_names')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="siberia_name" class="form-label">1.1D Serbian name (in siberian_name, if any)</label>
                                                    <input type="text" class="form-control @error('siberia_name') is-invalid @enderror" id="siberia_name" name="siberia_name" value="{{ old('siberia_name', $existingData->siberia_name ?? '') }}">
                                                    @error('siberia_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <strong>1.2 Date of birth</strong>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="dob" class="form-label required-field">1.2A Date of birth</label>
                                                    <input type="text" id="dob" class="flat_date form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob', isset($existingData->dob) ? \Carbon\Carbon::parse($existingData->dob)->format('Y-m-d') : '') }}" required>
                                                    @error('dob')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <strong>1.3 Gender</strong>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="gender" class="form-label required-field d-block">1.3A Gender</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="male" value="male" {{ old('gender', $existingData->gender ?? '') == 'male' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="male">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="female" value="female" {{ old('gender', $existingData->gender ?? '') == 'female' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="female">Female</label>
                                                    </div>
                                                    @error('gender')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <strong>1.4 Place of birth</strong>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="birth_country_id" class="form-label required-field">1.4A Country/region</label>
                                                    <select id="birth_country_id" name="birth_country_id" class="select2 form-control @error('birth_country_id') is-invalid @enderror" required>
                                                        <option value="">--Select One--</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" {{ old('birth_country_id', $existingData->birth_country_id ?? '') == $country->id ? 'selected' : '' }}>
                                                            {{ $country->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('birth_country_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="province_state" class="form-label required-field">1.4B Province/state</label>
                                                    <input type="text" class="form-control @error('province_state') is-invalid @enderror" id="province_state" name="province_state" value="{{ old('province_state', $existingData->province_state ?? '') }}" required>
                                                    @error('province_state')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="city" class="form-label required-field">1.4C City</label>
                                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $existingData->city ?? '') }}" required>
                                                    @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <strong>1.5 Marital status</strong>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="marital_status" class="form-label required-field d-block">1.5A Marital status</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('marital_status') is-invalid @enderror" type="radio" name="marital_status" id="married" value="married" {{ old('marital_status', $existingData->marital_status ?? '') == 'married' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="married">Married</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('marital_status') is-invalid @enderror" type="radio" name="marital_status" id="divorced" value="divorced" {{ old('marital_status', $existingData->marital_status ?? '') == 'divorced' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="divorced">Divorced</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('marital_status') is-invalid @enderror" type="radio" name="marital_status" id="single" value="single" {{ old('marital_status', $existingData->marital_status ?? '') == 'single' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="single">Single</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('marital_status') is-invalid @enderror" type="radio" name="marital_status" id="widowed" value="widowed" {{ old('marital_status', $existingData->marital_status ?? '') == 'widowed' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="widowed">Widowed</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('marital_status') is-invalid @enderror" type="radio" name="marital_status" id="others" value="others" {{ old('marital_status', $existingData->marital_status ?? '') == 'others' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="others">Others</label>
                                                    </div>
                                                    @error('marital_status')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <strong>1.6 Nationality and permanent residence</strong>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="current_nationality_id" class="form-label required-field">1.6A Current nationality</label>
                                                    <select id="current_nationality_id" name="current_nationality_id" class="select2 form-control @error('current_nationality_id') is-invalid @enderror" required>
                                                        <option value="">--Select One--</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" {{ old('current_nationality_id', $existingData->current_nationality_id ?? '') == $country->id ? 'selected' : '' }}>
                                                            {{ $country->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('current_nationality_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="id_number" class="form-label required-field">1.6B ID number in the country of nationality</label>
                                                    <input type="text" class="form-control @error('id_number') is-invalid @enderror" id="id_number" name="id_number" value="{{ old('id_number', $existingData->id_number ?? '') }}" required>
                                                    @error('id_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="other_nationality" class="form-label required-field d-block">1.6C Do you have any other nationality?</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('other_nationality') is-invalid @enderror" type="radio" name="other_nationality" id="other_nationality_yes" value="yes" {{ old('other_nationality', $existingData->other_nationality ?? '') == 'yes' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="other_nationality_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('other_nationality') is-invalid @enderror" type="radio" name="other_nationality" id="other_nationality_no" value="no" {{ old('other_nationality', $existingData->other_nationality ?? '') == 'no' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="other_nationality_no">No</label>
                                                    </div>
                                                    @error('other_nationality')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="permanent_resident_status" class="form-label required-field d-block">1.6F Do you have permanent resident status in any other country or region?</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('permanent_resident_status') is-invalid @enderror" type="radio" name="permanent_resident_status" id="permanent_resident_status_yes" value="yes" {{ old('permanent_resident_status', $existingData->permanent_resident_status ?? '') == 'yes' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permanent_resident_status_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('permanent_resident_status') is-invalid @enderror" type="radio" name="permanent_resident_status" id="permanent_resident_status_no" value="no" {{ old('permanent_resident_status', $existingData->permanent_resident_status ?? '') == 'no' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permanent_resident_status_no">No</label>
                                                    </div>
                                                    @error('permanent_resident_status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="previous_nationalities" class="form-label required-field d-block">Have you ever had any other nationalities or resident status?</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('previous_nationalities') is-invalid @enderror" type="radio" name="previous_nationalities" id="previous_nationalities_yes" value="yes" {{ old('previous_nationalities', $existingData->previous_nationalities ?? '') == 'yes' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="previous_nationalities_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('previous_nationalities') is-invalid @enderror" type="radio" name="previous_nationalities" id="previous_nationalities_no" value="no" {{ old('previous_nationalities', $existingData->previous_nationalities ?? '') == 'no' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="previous_nationalities_no">No</label>
                                                    </div>
                                                    @error('previous_nationalities')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <strong>1.7 Passport information</strong>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="passport_type" class="form-label required-field d-block">1.7A Type of passport/travel document</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('passport_type') is-invalid @enderror" type="radio" name="passport_type" id="ordinary" value="ordinary" {{ old('passport_type', $existingData->passport_type ?? '') == 'ordinary' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="ordinary">Ordinary</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('passport_type') is-invalid @enderror" type="radio" name="passport_type" id="service" value="service" {{ old('passport_type', $existingData->passport_type ?? '') == 'service' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="service">Service</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('passport_type') is-invalid @enderror" type="radio" name="passport_type" id="diplomatic" value="diplomatic" {{ old('passport_type', $existingData->passport_type ?? '') == 'diplomatic' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="diplomatic">Diplomatic</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('passport_type') is-invalid @enderror" type="radio" name="passport_type" id="official" value="official" {{ old('passport_type', $existingData->passport_type ?? '') == 'official' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="official">Official</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('passport_type') is-invalid @enderror" type="radio" name="passport_type" id="special" value="special" {{ old('passport_type', $existingData->passport_type ?? '') == 'special' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="special">Special</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('passport_type') is-invalid @enderror" type="radio" name="passport_type" id="others" value="others" {{ old('passport_type', $existingData->passport_type ?? '') == 'others' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="others">Others</label>
                                                    </div>
                                                    @error('passport_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="passport_number" class="form-label required-field">1.7B Passport number</label>
                                                    <input type="text" class="form-control @error('passport_number') is-invalid @enderror" id="passport_number" name="passport_number" value="{{ old('passport_number', $existingData->passport_number ?? '') }}" required>
                                                    @error('passport_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="issuing_country_id" class="form-label required-field">1.7C Issuing country/region of the passport/travel document</label>
                                                    <select id="issuing_country_id" name="issuing_country_id" class="select2 form-control @error('issuing_country_id') is-invalid @enderror" required>
                                                        <option value="">--Select One--</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" {{ old('issuing_country_id', $existingData->issuing_country_id ?? '') == $country->id ? 'selected' : '' }}>
                                                            {{ $country->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('issuing_country_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="place_of_issue" class="form-label required-field">1.7D Place of issue</label>
                                                    <input type="text" class="form-control @error('place_of_issue') is-invalid @enderror" id="place_of_issue" name="place_of_issue" value="{{ old('place_of_issue', $existingData->place_of_issue ?? '') }}" required>
                                                    @error('place_of_issue')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="passport_expiration_date" class="form-label required-field">1.7E Expiration date</label>
                                                    <input type="text" id="passport_expiration_date" class="flat_date form-control @error('passport_expiration_date') is-invalid @enderror" name="passport_expiration_date" value="{{ old('passport_expiration_date', isset($existingData->passport_expiration_date) ? \Carbon\Carbon::parse($existingData->passport_expiration_date)->format('Y-m-d') : '') }}" required>
                                                    @error('passport_expiration_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12 text-center">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-2"></i>Update Personal Information
                                                    </button>
                                                    <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 2]) }}" class="btn btn-secondary">
                                                        Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Type of visa -->
                                    <div class="tab-pane fade {{ $currentStep == 2 ? 'show active' : '' }}" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
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
                                                                        @if($currentStep == 2)
                                                                        <div class="skill-body">
                                                                            <form id="visaTypeForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 2]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>2. Type of visa</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="visa_type" class="form-label required-field">2.1 The type of visa that you are applying for and the main purpose of Siberia</label>
                                                                                        <select id="visa_type" name="visa_type" class="select2 form-control @error('visa_type') is-invalid @enderror" required>
                                                                                            <option value="">--Select One--</option>
                                                                                            <option value="Tourism" {{ old('visa_type', $existingData->visa_type ?? '') == 'Tourism' ? 'selected' : '' }}>Tourism</option>
                                                                                            <option value="Business" {{ old('visa_type', $existingData->visa_type ?? '') == 'Business' ? 'selected' : '' }}>Business</option>
                                                                                            <option value="Work Permit" {{ old('visa_type', $existingData->visa_type ?? '') == 'Work Permit' ? 'selected' : '' }}>Work Permit</option>
                                                                                            <option value="Temporary Work" {{ old('visa_type', $existingData->visa_type ?? '') == 'Temporary Work' ? 'selected' : '' }}>Temporary Work</option>
                                                                                        </select>
                                                                                        @error('visa_type')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="tourist_type" class="form-label required-field d-block">Tourist Type</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('tourist_type') is-invalid @enderror" type="radio" name="tourist_type" id="tourist" value="tourist" {{ old('tourist_type', $existingData->tourist_type ?? '') == 'tourist' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="tourist">Tourist</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('tourist_type') is-invalid @enderror" type="radio" name="tourist_type" id="business" value="business" {{ old('tourist_type', $existingData->tourist_type ?? '') == 'business' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="business">Business</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('tourist_type') is-invalid @enderror" type="radio" name="tourist_type" id="work_permit" value="work_permit" {{ old('tourist_type', $existingData->tourist_type ?? '') == 'work_permit' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="work_permit">Work Permit</label>
                                                                                        </div>
                                                                                        @error('tourist_type')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                        <p class="mt-3 text-dark">Courtesy visas are issued at the discretion of the visa officer.</p>
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>2.2 Service type</strong>
                                                                                        <p class="text-danger">Notice: Express service does not start from the date of submitting the application form, but starts from the date when you submit you submit your passport.</p>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="service_type" class="form-label required-field d-block">Service Type</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('service_type') is-invalid @enderror" type="radio" name="service_type" id="individual" value="individual" {{ old('service_type', $existingData->service_type ?? '') == 'individual' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="individual">Individual</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('service_type') is-invalid @enderror" type="radio" name="service_type" id="group" value="group" {{ old('service_type', $existingData->service_type ?? '') == 'group' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="group">Group</label>
                                                                                        </div>
                                                                                        @error('service_type')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                        <p class="text-primary mt-3">Express service requires an extra fee and cannot be canceled once you have applied for it...</p>
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>2.3 Visa Application Information</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <label for="visa_validity" class="form-label required-field">2.3A Visa validity of your application (months)</label>
                                                                                        <input type="text" class="form-control @error('visa_validity') is-invalid @enderror" id="visa_validity" name="visa_validity" value="{{ old('visa_validity', $existingData->visa_validity ?? '') }}" required>
                                                                                        @error('visa_validity')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <label for="max_duration_stay" class="form-label required-field">2.3B Maximum duration of stay of your application (days)</label>
                                                                                        <input type="text" class="form-control @error('max_duration_stay') is-invalid @enderror" id="max_duration_stay" name="max_duration_stay" value="{{ old('max_duration_stay', $existingData->max_duration_stay ?? '') }}" required>
                                                                                        @error('max_duration_stay')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="entries" class="form-label d-block">2.3C Entries of your application</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('entries') is-invalid @enderror" type="radio" name="entries" id="single" value="single" {{ old('entries', $existingData->entries ?? '') == 'single' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="single">Single</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('entries') is-invalid @enderror" type="radio" name="entries" id="multiple" value="multiple" {{ old('entries', $existingData->entries ?? '') == 'multiple' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="multiple">Multiple</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('entries') is-invalid @enderror" type="radio" name="entries" id="work_permit" value="work_permit" {{ old('entries', $existingData->entries ?? '') == 'work_permit' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="work_permit">Work Permit</label>
                                                                                        </div>
                                                                                        @error('entries')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                        <p class="text-primary mt-3">
                                                                                            The decision pertaining to the entries, validity, and duration of stay...
                                                                                        </p>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Update Type of Visa
                                                                                        </button>
                                                                                        <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 3]) }}" class="btn btn-secondary">
                                                                                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Skills Grid -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Work information -->
                                    <div class="tab-pane fade {{ $currentStep == 3 ? 'show active' : '' }}" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
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
                                                                            <form id="workInfoForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 3]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <label for="occupation" class="form-label required-field">3.1 Current Occupation</label>
                                                                                        <select id="occupation" name="occupation" class="select2 form-control @error('occupation') is-invalid @enderror" required>
                                                                                            <option value="">-- Select Occupation --</option>
                                                                                            <option value="Businessperson" {{ old('occupation', $existingData->occupation ?? '') == 'Businessperson' ? 'selected' : '' }}>Businessperson</option>
                                                                                            <option value="Company employee" {{ old('occupation', $existingData->occupation ?? '') == 'Company employee' ? 'selected' : '' }}>Company employee</option>
                                                                                            <option value="Entertainer" {{ old('occupation', $existingData->occupation ?? '') == 'Entertainer' ? 'selected' : '' }}>Entertainer</option>
                                                                                            <option value="Industrial/agricultural worker" {{ old('occupation', $existingData->occupation ?? '') == 'Industrial/agricultural worker' ? 'selected' : '' }}>Industrial/agricultural worker</option>
                                                                                            <option value="Student" {{ old('occupation', $existingData->occupation ?? '') == 'Student' ? 'selected' : '' }}>Student</option>
                                                                                            <option value="Member of parliament" {{ old('occupation', $existingData->occupation ?? '') == 'Member of parliament' ? 'selected' : '' }}>Member of parliament</option>
                                                                                            <option value="Government official" {{ old('occupation', $existingData->occupation ?? '') == 'Government official' ? 'selected' : '' }}>Government official</option>
                                                                                            <option value="Teacher" {{ old('occupation', $existingData->occupation ?? '') == 'Teacher' ? 'selected' : '' }}>Teacher</option>
                                                                                            <option value="Researcher" {{ old('occupation', $existingData->occupation ?? '') == 'Researcher' ? 'selected' : '' }}>Researcher</option>
                                                                                            <option value="Medical professional" {{ old('occupation', $existingData->occupation ?? '') == 'Medical professional' ? 'selected' : '' }}>Medical professional</option>
                                                                                            <option value="Engineer/Technician" {{ old('occupation', $existingData->occupation ?? '') == 'Engineer/Technician' ? 'selected' : '' }}>Engineer/Technician</option>
                                                                                            <option value="Self-employed" {{ old('occupation', $existingData->occupation ?? '') == 'Self-employed' ? 'selected' : '' }}>Self-employed</option>
                                                                                            <option value="Unemployed" {{ old('occupation', $existingData->occupation ?? '') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                                                                                            <option value="Retired" {{ old('occupation', $existingData->occupation ?? '') == 'Retired' ? 'selected' : '' }}>Retired</option>
                                                                                            <option value="Other" {{ old('occupation', $existingData->occupation ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                                                                        </select>
                                                                                        @error('occupation')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>3.2 Work Experience in the past five years</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <label for="work_exp_date_from" class="form-label required-field">3.2A Date from</label>
                                                                                        <input type="text" class="flat_date form-control @error('work_exp_date_from') is-invalid @enderror" name="work_exp_date_from" value="{{ old('work_exp_date_from', isset($existingData->work_exp_date_from) ? \Carbon\Carbon::parse($existingData->work_exp_date_from)->format('Y-m-d') : '') }}" required>
                                                                                        @error('work_exp_date_from')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <label for="work_exp_date_to" class="form-label required-field">3.2A Date to</label>
                                                                                        <input type="text" class="flat_date form-control @error('work_exp_date_to') is-invalid @enderror" name="work_exp_date_to" value="{{ old('work_exp_date_to', isset($existingData->work_exp_date_to) ? \Carbon\Carbon::parse($existingData->work_exp_date_to)->format('Y-m-d') : '') }}" required>
                                                                                        @error('work_exp_date_to')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>3.2B Name of your employer</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="employer_name" class="form-label required-field">Name of your employer</label>
                                                                                        <input type="text" class="form-control @error('employer_name') is-invalid @enderror" id="employer_name" name="employer_name" value="{{ old('employer_name', $existingData->employer_name ?? '') }}" required>
                                                                                        @error('employer_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="employer_address" class="form-label required-field">Address of your employer</label>
                                                                                        <input type="text" class="form-control @error('employer_address') is-invalid @enderror" id="employer_address" name="employer_address" value="{{ old('employer_address', $existingData->employer_address ?? '') }}" required>
                                                                                        @error('employer_address')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="employer_telephone" class="form-label required-field">Telephone of your employer</label>
                                                                                        <input type="text" class="form-control @error('employer_telephone') is-invalid @enderror" id="employer_telephone" name="employer_telephone" value="{{ old('employer_telephone', $existingData->employer_telephone ?? '') }}" required>
                                                                                        @error('employer_telephone')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>3.2C Supervisor</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="supervisor_name" class="form-label required-field">3.2C Name of your supervisor</label>
                                                                                        <input type="text" class="form-control @error('supervisor_name') is-invalid @enderror" id="supervisor_name" name="supervisor_name" value="{{ old('supervisor_name', $existingData->supervisor_name ?? '') }}" required>
                                                                                        @error('supervisor_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="supervisor_telephone" class="form-label required-field">Telephone of your supervisor</label>
                                                                                        <input type="text" class="form-control @error('supervisor_telephone') is-invalid @enderror" id="supervisor_telephone" name="supervisor_telephone" value="{{ old('supervisor_telephone', $existingData->supervisor_telephone ?? '') }}" required>
                                                                                        @error('supervisor_telephone')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>3.2D Position</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="position_name" class="form-label">Position Name</label>
                                                                                        <input type="text" class="form-control @error('position_name') is-invalid @enderror" id="position_name" name="position_name" value="{{ old('position_name', $existingData->position_name ?? '') }}" required>
                                                                                        @error('position_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>3.2E Duty</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="duty_name" class="form-label">Duty Name</label>
                                                                                        <input type="text" class="form-control @error('duty_name') is-invalid @enderror" id="duty_name" name="duty_name" value="{{ old('duty_name', $existingData->duty_name ?? '') }}" required>
                                                                                        @error('duty_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Update Work Information
                                                                                        </button>
                                                                                        <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 4]) }}" class="btn btn-secondary">
                                                                                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Skills Grid -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Education -->
                                    <div class="tab-pane fade {{ $currentStep == 4 ? 'show active' : '' }}" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
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
                                                                            <form id="educationForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 4]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>4.1 Highest Diploma / Degree</strong>
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="institute_name" class="form-label required-field">4.1A Name of institute of education</label>
                                                                                        <input type="text" class="form-control @error('institute_name') is-invalid @enderror" id="institute_name" name="institute_name" value="{{ old('institute_name', $existingData->institute_name ?? '') }}" required>
                                                                                        @error('institute_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="degree_name" class="form-label required-field">4.1B Diploma / Degree</label>
                                                                                        <select id="degree_name" name="degree_name" class="select2 form-control @error('degree_name') is-invalid @enderror" required>
                                                                                            <option value="">-- Select Degree --</option>
                                                                                            <option value="Technical secondary school/high school or equivalent" {{ old('degree_name', $existingData->degree_name ?? '') == 'Technical secondary school/high school or equivalent' ? 'selected' : '' }}>
                                                                                                Technical secondary school/high school or equivalent
                                                                                            </option>
                                                                                            <option value="Junior college/undergraduate degree or equivalent" {{ old('degree_name', $existingData->degree_name ?? '') == 'Junior college/undergraduate degree or equivalent' ? 'selected' : '' }}>
                                                                                                Junior college/undergraduate degree or equivalent
                                                                                            </option>
                                                                                            <option value="Masters degree or equivalent" {{ old('degree_name', $existingData->degree_name ?? '') == 'Masters degree or equivalent' ? 'selected' : '' }}>
                                                                                                Master's degree or equivalent
                                                                                            </option>
                                                                                            <option value="Doctoral degree or above" {{ old('degree_name', $existingData->degree_name ?? '') == 'Doctoral degree or above' ? 'selected' : '' }}>
                                                                                                Doctoral degree or above
                                                                                            </option>
                                                                                            <option value="Other" {{ old('degree_name', $existingData->degree_name ?? '') == 'Other' ? 'selected' : '' }}>
                                                                                                Other
                                                                                            </option>
                                                                                        </select>
                                                                                        @error('degree_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="major_degree" class="form-label">4.1C Major</label>
                                                                                        <input type="text" class="form-control @error('major_degree') is-invalid @enderror" id="major_degree" name="major_degree" value="{{ old('major_degree', $existingData->major_degree ?? '') }}" required>
                                                                                        @error('major_degree')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Education
                                                                                        </button>
                                                                                        <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 5]) }}" class="btn btn-secondary">
                                                                                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Skills Grid -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Family Information -->
                                    <div class="tab-pane fade {{ $currentStep == 5 ? 'show active' : '' }}" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-5-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
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
                                                                            <form id="familyInfoForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 5]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>5.1 Current home address</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="current_home_address" class="form-label required-field">Current home address</label>
                                                                                        <input type="text" class="form-control @error('current_home_address') is-invalid @enderror" name="current_home_address" value="{{ old('current_home_address', $existingData->current_home_address ?? '') }}" required>
                                                                                        @error('current_home_address')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <label for="home_phone_number" class="form-label required-field">5.2 Phone Number</label>
                                                                                        <input type="text" class="form-control @error('home_phone_number') is-invalid @enderror" name="home_phone_number" value="{{ old('home_phone_number', $existingData->home_phone_number ?? '') }}" required>
                                                                                        @error('home_phone_number')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="home_mobile_number" class="form-label required-field">5.3 Mobile Phone Number</label>
                                                                                        <input type="text" class="form-control @error('home_mobile_number') is-invalid @enderror" name="home_mobile_number" value="{{ old('home_mobile_number', $existingData->home_mobile_number ?? '') }}" required>
                                                                                        @error('home_mobile_number')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="home_email" class="form-label">5.4 Email</label>
                                                                                        <input type="email" class="form-control @error('home_email') is-invalid @enderror" name="home_email" value="{{ old('home_email', $existingData->home_email ?? '') }}" required>
                                                                                        @error('home_email')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>5.5 Family Members</strong>
                                                                                    </div>

                                                                                    {{-- Father --}}
                                                                                    <div class="col-lg-12">
                                                                                        <strong>5.5B Father</strong>
                                                                                        <label for="father_family_name" class="form-label required-field">Family Name</label>
                                                                                        <input type="text" class="form-control @error('father_family_name') is-invalid @enderror" id="father_family_name" name="father_family_name" value="{{ old('father_family_name', $existingData->father_family_name ?? '') }}" required>
                                                                                        @error('father_family_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="father_givenname" class="form-label required-field">Given Name</label>
                                                                                        <input type="text" class="form-control @error('father_givenname') is-invalid @enderror" id="father_givenname" name="father_givenname" value="{{ old('father_givenname', $existingData->father_givenname ?? '') }}" required>
                                                                                        @error('father_givenname')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="father_nationality_id" class="form-label required-field">Nationality</label>
                                                                                        <select id="father_nationality_id" name="father_nationality_id" class="select2 form-control @error('father_nationality_id') is-invalid @enderror" required>
                                                                                            <option value="">--Select One--</option>
                                                                                            @foreach ($countries as $country)
                                                                                            <option value="{{ $country->id }}" {{ old('father_nationality_id', $existingData->father_nationality_id ?? '') == $country->id ? 'selected' : '' }}>
                                                                                                {{ $country->name }}
                                                                                            </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('father_nationality_id')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="father_dob" class="form-label required-field">Date of birth</label>
                                                                                        <input type="text" class="flat_date form-control @error('father_dob') is-invalid @enderror" name="father_dob" value="{{ old('father_dob', isset($existingData->father_dob) ? \Carbon\Carbon::parse($existingData->father_dob)->format('Y-m-d') : '') }}" required>
                                                                                        @error('father_dob')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="father_siberia_origin" class="form-label required-field d-block">Is your father in Siberia?</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('father_siberia_origin') is-invalid @enderror" type="radio" name="father_siberia_origin" id="father_yes" value="1" {{ old('father_siberia_origin', $existingData->father_siberia_origin ?? '') == '1' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="father_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('father_siberia_origin') is-invalid @enderror" type="radio" name="father_siberia_origin" id="father_no" value="0" {{ old('father_siberia_origin', $existingData->father_siberia_origin ?? '') == '0' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="father_no">No</label>
                                                                                        </div>
                                                                                        @error('father_siberia_origin')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    {{-- Mother --}}
                                                                                    <div class="col-lg-12">
                                                                                        <strong>5.5C Mother</strong>
                                                                                        <label for="mother_family_name" class="form-label required-field">Mother Name</label>
                                                                                        <input type="text" class="form-control @error('mother_family_name') is-invalid @enderror" id="mother_family_name" name="mother_family_name" value="{{ old('mother_family_name', $existingData->mother_family_name ?? '') }}" required>
                                                                                        @error('mother_family_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="mother_givenname" class="form-label required-field">Given Name</label>
                                                                                        <input type="text" class="form-control @error('mother_givenname') is-invalid @enderror" id="mother_givenname" name="mother_givenname" value="{{ old('mother_givenname', $existingData->mother_givenname ?? '') }}" required>
                                                                                        @error('mother_givenname')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="mother_nationality_id" class="form-label required-field">Nationality</label>
                                                                                        <select id="mother_nationality_id" name="mother_nationality_id" class="select2 form-control @error('mother_nationality_id') is-invalid @enderror" required>
                                                                                            <option value="">--Select One--</option>
                                                                                            @foreach ($countries as $country)
                                                                                            <option value="{{ $country->id }}" {{ old('mother_nationality_id', $existingData->mother_nationality_id ?? '') == $country->id ? 'selected' : '' }}>
                                                                                                {{ $country->name }}
                                                                                            </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('mother_nationality_id')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="mother_dob" class="form-label required-field">Date of birth</label>
                                                                                        <input type="text" class="flat_date form-control @error('mother_dob') is-invalid @enderror" name="mother_dob" value="{{ old('mother_dob', isset($existingData->mother_dob) ? \Carbon\Carbon::parse($existingData->mother_dob)->format('Y-m-d') : '') }}" required>
                                                                                        @error('mother_dob')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="mother_siberia_origin" class="form-label required-field d-block">Is your mother in Siberia?</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('mother_siberia_origin') is-invalid @enderror" type="radio" name="mother_siberia_origin" id="mother_yes" value="1" {{ old('mother_siberia_origin', $existingData->mother_siberia_origin ?? '') == '1' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="mother_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('mother_siberia_origin') is-invalid @enderror" type="radio" name="mother_siberia_origin" id="mother_no" value="0" {{ old('mother_siberia_origin', $existingData->mother_siberia_origin ?? '') == '0' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="mother_no">No</label>
                                                                                        </div>
                                                                                        @error('mother_siberia_origin')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    {{-- Children --}}
                                                                                    <div class="col-lg-12">
                                                                                        <strong>5.5D Children</strong>
                                                                                        <label for="children_family_name" class="form-label">Children Name</label>
                                                                                        <input type="text" class="form-control @error('children_family_name') is-invalid @enderror" id="children_family_name" name="children_family_name" value="{{ old('children_family_name', $existingData->children_family_name ?? '') }}" required>
                                                                                        @error('children_family_name')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="children_givenname" class="form-label">Given Name</label>
                                                                                        <input type="text" class="form-control @error('children_givenname') is-invalid @enderror" id="children_givenname" name="children_givenname" value="{{ old('children_givenname', $existingData->children_givenname ?? '') }}" required>
                                                                                        @error('children_givenname')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="children_nationality_id" class="form-label">Nationality</label>
                                                                                        <select id="children_nationality_id" name="children_nationality_id" class="select2 form-control @error('children_nationality_id') is-invalid @enderror" required>
                                                                                            <option value="">--Select One--</option>
                                                                                            @foreach ($countries as $country)
                                                                                            <option value="{{ $country->id }}" {{ old('children_nationality_id', $existingData->children_nationality_id ?? '') == $country->id ? 'selected' : '' }}>
                                                                                                {{ $country->name }}
                                                                                            </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('children_nationality_id')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <label for="children_dob" class="form-label">Date of birth</label>
                                                                                        <input type="text" class="flat_date form-control @error('children_dob') is-invalid @enderror" name="children_dob" value="{{ old('children_dob', isset($existingData->children_dob) ? \Carbon\Carbon::parse($existingData->children_dob)->format('Y-m-d') : '') }}" required>
                                                                                        @error('children_dob')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>


                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Family Information
                                                                                        </button>
                                                                                        <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 6]) }}" class="btn btn-secondary">
                                                                                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Skills Grid -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Travel Information -->
                                    <div class="tab-pane fade {{ $currentStep == 6 ? 'show active' : '' }}" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-6-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
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
                                                                            <form id="travelInfoForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 6]) }}" method="POST" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong class="required-field">6.1A Visa Category</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <!-- Tourist -->
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="radio" name="visa_category" id="visa_category_tourist" value="tourist" {{ old('visa_category', $existingData->visa_category ?? '') == 'tourist' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="visa_category_tourist">Tourist</label>
                                                                                        </div>
                                                                                        <!-- Business -->
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="radio" name="visa_category" id="visa_category_business" value="business" {{ old('visa_category', $existingData->visa_category ?? '') == 'business' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="visa_category_business">Business</label>
                                                                                        </div>
                                                                                        <!-- Work -->
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="radio" name="visa_category" id="visa_category_work" value="work" {{ old('visa_category', $existingData->visa_category ?? '') == 'work' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="visa_category_work">Work Permit</label>
                                                                                        </div>
                                                                                        @error('visa_category')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <!-- Hidden sections -->
                                                                                    <div class="{{ in_array(old('visa_category', $existingData->visa_category ?? ''), ['tourist','business']) ? '' : 'd-none' }}" id="tourist_business_div">
                                                                                        <div class="col-lg-12">
                                                                                            <label for="hotel_name" class="form-label">6.1B Hotel Name</label>
                                                                                            <input type="text" class="form-control @error('hotel_name') is-invalid @enderror" name="hotel_name" value="{{ old('hotel_name', $existingData->hotel_name ?? '') }}">
                                                                                            @error('hotel_name')
                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div class="col-lg-12">
                                                                                            <label for="hotel_address" class="form-label">6.1C Hotel Address</label>
                                                                                            <input type="text" class="form-control @error('hotel_address') is-invalid @enderror" name="hotel_address" value="{{ old('hotel_address', $existingData->hotel_address ?? '') }}">
                                                                                            @error('hotel_address')
                                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                                            @enderror
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="{{ old('visa_category', $existingData->visa_category ?? '') == 'work' ? '' : 'd-none' }}" id="work_div">
                                                                                        <div class="col-lg-4">
                                                                                            <label for="company_approval_letter" class="form-label">
                                                                                                Company Approval Letter (JPG, PNG) (max. 2MB)
                                                                                            </label>
                                                                                            <input type="file" id="company_approval_letter" name="company_approval_letter" class="dropify @error('company_approval_letter') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png" data-height="150" accept="image/*" @if($existingData && $existingData->company_approval_letter)
                                                                                            data-default-file="{{ asset($existingData->company_approval_letter) }}"
                                                                                            @endif
                                                                                            />
                                                                                            @error('company_approval_letter')
                                                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                            @enderror
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>6.2 Inviting person/contact or organization in Siberia</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="inviting_name" class="form-label required-field">6.2A Name</label>
                                                                                        <input type="text" class="form-control @error('inviting_name') is-invalid @enderror" name="inviting_name" value="{{ old('inviting_name', $existingData->inviting_name ?? '') }}" required>
                                                                                        @error('inviting_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="inviting_relationship" class="form-label required-field">6.2B Contact person relationship with you</label>
                                                                                        <input type="text" class="form-control @error('inviting_relationship') is-invalid @enderror" name="inviting_relationship" value="{{ old('inviting_relationship', $existingData->inviting_relationship ?? '') }}" required>
                                                                                        @error('inviting_relationship') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="inviting_phone_number" class="form-label required-field">6.2C Phone Number</label>
                                                                                        <input type="text" class="form-control @error('inviting_phone_number') is-invalid @enderror" name="inviting_phone_number" value="{{ old('inviting_phone_number', $existingData->inviting_phone_number ?? '') }}" required>
                                                                                        @error('inviting_phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="inviting_email" class="form-label">6.2D Email</label>
                                                                                        <input type="email" class="form-control @error('inviting_email') is-invalid @enderror" name="inviting_email" value="{{ old('inviting_email', $existingData->inviting_email ?? '') }}" required>
                                                                                        @error('inviting_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="inviting_city" class="form-label required-field">6.2E City</label>
                                                                                        <input type="text" class="form-control @error('inviting_city') is-invalid @enderror" name="inviting_city" value="{{ old('inviting_city', $existingData->inviting_city ?? '') }}" required>
                                                                                        @error('inviting_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="inviting_district" class="form-label">District / Country</label>
                                                                                        <input type="text" class="form-control @error('inviting_district') is-invalid @enderror" name="inviting_district" value="{{ old('inviting_district', $existingData->inviting_district ?? '') }}" required>
                                                                                        @error('inviting_district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="inviting_post_code" class="form-label">6.2F Post Code</label>
                                                                                        <input type="text" class="form-control @error('inviting_post_code') is-invalid @enderror" name="inviting_post_code" value="{{ old('inviting_post_code', $existingData->inviting_post_code ?? '') }}" required>
                                                                                        @error('inviting_post_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>6.3 Emergency Contact</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="emergency_contact_family_name" class="form-label required-field">6.3A Family Name</label>
                                                                                        <input type="text" class="form-control @error('emergency_contact_family_name') is-invalid @enderror" id="emergency_contact_family_name" name="emergency_contact_family_name" value="{{ old('emergency_contact_family_name', $existingData->emergency_contact_family_name ?? '') }}" required>
                                                                                        @error('emergency_contact_family_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="emergency_contact_givenname" class="form-label required-field">Given Name</label>
                                                                                        <input type="text" class="form-control @error('emergency_contact_givenname') is-invalid @enderror" id="emergency_contact_givenname" name="emergency_contact_givenname" value="{{ old('emergency_contact_givenname', $existingData->emergency_contact_givenname ?? '') }}" required>
                                                                                        @error('emergency_contact_givenname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="emergency_contact_relationship" class="form-label required-field">6.3B Relationship with you</label>
                                                                                        <input type="text" class="form-control @error('emergency_contact_relationship') is-invalid @enderror" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $existingData->emergency_contact_relationship ?? '') }}" required>
                                                                                        @error('emergency_contact_relationship') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="emergency_contact_phone_number" class="form-label required-field">6.3C Phone Number</label>
                                                                                        <input type="text" class="form-control @error('emergency_contact_phone_number') is-invalid @enderror" name="emergency_contact_phone_number" value="{{ old('emergency_contact_phone_number', $existingData->emergency_contact_phone_number ?? '') }}" required>
                                                                                        @error('emergency_contact_phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="emergency_contact_email" class="form-label">6.3D Email</label>
                                                                                        <input type="email" class="form-control @error('emergency_contact_email') is-invalid @enderror" name="emergency_contact_email" value="{{ old('emergency_contact_email', $existingData->emergency_contact_email ?? '') }}" required>
                                                                                        @error('emergency_contact_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>6.4 Who will pay for this travel</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="travel_payer" class="form-label required-field d-block">6.4A Who will pay for this travel?</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('travel_payer') is-invalid @enderror" type="radio" name="travel_payer" id="payer_self" value="self" {{ old('travel_payer', $existingData->travel_payer ?? '') == 'self' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="payer_self">Self</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('travel_payer') is-invalid @enderror" type="radio" name="travel_payer" id="payer_other" value="other" {{ old('travel_payer', $existingData->travel_payer ?? '') == 'other' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="payer_other">Other</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('travel_payer') is-invalid @enderror" type="radio" name="travel_payer" id="payer_org" value="organization" {{ old('travel_payer', $existingData->travel_payer ?? '') == 'organization' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="payer_org">Organization</label>
                                                                                        </div>
                                                                                        @error('travel_payer') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>6.5 Person sharing the same passport with you</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="same_passport" class="form-label required-field d-block">
                                                                                            6.5A Are you travelling with someone who shares the same passport with you?
                                                                                        </label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('same_passport') is-invalid @enderror" type="radio" name="same_passport" id="same_passport_yes" value="1" {{ old('same_passport', $existingData->same_passport ?? '') == '1' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="same_passport_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('same_passport') is-invalid @enderror" type="radio" name="same_passport" id="same_passport_no" value="0" {{ old('same_passport', $existingData->same_passport ?? '') == '0' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="same_passport_no">No</label>
                                                                                        </div>
                                                                                        @error('same_passport') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Travel Information
                                                                                        </button>
                                                                                        <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 7]) }}" class="btn btn-secondary">
                                                                                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Skills Grid -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Previous travel Information -->
                                    <div class="tab-pane fade {{ $currentStep == 7 ? 'show active' : '' }}" id="v-pills-7" role="tabpanel" aria-labelledby="v-pills-7-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
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
                                                                            <form id="previousTravelInfoForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 7]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>7.1 Information on previous travel</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="travel_siberia" class="form-label required-field d-block">7.1A Have you ever been to Siberia?</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('travel_siberia') is-invalid @enderror" type="radio" name="travel_siberia" id="travel_siberia_yes" value="yes" {{ ($existingData->travel_siberia ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="travel_siberia_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('travel_siberia') is-invalid @enderror" type="radio" name="travel_siberia" id="travel_siberia_no" value="no" {{ ($existingData->travel_siberia ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="travel_siberia_no">No</label>
                                                                                        </div>
                                                                                        @error('travel_siberia')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>7.2 Previous Siberia visa</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="previous_siberia_visa" class="form-label required-field d-block">7.2A Have you ever gotten a Siberia visa?</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('previous_siberia_visa') is-invalid @enderror" type="radio" name="previous_siberia_visa" id="previous_siberia_visa_yes" value="yes" {{ ($existingData->previous_siberia_visa ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="previous_siberia_visa_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('previous_siberia_visa') is-invalid @enderror" type="radio" name="previous_siberia_visa" id="previous_siberia_visa_no" value="no" {{ ($existingData->previous_siberia_visa ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="previous_siberia_visa_no">No</label>
                                                                                        </div>
                                                                                        @error('previous_siberia_visa')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>7.3 Do you have any valid visa issued by other countries</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="other_country_visa" class="form-label required-field d-block">7.3 Do you have any valid visa issued by other countries?</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('other_country_visa') is-invalid @enderror" type="radio" name="other_country_visa" id="other_country_visa_yes" value="yes" {{ ($existingData->other_country_visa ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="other_country_visa_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('other_country_visa') is-invalid @enderror" type="radio" name="other_country_visa" id="other_country_visa_no" value="no" {{ ($existingData->other_country_visa ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="other_country_visa_no">No</label>
                                                                                        </div>
                                                                                        @error('other_country_visa')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>7.4 Countries you have visited in the last 12 months</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label for="visited_last_12_months" class="form-label required-field d-block">7.4A Have you visited any countries in the last 12 months?</label>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('visited_last_12_months') is-invalid @enderror" type="radio" name="visited_last_12_months" id="visited_last_12_months_yes" value="yes" {{ ($existingData->visited_last_12_months ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="visited_last_12_months_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('visited_last_12_months') is-invalid @enderror" type="radio" name="visited_last_12_months" id="visited_last_12_months_no" value="no" {{ ($existingData->visited_last_12_months ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="visited_last_12_months_no">No</label>
                                                                                        </div>
                                                                                        @error('visited_last_12_months')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Update Previous Travel Info
                                                                                        </button>
                                                                                        <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 8]) }}" class="btn btn-secondary">
                                                                                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Skills Grid -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Other Information -->
                                    <div class="tab-pane fade {{ $currentStep == 8 ? 'show active' : '' }}" id="v-pills-8" role="tabpanel" aria-labelledby="v-pills-8-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
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
                                                                            <form id="otherInfoForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 8]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>8.1 Have you ever been refused a Siberian visa or denied entry into Siberia?</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('refused_visa') is-invalid @enderror" type="radio" name="refused_visa" id="refused_visa_yes" value="yes" {{ ($existingData->refused_visa ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="refused_visa_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('refused_visa') is-invalid @enderror" type="radio" name="refused_visa" id="refused_visa_no" value="no" {{ ($existingData->refused_visa ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="refused_visa_no">No</label>
                                                                                        </div>
                                                                                        @error('refused_visa')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <strong>8.2 Has your Siberian visa ever been canceled?</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('visa_canceled') is-invalid @enderror" type="radio" name="visa_canceled" id="visa_canceled_yes" value="yes" {{ ($existingData->visa_canceled ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="visa_canceled_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('visa_canceled') is-invalid @enderror" type="radio" name="visa_canceled" id="visa_canceled_no" value="no" {{ ($existingData->visa_canceled ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="visa_canceled_no">No</label>
                                                                                        </div>
                                                                                        @error('visa_canceled')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <strong>8.3 Have you ever entered Siberia illegally, overstayed, or worked illegally in Siberia?</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('illegal_entry') is-invalid @enderror" type="radio" name="illegal_entry" id="illegal_entry_yes" value="yes" {{ ($existingData->illegal_entry ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="illegal_entry_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('illegal_entry') is-invalid @enderror" type="radio" name="illegal_entry" id="illegal_entry_no" value="no" {{ ($existingData->illegal_entry ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="illegal_entry_no">No</label>
                                                                                        </div>
                                                                                        @error('illegal_entry')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-12">
                                                                                        <strong>8.4 Do you have any criminal record in Siberia or any other country?</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('criminal_record') is-invalid @enderror" type="radio" name="criminal_record" id="criminal_record_yes" value="yes" {{ ($existingData->criminal_record ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="criminal_record_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error('criminal_record') is-invalid @enderror" type="radio" name="criminal_record" id="criminal_record_no" value="no" {{ ($existingData->criminal_record ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="criminal_record_no">No</label>
                                                                                        </div>
                                                                                        @error('criminal_record')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    {{-- Repeat same pattern for 8.5 to 8.11 --}}
                                                                                    @php
                                                                                    $fields = [
                                                                                    'health_issue' => '8.5 Do you have any serious mental disorders or infectious diseases?',
                                                                                    'epidemic_visit' => '8.6 Have you ever visited countries or regions in the past 30 days where there is an epidemic?',
                                                                                    'special_skill' => '8.7 Do you have or have you ever been trained to have any special skill in terms of firearms, explosives, or nuclear devices, or in the biological or chemical fields?',
                                                                                    'military_service' => '8.8 Are you serving or have you ever served in the military?',
                                                                                    'paramilitary' => '8.9 Have you ever served or participated in any paramilitary organization, civil armed unit, guerrilla force, or rebel organization, or ever been a member of one?',
                                                                                    'organization_work' => '8.10 Have you worked for any professional, social, or charitable organization?',
                                                                                    'other_declaration' => '8.11 Is there anything else you want to declare?'
                                                                                    ];
                                                                                    @endphp

                                                                                    @foreach($fields as $field => $question)
                                                                                    <div class="col-lg-12"><strong>{{ $question }}</strong></div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error($field) is-invalid @enderror" type="radio" name="{{ $field }}" id="{{ $field }}_yes" value="yes" {{ ($existingData->$field ?? '') == 'yes' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="{{ $field }}_yes">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input @error($field) is-invalid @enderror" type="radio" name="{{ $field }}" id="{{ $field }}_no" value="no" {{ ($existingData->$field ?? '') == 'no' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="{{ $field }}_no">No</label>
                                                                                        </div>
                                                                                        @error($field)
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    @endforeach
                                                                                </div>

                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Update Other Information
                                                                                        </button>
                                                                                        <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 8]) }}" class="btn btn-secondary">
                                                                                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Skills Grid -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Declaration -->
                                    <div class="tab-pane fade {{ $currentStep == 9 ? 'show active' : '' }}" id="v-pills-9" role="tabpanel" aria-labelledby="v-pills-9-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
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
                                                                            <form id="declarationForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 9]) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>9.1 The person who fill in the form</strong>
                                                                                    </div>
                                                                                    <div class="col-lg-12 mb-3">
                                                                                        <label class="form-label">Declaration Type</label> <br>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="radio" name="declaration_type" id="declaration_applicant" value="applicant" {{ ($existingData->declaration_type ?? '') == 'applicant' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="declaration_applicant">Applicant</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input" type="radio" name="declaration_type" id="declaration_behalf" value="behalf" {{ ($existingData->declaration_type ?? '') == 'behalf' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="declaration_behalf">On behalf of Applicant</label>
                                                                                        </div>
                                                                                        @error('declaration_type')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div id="applicant_div" class="col-lg-12 {{ ($existingData->declaration_type ?? '') == 'applicant' ? '' : 'd-none' }}">
                                                                                        <p>
                                                                                            I hereby declare that I have read and understood all contents of this application form
                                                                                            and shall bear all legal consequences for the authenticity of the information and
                                                                                            application materials I provide.
                                                                                        </p>
                                                                                        <p>
                                                                                            I understand that the final decision on whether to grant a visa and the visa type,
                                                                                            number of entries, validity, and duration of each stay will be determined by the
                                                                                            consular officer, and that any false, misleading, or incomplete statement may result in
                                                                                            the refusal of a visa or denial of entry into Siberia.
                                                                                        </p>
                                                                                        <div class="form-check mt-3">
                                                                                            <input class="form-check-input" type="checkbox" name="agree" value="1" id="agree1" checked>
                                                                                            <label class="form-check-label" for="agree1">
                                                                                                I understand and agree with the above.
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div id="behalf_div" class="col-lg-12 {{ ($existingData->declaration_type ?? '') == 'behalf' ? '' : 'd-none' }}">
                                                                                        <p>
                                                                                            My visa application will be submitted at <strong>DHAKA</strong> (city) to the Siberian visa issuing authorities.
                                                                                        </p>
                                                                                        <p>
                                                                                            Notice: A parent or guardian should sign on behalf of a minor under the age of 18.
                                                                                        </p>
                                                                                        <div class="form-check mt-3">
                                                                                            <input class="form-check-input" type="checkbox" name="agree" value="1" id="agree2" checked>
                                                                                            <label class="form-check-label" for="agree2">
                                                                                                I understand and agree with the above.
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Update Declaration
                                                                                        </button>
                                                                                        <a href="{{ route('admin.applications.edit', ['application' => $application->id, 'step' => 9]) }}" class="btn btn-secondary">
                                                                                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- End Skills Grid -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Upload Materials -->
                                    <div class="tab-pane fade {{ $currentStep == 10 ? 'show active' : '' }}" id="v-pills-10" role="tabpanel" aria-labelledby="v-pills-10-tab">
                                        <div class="skills">
                                            <div class="container" data-aos="fade-up" data-aos-delay="100">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="skills-grid">
                                                            <div class="row g-4">
                                                                <div class="col-md-12">
                                                                    <div class="skill-card">
                                                                        <div class="skill-header">
                                                                            <i class="bi bi-cloud-arrow-up"></i>
                                                                            <h4 class="fw-bold">10. Upload Materials</h4>
                                                                        </div>
                                                                        <div class="skill-body">
                                                                            <form id="uploadMaterialsForm" action="{{ route('admin.applications.update-step', ['application' => $application->id, 'step' => 10]) }}" method="POST" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-12">
                                                                                        <strong>Valid or previous visas for other countries</strong>
                                                                                    </div>

                                                                                    <div class="col-lg-4">
                                                                                        <label for="other_country_visa1" class="form-label required-field">All Other Country visa (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="other_country_visa1" name="other_country_visa1" class="dropify @error('other_country_visa1') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->other_country_visa1) data-default-file="{{ asset($existingData->other_country_visa1) }}" @endif />
                                                                                        @error('other_country_visa1')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-4">
                                                                                        <label for="other_country_visa2" class="form-label">All Other Country visa (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="other_country_visa2" name="other_country_visa2" class="dropify @error('other_country_visa2') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->other_country_visa2) data-default-file="{{ asset($existingData->other_country_visa2) }}" @endif />
                                                                                        @error('other_country_visa2')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-4">
                                                                                        <label for="other_country_visa3" class="form-label">All Other Country visa (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="other_country_visa3" name="other_country_visa3" class="dropify @error('other_country_visa3') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->other_country_visa3) data-default-file="{{ asset($existingData->other_country_visa3) }}" @endif />
                                                                                        @error('other_country_visa3')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-4">
                                                                                        <label for="other_country_visa4" class="form-label">All Other Country visa (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="other_country_visa4" name="other_country_visa4" class="dropify @error('other_country_visa4') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->other_country_visa4) data-default-file="{{ asset($existingData->other_country_visa4) }}" @endif />
                                                                                        @error('other_country_visa4')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-4">
                                                                                        <label for="other_country_visa5" class="form-label">All Other Country visa (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="other_country_visa5" name="other_country_visa5" class="dropify @error('other_country_visa5') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->other_country_visa5) data-default-file="{{ asset($existingData->other_country_visa5) }}" @endif />
                                                                                        @error('other_country_visa5')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-4">
                                                                                        <label for="other_country_visa6" class="form-label">All Other Country visa (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="other_country_visa6" name="other_country_visa6" class="dropify @error('other_country_visa6') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->other_country_visa6) data-default-file="{{ asset($existingData->other_country_visa6) }}" @endif />
                                                                                        @error('other_country_visa6')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-4 col-md-6">
                                                                                        <label for="itinerary_siberia" class="form-label required-field">Itinerary in Siberia (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="itinerary_siberia" name="itinerary_siberia" class="dropify @error('itinerary_siberia') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->itinerary_siberia) data-default-file="{{ asset($existingData->itinerary_siberia) }}" @endif />
                                                                                        @error('itinerary_siberia')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>
                                                                                <div class="row g-3">
                                                                                                                                                                        <div class="col-lg-4 col-md-6">
                                                                                        <label for="hote_requirement" class="form-label required-field">Hotel reservation with complete payment (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="hote_requirement" name="hote_requirement" class="dropify @error('hote_requirement') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->hote_requirement) data-default-file="{{ asset($existingData->hote_requirement) }}" @endif />
                                                                                        @error('hote_requirement')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>
                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-4 col-md-6">
                                                                                        <label for="bank_statement1" class="form-label required-field">Bank Statement 1 (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="bank_statement1" name="bank_statement1" class="dropify @error('bank_statement1') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->bank_statement1) data-default-file="{{ asset($existingData->bank_statement1) }}" @endif />
                                                                                        @error('bank_statement1')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-4 col-md-6">
                                                                                        <label for="bank_statement2" class="form-label">Bank Statement 2 (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="bank_statement2" name="bank_statement2" class="dropify @error('bank_statement2') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->bank_statement2) data-default-file="{{ asset($existingData->bank_statement2) }}" @endif />
                                                                                        @error('bank_statement2')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-4 col-md-6">
                                                                                        <label for="bank_statement3" class="form-label">Bank Statement 3 (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="bank_statement3" name="bank_statement3" class="dropify @error('bank_statement3') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->bank_statement3) data-default-file="{{ asset($existingData->bank_statement3) }}" @endif />
                                                                                        @error('bank_statement3')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-lg-4 col-md-6">
                                                                                        <label for="bank_statement4" class="form-label">Bank Statement 4 (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="bank_statement4" name="bank_statement4" class="dropify @error('bank_statement4') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->bank_statement4) data-default-file="{{ asset($existingData->bank_statement4) }}" @endif />
                                                                                        @error('bank_statement4')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                                                                                                        <div class="col-lg-4 col-md-6">
                                                                                        <label for="air_ticket" class="form-label required-field">Round trip air ticket (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="air_ticket" name="air_ticket" class="dropify @error('air_ticket') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->air_ticket) data-default-file="{{ asset($existingData->air_ticket) }}" @endif />
                                                                                        @error('air_ticket')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="row g-3">
                                                                                    <div class="col-lg-4 col-md-6">
                                                                                        <label for="invitation_letter" class="form-label required-field">Invitation Letter (JPG, PNG, PDF) (max. 2MB)</label>
                                                                                        <input type="file" id="invitation_letter" name="invitation_letter" class="dropify @error('invitation_letter') is-invalid @enderror" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png pdf" data-height="150" accept=".jpg,.jpeg,.png,.pdf" @if($existingData && $existingData->invitation_letter) data-default-file="{{ asset($existingData->invitation_letter) }}" @endif />
                                                                                        @error('invitation_letter')
                                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-3">
                                                                                    <div class="col-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary">
                                                                                            <i class="fas fa-save me-2"></i>Update Materials
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- End Skills Grid -->
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
@push('script')
<script>
    $(document).ready(function() {
        // Visa Category Toggle
        $('input[name="visa_category"]').change(function() {
            const value = $(this).val();
            const touristBusinessDiv = $("#tourist_business_div");
            const workDiv = $("#work_div");

            // Hide both divs first
            touristBusinessDiv.addClass("d-none");
            workDiv.addClass("d-none");

            // Remove all required classes and attributes
            $('label[for="hotel_name"], label[for="hotel_address"], label[for="company_approval_letter"]')
                .removeClass("required-field");
            $('input[name="hotel_name"], input[name="hotel_address"], input[name="company_approval_letter"]')
                .removeAttr('required');

            if (value === "tourist" || value === "business") {
                touristBusinessDiv.removeClass("d-none");
                $('label[for="hotel_name"], label[for="hotel_address"]').addClass("required-field");
                $('input[name="hotel_name"], input[name="hotel_address"]').attr('required', 'required');
            } else if (value === "work") {
                workDiv.removeClass("d-none");

                const companyLetterInput = $('input[name="company_approval_letter"]');
                $('label[for="company_approval_letter"]').addClass("required-field");

                // ✅ Only set required if no existing file
                if (!companyLetterInput.attr("data-default-file")) {
                    companyLetterInput.attr('required', 'required');
                }
            }
        });

        // Trigger change event on page load if any radio is checked
        $('input[name="visa_category"]:checked').trigger('change');

        // Declaration Type Toggle (unchanged)
        $('input[name="declaration_type"]').change(function() {
            const value = $(this).val();
            $("#applicant_div, #behalf_div").addClass("d-none");

            if (value === "applicant") {
                $("#applicant_div").removeClass("d-none");
            } else if (value === "behalf") {
                $("#behalf_div").removeClass("d-none");
            }
        });

        // Trigger change event on page load if any declaration radio is checked
        $('input[name="declaration_type"]:checked').trigger('change');
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formIds = [
            'personalInfoForm'
            , 'visaTypeForm'
            , 'workInfoForm'
            , 'educationForm'
            , 'familyInfoForm'
            , 'travelInfoForm'
            , 'previousTravelInfoForm'
            , 'otherInfoForm'
            , 'declarationForm'
            , 'uploadMaterialsForm'
        ];

        formIds.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function() {
                    Swal.fire({
                        title: 'Processing...'
                        , text: 'Please wait while we save your information.'
                        , allowOutsideClick: false
                        , allowEscapeKey: false
                        , allowEnterKey: false
                        , didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });
            }
        });
    });

</script>
@endpush
