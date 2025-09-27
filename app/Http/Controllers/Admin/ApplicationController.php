<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Country;

use App\Models\Material;
use App\Models\VisaType;
use App\Models\WorkInfo;
use App\Models\Education;
use App\Models\OtherInfo;
use App\Models\FamilyInfo;
use App\Models\TravelInfo;
use App\Models\Declaration;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;
use App\Models\EducationInfo;
use App\Models\ApplicationForm;
use App\Models\PreviousTravelInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Application\VisaTypeRequest;
use App\Http\Requests\Application\WorkInfoRequest;
use App\Http\Requests\Application\FamilyInfoRequest;
use App\Http\Requests\Application\PersonalInfoRequest;
use App\Http\Requests\Application\EducationRequest;
use App\Http\Requests\Application\TravelInfoRequest;
use App\Http\Requests\Application\PreviousTravelInfoRequest;
use App\Http\Requests\Application\OtherInfoRequest;
use App\Http\Requests\Application\DeclarationRequest;
use App\Http\Requests\Application\MaterialRequest;

require_once app_path('Helpers/FileUploadHelper.php');

class ApplicationController extends Controller
{
    public function showApplicationForm(Request $request)
    {
        $countries = Country::all();
        $currentStep = $request->get('step', 1);
        
        // Get step names for navigation
        $stepNames = $this->getStepNames();
        
        // Always create a new application when coming to step 1
        if ($currentStep == 1) {
            $application = $this->createNewApplication();
            session(['current_application_id' => $application->id]);
        } else {
            // For other steps, get the current application from session
            $application = $this->getCurrentApplication();
        }
        
        // If no application exists but we're beyond step 1, redirect to step 1
        if (!$application && $currentStep > 1) {
            return redirect()->route('apply.now', ['step' => 1]);
        }
        
        // Get existing application data for the current step
        $existingData = [];
        
        if ($application) {
            switch($currentStep) {
                case 1:
                    $existingData = PersonalInfo::where('application_id', $application->id)->first();
                    break;
                case 2:
                    $existingData = VisaType::where('application_id', $application->id)->first();
                    break;
                case 3:
                    $existingData = WorkInfo::where('application_id', $application->id)->first();
                    break;
                case 4:
                    $existingData = EducationInfo::where('application_id', $application->id)->first();
                    break;
                case 5:
                    $existingData = FamilyInfo::where('application_id', $application->id)->first();
                    break;
                case 6:
                    $existingData = TravelInfo::where('application_id', $application->id)->first();
                    break;
                case 7:
                    $existingData = PreviousTravelInfo::where('application_id', $application->id)->first();
                    break;
                case 8:
                    $existingData = OtherInfo::where('application_id', $application->id)->first();
                    break;
                case 9:
                    $existingData = Declaration::where('application_id', $application->id)->first();
                    break;
                case 10:
                    $existingData = Material::where('application_id', $application->id)->first();
                    break;
            }
        }

        return view('frontend.apply.apply', compact(
            'countries', 
            'currentStep', 
            'stepNames',
            'existingData',
            'application'
        ));
    }

    private function getStepNames()
    {
        return [
            1 => 'Personal Information',
            2 => 'Type of Visa',
            3 => 'Work Information',
            4 => 'Education',
            5 => 'Family Information',
            6 => 'Travel Information',
            7 => 'Previous Travel Info',
            8 => 'Other Information',
            9 => 'Declaration',
            10 => 'Upload Materials'
        ];
    }

    private function getCurrentApplication()
    {
        $applicationId = session('current_application_id');
        
        if ($applicationId) {
            $application = ApplicationForm::find($applicationId);
            
            // Only return if it's still a draft (not submitted)
            if ($application && $application->status === 'draft') {
                return $application;
            }
        }
        
        return null;
    }

    private function createNewApplication()
    {
        if (auth()->check()) {
            $application = ApplicationForm::create([
                'user_id' => auth()->id(),
                'status' => 'draft',
                'current_step' => 1,
                 'tracking_number' => null,
            ]);
        } else {
            $application = ApplicationForm::create([
                'status' => 'draft',
                'current_step' => 1,
                 'tracking_number' => null,
            ]);
            session(['temp_application_id' => $application->id]);
        }
        
        return $application;
    }

    private function uploadFile($file, $path)
    {
        if (!$file) {
            return null;
        }
        
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('uploads/' . $path, $fileName, 'public');
    }

    private function generateTrackingNumber($givenNames, $familyName)
    {
        // Get first name from given names (handle multiple given names)
        $firstName = explode(' ', trim($givenNames))[0];
        
        // Clean the name (remove special characters, keep only letters)
        $firstName = preg_replace('/[^A-Za-z]/', '', $firstName);
        
        // Generate 16 random digits
        $randomDigits = mt_rand(1000000000000000, 9999999999999999);
        
        // Combine: FirstName-RandomDigits
        return $firstName . '-' . $randomDigits;
    }


public function saveStep1(PersonalInfoRequest $request)
{
    try {
        // Get the current application from session
        $application = $this->getCurrentApplication();
        
        if (!$application) {
            return redirect()->route('apply.now', ['step' => 1])
                ->with('error', 'Please start a new application.');
        }

        // Generate tracking number
        $trackingNumber = $this->generateTrackingNumber($request->given_names, $request->family_name);

        // Handle file uploads directly to public folder
        $picturePath = null;
        $passportPicturePath = null;

        if ($request->hasFile('picture')) {
            $picturePath = uploadFile($request->file('picture'), 'uploads/profile-pictures');
        }

        if ($request->hasFile('passport_picture')) {
            $passportPicturePath = uploadFile($request->file('passport_picture'), 'uploads/passport-pictures');
        }

        // Save personal info
        PersonalInfo::updateOrCreate(
            ['application_id' => $application->id],
            [
                'picture' => $picturePath,
                'passport_picture' => $passportPicturePath,
                'family_name' => $request->family_name,
                'given_names' => $request->given_names,
                'other_names' => $request->other_names,
                'siberia_name' => $request->siberia_name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'birth_country_id' => $request->birth_country_id,
                'province_state' => $request->province_state,
                'city' => $request->city,
                'marital_status' => $request->marital_status,
                'current_nationality_id' => $request->current_nationality_id,
                'id_number' => $request->id_number,
                'other_nationality' => $request->other_nationality,
                'permanent_resident_status' => $request->permanent_resident_status,
                'previous_nationalities' => $request->previous_nationalities,
                'passport_type' => $request->passport_type,
                'passport_number' => $request->passport_number,
                'issuing_country_id' => $request->issuing_country_id,
                'place_of_issue' => $request->place_of_issue,
                'passport_expiration_date' => $request->passport_expiration_date
            ]
        );

        // Update application with tracking number
        $application->update([
            'current_step' => 2,
            'tracking_number' => $trackingNumber
        ]);

        return redirect()->route('apply.now', ['step' => 2])
            ->with('success', 'Personal information saved successfully!')->with('step', '2');

    } catch (\Exception $e) {
        // Delete uploaded files if error occurs
        if (isset($picturePath) && $picturePath) {
            deleteFile($picturePath);
        }
        if (isset($passportPicturePath) && $passportPicturePath) {
            deleteFile($passportPicturePath);
        }
        
        return redirect()->back()
            ->with('error', 'Error saving information: ' . $e->getMessage())
            ->withInput();
    }
}
    public function saveStep2(VisaTypeRequest $request)
        {
            try {
                $application = $this->getCurrentApplication();
                
                if (!$application) {
                    return redirect()->route('apply.now', ['step' => 1])
                        ->with('error', 'Please complete Step 1 first.');
                }

                VisaType::updateOrCreate(
                    ['application_id' => $application->id],
                    [
                        'visa_type' => $request->visa_type,
                        'tourist_type' => $request->tourist_type,
                        'service_type' => $request->service_type,
                        'visa_validity' => $request->visa_validity,
                        'max_duration_stay' => $request->max_duration_stay,
                        'entries' => $request->entries,
                    ]
                );

                $application->update(['current_step' => 3]);

                return redirect()->route('apply.now', ['step' => 3])
                    ->with('success', 'Visa type information saved successfully!')->with('step', '3');

            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Error saving visa information: ' . $e->getMessage())
                    ->withInput();
            }
        }

    public function saveStep3(WorkInfoRequest $request)
    {
        try {
            // Validation is automatically handled by WorkInfoRequest
            
            // Get application
            $application = $this->getCurrentApplication();
            
            if (!$application) {
                return redirect()->route('apply.now', ['step' => 1])
                    ->with('error', 'Please complete Step 1 first.');
            }

            // Save work information
            WorkInfo::updateOrCreate(
                ['application_id' => $application->id],
                [
                    // 3.1 Current Occupation
                    'occupation' => $request->occupation,

                    // 3.2 Work Experience in the past five years
                    'work_exp_date_from' => $request->work_exp_date_from,
                    'work_exp_date_to' => $request->work_exp_date_to,

                    // Employer Information
                    'employer_name' => $request->employer_name,
                    'employer_address' => $request->employer_address,
                    'employer_telephone' => $request->employer_telephone,

                    // Supervisor Information
                    'supervisor_name' => $request->supervisor_name,
                    'supervisor_telephone' => $request->supervisor_telephone,

                    // Position & Duty
                    'position_name' => $request->position_name,
                    'duty_name' => $request->duty_name,
                ]
            );

            // Update application current step
            $application->update(['current_step' => 4]);

            return redirect()->route('apply.now', ['step' => 4])
                ->with('success', 'Work information saved successfully!')->with('step', '4');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving work information: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function saveStep4(EducationRequest $request)
    {
        try {
            // Validation is automatically handled by EducationRequest
            
            // Get application
            $application = $this->getCurrentApplication();
            
            if (!$application) {
                return redirect()->route('apply.now', ['step' => 1])
                    ->with('error', 'Please complete Step 1 first.');
            }

            // Save education information
            EducationInfo::updateOrCreate(
                ['application_id' => $application->id],
                [
                    'institute_name' => $request->institute_name,
                    'degree_name' => $request->degree_name,
                    'major_degree' => $request->major_degree,
                ]
            );

            // Update application current step
            $application->update(['current_step' => 5]);

            return redirect()->route('apply.now', ['step' => 5])
                ->with('success', 'Education information saved successfully!')->with('step', '5');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving education information: ' . $e->getMessage())
                ->withInput();
        }
    }

        public function saveStep5(FamilyInfoRequest $request)
    {
        try {
            // Validation is automatically handled by FamilyInfoRequest
            
            // Get application
            $application = $this->getCurrentApplication();
            
            if (!$application) {
                return redirect()->route('apply.now', ['step' => 1])
                    ->with('error', 'Please complete Step 1 first.');
            }

            // Save family information
            FamilyInfo::updateOrCreate(
                ['application_id' => $application->id],
                [
                    // 5.1 Current home address
                    'current_home_address' => $request->current_home_address,

                    // 5.2 Phone Number
                    'home_phone_number' => $request->home_phone_number,

                    // 5.3 Mobile Phone Number
                    'home_mobile_number' => $request->home_mobile_number,

                    // 5.4 Email
                    'home_email' => $request->home_email,

                    // Father Information
                    'father_family_name' => $request->father_family_name,
                    'father_givenname' => $request->father_givenname,
                    'father_nationality_id' => $request->father_nationality_id,
                    'father_dob' => $request->father_dob,
                    'father_siberia_origin' => $request->has('father_siberia_origin'),

                    // Mother Information
                    'mother_family_name' => $request->mother_family_name,
                    'mother_givenname' => $request->mother_givenname,
                    'mother_nationality_id' => $request->mother_nationality_id,
                    'mother_dob' => $request->mother_dob,
                    'mother_siberia_origin' => $request->has('mother_siberia_origin'),

                    // Children Information
                    'children_family_name' => $request->children_family_name,
                    'children_givenname' => $request->children_givenname,
                    'children_nationality_id' => $request->children_nationality_id,
                    'children_dob' => $request->children_dob,
                ]
            );

            // Update application current step
            $application->update(['current_step' => 6]);

            return redirect()->route('apply.now', ['step' => 6])
                ->with('success', 'Family information saved successfully!')->with('step', '6');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving family information: ' . $e->getMessage())
                ->withInput();
        }
    }

public function saveStep6(TravelInfoRequest $request)
{
    try {
        // Validation is automatically handled by TravelInfoRequest
        
        // Get application
        $application = $this->getCurrentApplication();
        
        if (!$application) {
            return redirect()->route('apply.now', ['step' => 1])
                ->with('error', 'Please complete Step 1 first.');
        }

        // Handle file upload for company approval letter
        $companyApprovalLetterPath = null;
        if ($request->hasFile('company_approval_letter')) {
            $companyApprovalLetterPath = uploadFile($request->file('company_approval_letter'), 'uploads/company-letters');
        }

        // Save travel information
        TravelInfo::updateOrCreate(
            ['application_id' => $application->id],
            [
                // 6.1 Visa Category
                'visa_category' => $request->visa_category,

                // 6.1B & 6.1C Hotel info (tourist/business)
                'hotel_name' => $request->hotel_name,
                'hotel_address' => $request->hotel_address,

                // 6.1D Work (Company Approval Letter file path)
                'company_approval_letter' => $companyApprovalLetterPath,

                // 6.2 Inviting Person / Organization in Siberia
                'inviting_name' => $request->inviting_name,
                'inviting_relationship' => $request->inviting_relationship,
                'inviting_phone_number' => $request->inviting_phone_number,
                'inviting_email' => $request->inviting_email,
                'inviting_city' => $request->inviting_city,
                'inviting_district' => $request->inviting_district,
                'inviting_post_code' => $request->inviting_post_code,

                // 6.3 Emergency Contact
                'emergency_contact_family_name' => $request->emergency_contact_family_name,
                'emergency_contact_givenname' => $request->emergency_contact_givenname,
                'emergency_contact_relationship' => $request->emergency_contact_relationship,
                'emergency_contact_phone_number' => $request->emergency_contact_phone_number,
                'emergency_contact_email' => $request->emergency_contact_email,

                // 6.4 Who will pay for this travel
                'travel_payer' => $request->travel_payer,

                // 6.5 Same passport
                'same_passport' => $request->has('same_passport'),
            ]
        );

        // Update application current step
        $application->update(['current_step' => 7]);

        return redirect()->route('apply.now', ['step' => 7])
            ->with('success', 'Travel information saved successfully!')->with('step', '7');

    } catch (\Exception $e) {
        // Delete uploaded file if error occurs
        if (isset($companyApprovalLetterPath) && $companyApprovalLetterPath) {
            deleteFile($companyApprovalLetterPath);
        }
        
        return redirect()->back()
            ->with('error', 'Error saving travel information: ' . $e->getMessage())
            ->withInput();
    }
}

    public function saveStep7(PreviousTravelInfoRequest $request)
    {
        try {
            // Validation is automatically handled by PreviousTravelInfoRequest
            
            // Get application
            $application = $this->getCurrentApplication();
            
            if (!$application) {
                return redirect()->route('apply.now', ['step' => 1])
                    ->with('error', 'Please complete Step 1 first.');
            }

            // Save previous travel information
            PreviousTravelInfo::updateOrCreate(
                ['application_id' => $application->id],
                [
                    // 7.1 - Have you ever been to Siberia?
                    'travel_siberia' => $request->travel_siberia,

                    // 7.2 - Have you ever gotten a Chinese visa?
                    'previous_siberia_visa' => $request->previous_siberia_visa,

                    // 7.3 - Do you have any valid visa issued by other countries?
                    'other_country_visa' => $request->other_country_visa,

                    // 7.4 - Have you visited any countries in the last 12 months?
                    'visited_last_12_months' => $request->visited_last_12_months,
                ]
            );

            // Update application current step
            $application->update(['current_step' => 8]);

            return redirect()->route('apply.now', ['step' => 8])
                ->with('success', 'Previous travel information saved successfully!')->with('step', '8');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving previous travel information: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function saveStep8(OtherInfoRequest $request)
    {
        try {
            // Validation is automatically handled by OtherInfoRequest
            
            // Get application
            $application = $this->getCurrentApplication();
            
            if (!$application) {
                return redirect()->route('apply.now', ['step' => 1])
                    ->with('error', 'Please complete Step 1 first.');
            }

            // Save other information
            OtherInfo::updateOrCreate(
                ['application_id' => $application->id],
                [
                    'refused_visa' => $request->refused_visa,
                    'visa_canceled' => $request->visa_canceled,
                    'illegal_entry' => $request->illegal_entry,
                    'criminal_record' => $request->criminal_record,
                    'health_issue' => $request->health_issue,
                    'epidemic_visit' => $request->epidemic_visit,
                    'special_skill' => $request->special_skill,
                    'military_service' => $request->military_service,
                    'paramilitary' => $request->paramilitary,
                    'organization_work' => $request->organization_work,
                    'other_declaration' => $request->other_declaration,
                ]
            );

            // Update application current step
            $application->update(['current_step' => 9]);

            return redirect()->route('apply.now', ['step' => 9])
                ->with('success', 'Other information saved successfully!')->with('step', '9');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving other information: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function saveStep9(DeclarationRequest $request)
    {
        try {
            // Validation is automatically handled by DeclarationRequest
            
            // Get application
            $application = $this->getCurrentApplication();
            
            if (!$application) {
                return redirect()->route('apply.now', ['step' => 1])
                    ->with('error', 'Please complete Step 1 first.');
            }

            // Save declaration information
            Declaration::updateOrCreate(
                ['application_id' => $application->id],
                [
                    'declaration_type' => $request->declaration_type,
                    'agree' => $request->has('agree'),
                ]
            );

            // Update application current step
            $application->update(['current_step' => 10]);

            return redirect()->route('apply.now', ['step' => 10])
                ->with('success', 'Declaration saved successfully!')->with('step', '10');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving declaration: ' . $e->getMessage())
                ->withInput();
        }
    }

public function saveStep10(MaterialRequest $request)
{
    $uploadedFiles = [];
    
    try {
        $application = $this->getCurrentApplication();
        
        if (!$application) {
            return redirect()->route('apply.now', ['step' => 1])
                ->with('error', 'Please complete Step 1 first.');
        }

        // Handle file uploads for all materials
        $otherCountryVisa1Path = $request->hasFile('other_country_visa1') ? uploadFile($request->file('other_country_visa1'), 'uploads/other-visas') : null;
        $otherCountryVisa2Path = $request->hasFile('other_country_visa2') ? uploadFile($request->file('other_country_visa2'), 'uploads/other-visas') : null;
        $otherCountryVisa3Path = $request->hasFile('other_country_visa3') ? uploadFile($request->file('other_country_visa3'), 'uploads/other-visas') : null;
        $otherCountryVisa4Path = $request->hasFile('other_country_visa4') ? uploadFile($request->file('other_country_visa4'), 'uploads/other-visas') : null;
        $otherCountryVisa5Path = $request->hasFile('other_country_visa5') ? uploadFile($request->file('other_country_visa5'), 'uploads/other-visas') : null;
        $otherCountryVisa6Path = $request->hasFile('other_country_visa6') ? uploadFile($request->file('other_country_visa6'), 'uploads/other-visas') : null;

        $itinerarySiberiaPath = $request->hasFile('itinerary_siberia') ? uploadFile($request->file('itinerary_siberia'), 'uploads/itinerary') : null;
        $hotelRequirementPath = $request->hasFile('hote_requirement') ? uploadFile($request->file('hote_requirement'), 'uploads/hotel-requirements') : null;
        
        $bankStatement1Path = $request->hasFile('bank_statement1') ? uploadFile($request->file('bank_statement1'), 'uploads/bank-statements') : null;
        $bankStatement2Path = $request->hasFile('bank_statement2') ? uploadFile($request->file('bank_statement2'), 'uploads/bank-statements') : null;
        $bankStatement3Path = $request->hasFile('bank_statement3') ? uploadFile($request->file('bank_statement3'), 'uploads/bank-statements') : null;
        $bankStatement4Path = $request->hasFile('bank_statement4') ? uploadFile($request->file('bank_statement4'), 'uploads/bank-statements') : null;

        $airTicketPath = $request->hasFile('air_ticket') ? uploadFile($request->file('air_ticket'), 'uploads/air-tickets') : null;
        $invitationLetterPath = $request->hasFile('invitation_letter') ? uploadFile($request->file('invitation_letter'), 'uploads/invitation-letters') : null;

        // Store all file paths for error handling
        $uploadedFiles = array_filter([
            $otherCountryVisa1Path, $otherCountryVisa2Path, $otherCountryVisa3Path,
            $otherCountryVisa4Path, $otherCountryVisa5Path, $otherCountryVisa6Path,
            $itinerarySiberiaPath, $hotelRequirementPath,
            $bankStatement1Path, $bankStatement2Path, $bankStatement3Path, $bankStatement4Path,
            $airTicketPath, $invitationLetterPath
        ]);

        // Save materials information
        Material::updateOrCreate(
            ['application_id' => $application->id],
            [
                'other_country_visa1' => $otherCountryVisa1Path,
                'other_country_visa2' => $otherCountryVisa2Path,
                'other_country_visa3' => $otherCountryVisa3Path,
                'other_country_visa4' => $otherCountryVisa4Path,
                'other_country_visa5' => $otherCountryVisa5Path,
                'other_country_visa6' => $otherCountryVisa6Path,
                'itinerary_siberia' => $itinerarySiberiaPath,
                'hote_requirement' => $hotelRequirementPath,
                'bank_statement1' => $bankStatement1Path,
                'bank_statement2' => $bankStatement2Path,
                'bank_statement3' => $bankStatement3Path,
                'bank_statement4' => $bankStatement4Path,
                'air_ticket' => $airTicketPath,
                'invitation_letter' => $invitationLetterPath,
            ]
        );

        // MARK APPLICATION AS SUBMITTED
        $application->update([
            'current_step' => 10,
            'status' => 'submitted',
            'submitted_at' => now()
        ]);

        // CLEAR SESSION so next "Apply Now" starts fresh
        session()->forget('current_application_id');
        return redirect()->route('application.submitted', ['application' => $application->id])
            ->with('success', 'Application submitted successfully! Thank you for your submission.');

    } catch (\Exception $e) {
        // Delete all uploaded files if error occurs
        foreach ($uploadedFiles as $filePath) {
            if ($filePath) {
                deleteFile($filePath);
            }
        }
        
        return redirect()->back()
            ->with('error', 'Error uploading materials: ' . $e->getMessage())
            ->withInput();
    }
}

    public function showSubmitted(ApplicationForm $application)
    {
        // Laravel will automatically find the application by ID
        
        // Verify ownership
        if (auth()->check() && auth()->id() !== $application->user_id) {
            abort(403);
        }

        // Load relationships
        $application->load([
            'personalInfo',
            'visaType', 
            'workInfo',
            'familyInfo',
            'educationInfo',
            'travelInfo',
            'previousTravelInfo',
            'otherInfo',
            'declaration',
            'materials'
        ]);

        return view('frontend.apply.submitted', compact('application'));
    }

    public function showTrack(){
        return view('frontend.apply.track');
    }

public function searchApplication(Request $request)
{
    $trackingNumber = $request->input('tracking_number');
    $passportNumber = $request->input('passport_number');
    $dob = $request->input('dob');

    // Validate that either tracking number OR passport+dob is provided
    if (!$trackingNumber && (!$passportNumber || !$dob)) {
        return response()->json([
            'success' => false,
            'message' => 'Please provide either Tracking Number OR Passport Number with Date of Birth.',
        ]);
    }

    $query = ApplicationForm::with(['personalInfo']);

    if ($trackingNumber) {
        // Search by tracking number
        $application = $query->where('tracking_number', $trackingNumber)->first();
    } else {
        // Search by passport number and date of birth
        $application = $query->whereHas('personalInfo', function($q) use ($passportNumber, $dob) {
            $q->where('passport_number', $passportNumber)
              ->where('dob', $dob);
        })->first();
    }

    if ($application) {
        return response()->json([
            'success' => true,
            'data' => [
                'tracking_number' => $application->tracking_number,
                'applicant_name' => $application->personalInfo->given_names . ' ' . $application->personalInfo->family_name,
                'passport_number' => $application->personalInfo->passport_number,
                'dob' => $application->personalInfo->dob,
                'status' => $application->status,
                'current_step' => $application->current_step,
                'submitted_at' => $application->submitted_at,
                'created_at' => $application->created_at,
                'admin_notes' => $application->admin_notes,
            ],
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No application found with the provided details.',
        ]);
    }
}
}
