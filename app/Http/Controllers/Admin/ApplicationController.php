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

    public function editApplication(ApplicationForm $application, Request $request)
    {
        $currentStep = $request->get('step', 1);
        $countries = Country::all();
        
        // Get step names for navigation
        $stepNames = $this->getStepNames();
        
        // Get existing data for the current step
        $existingData = [];
        
        switch($currentStep) {
            case 1:
                $existingData = $application->personalInfo;
                break;
            case 2:
                $existingData = $application->visaType;
                break;
            case 3:
                $existingData = $application->workInfo;
                break;
            case 4:
                $existingData = $application->educationInfo;
                break;
            case 5:
                $existingData = $application->familyInfo;
                break;
            case 6:
                $existingData = $application->travelInfo;
                break;
            case 7:
                $existingData = $application->previousTravelInfo;
                break;
            case 8:
                $existingData = $application->otherInfo;
                break;
            case 9:
                $existingData = $application->declaration;
                break;
            case 10:
                $existingData = $application->materials;
                break;
        }

        return view('backend.cms.application.edit-application', compact(
            'application',
            'currentStep',
            'countries',
            'stepNames',
            'existingData'
        ));
    }

    public function updateApplicationStep(ApplicationForm $application, Request $request, $step)
    {
        try {
            switch($step) {
                case 1:
                    return $this->updateStep1($application, $request);
                case 2:
                    return $this->updateStep2($application, $request);
                case 3:
                    return $this->updateStep3($application, $request);
                case 4:
                    return $this->updateStep4($application, $request);
                case 5:
                    return $this->updateStep5($application, $request);
                case 6:
                    return $this->updateStep6($application, $request);
                case 7:
                    return $this->updateStep7($application, $request);
                case 8:
                    return $this->updateStep8($application, $request);
                case 9:
                    return $this->updateStep9($application, $request);
                case 10:
                    return $this->updateStep10($application, $request);
                default:
                    return redirect()->back()->with('error', 'Invalid step');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating information: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function updateStep1(ApplicationForm $application, Request $request)
    {
        // Check if files already exist in database
        $hasExistingPicture = $application->personalInfo && $application->personalInfo->picture;
        $hasExistingPassportPicture = $application->personalInfo && $application->personalInfo->passport_picture;

        // Manually validate - make file fields nullable if they already exist
        $validatedData = $request->validate([
            // Uploads - make nullable if files exist
            'picture'            => $hasExistingPicture ? 'nullable|file|mimes:jpg,jpeg,png|max:2048' : 'required|file|mimes:jpg,jpeg,png|max:2048',
            'passport_picture'   => $hasExistingPassportPicture ? 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048' : 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // 1.1 Name
            'family_name'        => 'required|string|max:255',
            'given_names'        => 'required|string|max:255',
            'other_names'        => 'nullable|string|max:255',
            'siberia_name'       => 'nullable|string|max:255',

            // 1.2 Date of birth
            'dob'                => 'required|date',

            // 1.3 Gender
            'gender'             => 'required|in:male,female',

            // 1.4 Place of birth
            'birth_country_id'   => 'required|exists:countries,id',
            'province_state'     => 'required|string|max:255',
            'city'               => 'required|string|max:255',

            // 1.5 Marital status
            'marital_status'     => 'required|in:married,divorced,single,widowed,others',

            // 1.6 Nationality and permanent residence
            'current_nationality_id' => 'required|exists:countries,id',
            'id_number'              => 'required|string|max:100',
            'other_nationality'      => 'required|in:yes,no',
            'permanent_resident_status' => 'required|in:yes,no',
            'previous_nationalities' => 'required|in:yes,no',

            // 1.7 Passport information
            'passport_type'          => 'required|in:ordinary,service,diplomatic,official,special,others',
            'passport_number'        => 'required|string|max:100',
            'issuing_country_id'     => 'required|exists:countries,id',
            'place_of_issue'         => 'required|string|max:255',
            'passport_expiration_date' => 'required|date|after:today',
        ],
        [
            // Uploads
            'picture.required'           => 'Profile picture is required.',
            'picture.mimes'              => 'Profile picture must be in JPG, JPEG or PNG format.',
            'passport_picture.required'  => 'Passport data page is required.',
            'passport_picture.mimes'     => 'Passport picture must be a JPG, JPEG, PNG, or PDF file.',

            // Name
            'family_name.required'       => 'Family name is required.',
            'given_names.required'       => 'Given name(s) is required.',

            // Date of birth
            'dob.required'               => 'Date of birth is required.',
            'dob.date'                   => 'Please provide a valid date of birth.',

            // Gender
            'gender.required'            => 'Gender is required.',
            'gender.in'                  => 'Gender must be either male or female.',

            // Place of birth
            'birth_country_id.required'  => 'Birth country is required.',
            'province_state.required'    => 'Province/State is required.',
            'city.required'              => 'City is required.',

            // Marital status
            'marital_status.required'    => 'Marital status is required.',

            // Nationality
            'current_nationality_id.required' => 'Current nationality is required.',
            'id_number.required'              => 'ID/Passport number is required.',
            'other_nationality.required'      => 'Please specify if you have other nationality.',
            'permanent_resident_status.required' => 'Please specify permanent resident status.',
            'previous_nationalities.required' => 'Please specify previous nationalities information.',

            // Passport
            'passport_type.required'     => 'Passport type is required.',
            'passport_number.required'   => 'Passport number is required.',
            'issuing_country_id.required'=> 'Issuing country is required.',
            'place_of_issue.required'    => 'Place of issue is required.',
            'passport_expiration_date.required' => 'Passport expiration date is required.',
            'passport_expiration_date.after'    => 'Passport expiration date must be in the future.',
        ]);

        // File handling
        $picturePath = $application->personalInfo->picture ?? null;
        $passportPicturePath = $application->personalInfo->passport_picture ?? null;

        if ($request->hasFile('picture')) {
            if ($picturePath) deleteFile($picturePath);
            $picturePath = uploadFile($request->file('picture'), 'uploads/profile-pictures');
        }
        // If no new file uploaded, keep the existing path

        if ($request->hasFile('passport_picture')) {
            if ($passportPicturePath) deleteFile($passportPicturePath);
            $passportPicturePath = uploadFile($request->file('passport_picture'), 'uploads/passport-pictures');
        }
        // If no new file uploaded, keep the existing path

        PersonalInfo::updateOrCreate(
            ['application_id' => $application->id],
            array_merge($validatedData, [
                'picture' => $picturePath,
                'passport_picture' => $passportPicturePath,
            ])
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 2])
            ->with('success', 'Personal information updated successfully!');
    }

    private function updateStep2(ApplicationForm $application, Request $request)
    {
        // Copy rules from your VisaTypeRequest
        $validatedData = $request->validate([
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
        ],
        [
            // Visa type
            'visa_type.required' => 'Please select the type of visa you are applying for.',
            'visa_type.in'       => 'Invalid visa type selected.',

            // Tourist type
            'tourist_type.in'    => 'Tourist type must be tourist, business, or work permit.',

            // Service type
            'service_type.required' => 'Please select a service type (individual or group).',
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
        ]);

        // Update visa type information - use validated data directly
        VisaType::updateOrCreate(
            ['application_id' => $application->id],
            $validatedData
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 3])
            ->with('success', 'Visa type information updated successfully!');
    }

    private function updateStep3(ApplicationForm $application, Request $request)
    {
        $rules = [
            'occupation' => 'required|in:Businessperson,Company employee,Entertainer,Industrial/agricultural worker,Student,Member of parliament,Government official,Teacher,Researcher,Medical professional,Engineer/Technician,Self-employed,Unemployed,Retired,Other',
            'work_exp_date_from' => 'nullable|date',
            'work_exp_date_to' => 'nullable|date|after_or_equal:work_exp_date_from',
            'employer_name' => 'nullable|string|max:255',
            'employer_address' => 'nullable|string|max:255',
            'employer_telephone' => 'nullable|string|max:50',
            'supervisor_name' => 'nullable|string|max:255',
            'supervisor_telephone' => 'nullable|string|max:50',
            'position_name' => 'nullable|string|max:255',
            'duty_name' => 'nullable|string|max:255',
        ];

        $messages = [
            'occupation.required' => 'Please select your current occupation.',
            'occupation.in' => 'Invalid occupation selected.',
            'work_exp_date_from.date' => 'The work experience "from" date must be a valid date.',
            'work_exp_date_to.date' => 'The work experience "to" date must be a valid date.',
            'work_exp_date_to.after_or_equal' => 'The "to" date cannot be earlier than the "from" date.',
            'employer_name.max' => 'Employer name may not be greater than 255 characters.',
            'employer_address.max' => 'Employer address may not be greater than 255 characters.',
            'employer_telephone.max' => 'Employer telephone may not exceed 50 characters.',
            'supervisor_name.max' => 'Supervisor name may not be greater than 255 characters.',
            'supervisor_telephone.max' => 'Supervisor telephone may not exceed 50 characters.',
            'position_name.max' => 'Position name may not be greater than 255 characters.',
            'duty_name.max' => 'Duty name may not be greater than 255 characters.',
        ];

        $validatedData = $request->validate($rules, $messages);

        WorkInfo::updateOrCreate(
            ['application_id' => $application->id],
            $validatedData
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 4])
            ->with('success', 'Work information updated successfully!');
    }

    private function updateStep4(ApplicationForm $application, Request $request)
    {
        $rules = [
            'institute_name' => 'required|string|max:255',
            'degree_name' => 'required|in:Technical secondary school/high school or equivalent,Junior college/undergraduate degree or equivalent,Masters degree or equivalent,Doctoral degree or above,Other',
            'major_degree' => 'nullable|string|max:255',
        ];

        $messages = [
            'institute_name.required' => 'Please enter the name of your institute.',
            'institute_name.string' => 'Institute name must be valid text.',
            'institute_name.max' => 'Institute name may not exceed 255 characters.',
            'degree_name.required' => 'Please select your highest diploma/degree.',
            'degree_name.in' => 'Invalid degree option selected.',
            'major_degree.string' => 'Major field must be valid text.',
            'major_degree.max' => 'Major field may not exceed 255 characters.',
        ];

        $validatedData = $request->validate($rules, $messages);

        EducationInfo::updateOrCreate(
            ['application_id' => $application->id],
            $validatedData
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 5])
            ->with('success', 'Education information updated successfully!');
    }

    private function updateStep5(ApplicationForm $application, Request $request)
    {
        $rules = [
            // 5.1 Current home address
            'current_home_address' => 'required|string|max:255',
            
            // 5.2 Phone Number
            'home_phone_number' => 'nullable|string|max:20',
            
            // 5.3 Mobile Phone Number
            'home_mobile_number' => 'required|string|max:20',
            
            // 5.4 Email
            'home_email' => 'nullable|email|max:255',
            
            // Father
            'father_family_name' => 'required|string|max:100',
            'father_givenname' => 'required|string|max:100',
            'father_nationality_id' => 'required|exists:countries,id',
            'father_dob' => 'required|date',
            'father_siberia_origin' => 'boolean',
            
            // Mother
            'mother_family_name' => 'required|string|max:100',
            'mother_givenname' => 'required|string|max:100',
            'mother_nationality_id' => 'required|exists:countries,id',
            'mother_dob' => 'required|date',
            'mother_siberia_origin' => 'boolean',
            
            // Children (optional)
            'children_family_name' => 'nullable|string|max:100',
            'children_givenname' => 'nullable|string|max:100',
            'children_nationality_id' => 'nullable|exists:countries,id',
            'children_dob' => 'nullable|date',
        ];

        $messages = [
            // Address & Contacts
            'current_home_address.required' => 'Please provide your current home address.',
            'home_mobile_number.required' => 'Mobile phone number is required.',
            'home_email.email' => 'Please enter a valid email address.',
            
            // Father
            'father_family_name.required' => 'Father\'s family name is required.',
            'father_givenname.required' => 'Father\'s given name is required.',
            'father_nationality_id.required' => 'Please select father\'s nationality.',
            'father_nationality_id.exists' => 'Invalid nationality selected for father.',
            'father_dob.required' => 'Please provide father\'s date of birth.',
            'father_dob.date' => 'Father\'s date of birth must be a valid date.',
            
            // Mother
            'mother_family_name.required' => 'Mother\'s family name is required.',
            'mother_givenname.required' => 'Mother\'s given name is required.',
            'mother_nationality_id.required' => 'Please select mother\'s nationality.',
            'mother_nationality_id.exists' => 'Invalid nationality selected for mother.',
            'mother_dob.required' => 'Please provide mother\'s date of birth.',
            'mother_dob.date' => 'Mother\'s date of birth must be a valid date.',
            
            // Children
            'children_nationality_id.exists' => 'Invalid nationality selected for child.',
            'children_dob.date' => 'Child\'s date of birth must be a valid date.',
        ];

        $validatedData = $request->validate($rules, $messages);

        FamilyInfo::updateOrCreate(
            ['application_id' => $application->id],
            $validatedData
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 6])
            ->with('success', 'Family information updated successfully!');
    }

    private function updateStep6(ApplicationForm $application, Request $request)
    {
        // Get the visa category from request
        $visaCategory = $request->input('visa_category');

        // Check if company approval letter already exists in database
        $hasExistingApprovalLetter = $application->travelInfo && $application->travelInfo->company_approval_letter;

        // Base rules
        $rules = [
            // 6.1 Visa Category
            'visa_category' => 'required|in:tourist,business,work',

            // 6.2 Inviting Person / Organization
            'inviting_name' => 'required|string|max:255',
            'inviting_relationship' => 'required|string|max:255',
            'inviting_phone_number' => 'required|string|max:20',
            'inviting_email' => 'nullable|email|max:255',
            'inviting_city' => 'required|string|max:100',
            'inviting_district' => 'nullable|string|max:100',
            'inviting_post_code' => 'nullable|string|max:20',

            // 6.3 Emergency Contact
            'emergency_contact_family_name' => 'required|string|max:100',
            'emergency_contact_givenname' => 'required|string|max:100',
            'emergency_contact_relationship' => 'required|string|max:100',
            'emergency_contact_phone_number' => 'required|string|max:20',
            'emergency_contact_email' => 'nullable|email|max:255',

            // 6.4 Who will pay
            'travel_payer' => 'required|in:self,other,organization',

            // 6.5 Same passport
            'same_passport' => 'boolean',
        ];

        // Conditional rules based on visa category
        if (in_array($visaCategory, ['tourist', 'business'])) {
            $rules['hotel_name'] = 'required|string|max:255';
            $rules['hotel_address'] = 'required|string|max:255';
            $rules['company_approval_letter'] = 'nullable';
        } elseif ($visaCategory === 'work') {
            // Make company_approval_letter nullable if it already exists
            $rules['company_approval_letter'] = $hasExistingApprovalLetter 
                ? 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048' 
                : 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $rules['hotel_name'] = 'nullable';
            $rules['hotel_address'] = 'nullable';
        } else {
            $rules['hotel_name'] = 'nullable|string|max:255';
            $rules['hotel_address'] = 'nullable|string|max:255';
            $rules['company_approval_letter'] = 'nullable';
        }

        $messages = [
            // Visa Category
            'visa_category.required' => 'Please select a visa category.',
            'visa_category.in' => 'Visa category must be either Tourist, Business, or Work.',

            // Hotel fields (conditional)
            'hotel_name.required' => 'Hotel name is required for tourist/business visa.',
            'hotel_address.required' => 'Hotel address is required for tourist/business visa.',

            // Company approval letter (conditional)
            'company_approval_letter.required' => 'Company approval letter is required for work visa.',
            'company_approval_letter.file' => 'Company approval letter must be a file.',
            'company_approval_letter.mimes' => 'Company approval letter must be a JPG, JPEG, PNG, or PDF file.',
            'company_approval_letter.max' => 'Company approval letter must not exceed 2MB.',

            // Inviting person
            'inviting_name.required' => 'Please provide the name of the inviting person/organization.',
            'inviting_relationship.required' => 'Please specify your relationship with the inviting person/organization.',
            'inviting_phone_number.required' => 'Inviting person\'s phone number is required.',
            'inviting_email.email' => 'Please enter a valid email for the inviting person.',
            'inviting_city.required' => 'Please enter the city of the inviting person/organization.',

            // Emergency contact
            'emergency_contact_family_name.required' => 'Emergency contact family name is required.',
            'emergency_contact_givenname.required' => 'Emergency contact given name is required.',
            'emergency_contact_relationship.required' => 'Emergency contact relationship is required.',
            'emergency_contact_phone_number.required' => 'Emergency contact phone number is required.',
            'emergency_contact_email.email' => 'Please enter a valid email for the emergency contact.',

            // Travel payer
            'travel_payer.required' => 'Please select who will pay for this travel.',
            'travel_payer.in' => 'Travel payer must be self, other, or organization.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // File handling for company approval letter
        $companyApprovalLetterPath = $application->travelInfo->company_approval_letter ?? null;

        if ($request->hasFile('company_approval_letter')) {
            if ($companyApprovalLetterPath) {
                deleteFile($companyApprovalLetterPath);
            }
            $companyApprovalLetterPath = uploadFile($request->file('company_approval_letter'), 'uploads/approval-letters');
        }
        // If no new file is uploaded, keep the existing path

        TravelInfo::updateOrCreate(
            ['application_id' => $application->id],
            array_merge($validatedData, [
                'company_approval_letter' => $companyApprovalLetterPath,
            ])
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 7])
            ->with('success', 'Travel information updated successfully!');
    }

    private function updateStep7(ApplicationForm $application, Request $request)
    {
        $rules = [
            'travel_siberia' => 'nullable|in:yes,no',
            'previous_siberia_visa' => 'nullable|in:yes,no',
            'other_country_visa' => 'nullable|in:yes,no',
            'visited_last_12_months' => 'nullable|in:yes,no',
        ];

        $messages = [
            'travel_siberia.in' => 'Answer must be Yes or No for "Have you ever been to Siberia?".',
            'previous_siberia_visa.in' => 'Answer must be Yes or No for "Have you ever gotten a Siberian visa?".',
            'other_country_visa.in' => 'Answer must be Yes or No for "Do you have any valid visa issued by other countries?".',
            'visited_last_12_months.in' => 'Answer must be Yes or No for "Have you visited any countries in the last 12 months?".',
        ];

        $validatedData = $request->validate($rules, $messages);

        PreviousTravelInfo::updateOrCreate(
            ['application_id' => $application->id],
            $validatedData
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 8])
            ->with('success', 'Previous travel information updated successfully!');
    }

    private function updateStep8(ApplicationForm $application, Request $request)
    {
        $rules = [
            'refused_visa' => 'nullable|in:yes,no',
            'visa_canceled' => 'nullable|in:yes,no',
            'illegal_entry' => 'nullable|in:yes,no',
            'criminal_record' => 'nullable|in:yes,no',
            'health_issue' => 'nullable|in:yes,no',
            'epidemic_visit' => 'nullable|in:yes,no',
            'special_skill' => 'nullable|in:yes,no',
            'military_service' => 'nullable|in:yes,no',
            'paramilitary' => 'nullable|in:yes,no',
            'organization_work' => 'nullable|in:yes,no',
            'other_declaration' => 'nullable|in:yes,no',
        ];

        $messages = [
            'refused_visa.in' => 'Please answer Yes or No for "Have you ever been refused a visa?".',
            'visa_canceled.in' => 'Please answer Yes or No for "Has your visa ever been canceled?".',
            'illegal_entry.in' => 'Please answer Yes or No for "Have you ever made an illegal entry or overstayed in a country?".',
            'criminal_record.in' => 'Please answer Yes or No for "Do you have any criminal record?".',
            'health_issue.in' => 'Please answer Yes or No for "Do you have any serious health issues?".',
            'epidemic_visit.in' => 'Please answer Yes or No for "Have you visited epidemic areas in the past?".',
            'special_skill.in' => 'Please answer Yes or No for "Do you possess any special skills?".',
            'military_service.in' => 'Please answer Yes or No for "Have you ever served in the military?".',
            'paramilitary.in' => 'Please answer Yes or No for "Have you ever been involved in any paramilitary activities?".',
            'organization_work.in' => 'Please answer Yes or No for "Have you worked with any organizations related to security or defense?".',
            'other_declaration.in' => 'Please answer Yes or No for "Do you have any other declaration to make?".',
        ];

        $validatedData = $request->validate($rules, $messages);

        OtherInfo::updateOrCreate(
            ['application_id' => $application->id],
            $validatedData
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 9])
            ->with('success', 'Other information updated successfully!');
    }

    private function updateStep9(ApplicationForm $application, Request $request)
    {
        $rules = [
            'declaration_type' => 'required|in:applicant,behalf',
            'agree' => 'accepted',
        ];

        $messages = [
            'declaration_type.required' => 'Please select who is filling in the form (Applicant or On behalf of Applicant).',
            'declaration_type.in' => 'Invalid declaration type selected.',
            'agree.accepted' => 'You must agree with the declaration before proceeding.',
        ];

        $validatedData = $request->validate($rules, $messages);

        Declaration::updateOrCreate(
            ['application_id' => $application->id],
            $validatedData
        );

        return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 10])
            ->with('success', 'Declaration updated successfully!');
    }

    private function updateStep10(ApplicationForm $application, Request $request)
{
    $fileRule = 'file|mimes:jpg,jpeg,png,pdf|max:2048'; // 2MB max

    // Check which files already exist in the database
    $existingMaterials = $application->materials;

    $rules = [
        // Other country visas (multi slot) - make required only if no existing files
        'other_country_visa1' => $existingMaterials && $existingMaterials->other_country_visa1 ? "nullable|$fileRule" : "required|$fileRule",
        'other_country_visa2' => "nullable|$fileRule",
        'other_country_visa3' => "nullable|$fileRule",
        'other_country_visa4' => "nullable|$fileRule",
        'other_country_visa5' => "nullable|$fileRule",
        'other_country_visa6' => "nullable|$fileRule",

        // Itinerary - make required only if no existing file
        'itinerary_siberia' => $existingMaterials && $existingMaterials->itinerary_siberia ? "nullable|$fileRule" : "required|$fileRule",

        // Hotel requirement - make required only if no existing file
        'hote_requirement' => $existingMaterials && $existingMaterials->hote_requirement ? "nullable|$fileRule" : "required|$fileRule",

        // Bank statements (multi slot) - make required only if no existing files
        'bank_statement1' => $existingMaterials && $existingMaterials->bank_statement1 ? "nullable|$fileRule" : "required|$fileRule",
        'bank_statement2' => "nullable|$fileRule",
        'bank_statement3' => "nullable|$fileRule",
        'bank_statement4' => "nullable|$fileRule",

        // Air ticket - make required only if no existing file
        'air_ticket' => $existingMaterials && $existingMaterials->air_ticket ? "nullable|$fileRule" : "required|$fileRule",

        // Invitation letter - make required only if no existing file
        'invitation_letter' => $existingMaterials && $existingMaterials->invitation_letter ? "nullable|$fileRule" : "required|$fileRule",
    ];

    $messages = [
        // Other country visas
        'other_country_visa1.required' => 'Please upload at least one valid visa from another country.',
        'other_country_visa1.mimes' => 'Visa file must be JPG, JPEG, PNG or PDF format.',
        'other_country_visa1.max' => 'Visa file size must not exceed 2MB.',

        // Itinerary
        'itinerary_siberia.required' => 'Please upload your itinerary in Siberia.',
        'itinerary_siberia.mimes' => 'Itinerary file must be JPG, JPEG, PNG or PDF format.',
        'itinerary_siberia.max' => 'Itinerary file size must not exceed 2MB.',

        // Hotel
        'hote_requirement.required' => 'Hotel reservation with complete payment is required.',
        'hote_requirement.mimes' => 'Hotel reservation must be JPG, JPEG, PNG or PDF.',
        'hote_requirement.max' => 'Hotel reservation file size must not exceed 2MB.',

        // Bank statements
        'bank_statement1.required' => 'At least one bank statement is required.',
        'bank_statement1.mimes' => 'Bank statement must be JPG, JPEG, PNG or PDF.',
        'bank_statement1.max' => 'Bank statement file must not exceed 2MB.',

        // Air ticket
        'air_ticket.required' => 'Round trip air ticket is required.',
        'air_ticket.mimes' => 'Air ticket must be JPG, JPEG, PNG or PDF.',
        'air_ticket.max' => 'Air ticket file must not exceed 2MB.',

        // Invitation letter
        'invitation_letter.required' => 'Invitation letter is required.',
        'invitation_letter.mimes' => 'Invitation letter must be JPG, JPEG, PNG or PDF.',
        'invitation_letter.max' => 'Invitation letter file must not exceed 2MB.',
    ];

    $validatedData = $request->validate($rules, $messages);

    // File handling for all uploaded files
    $filePaths = [];
    $fileFields = [
        'other_country_visa1', 'other_country_visa2', 'other_country_visa3', 'other_country_visa4', 'other_country_visa5', 'other_country_visa6',
        'itinerary_siberia', 'hote_requirement', 'bank_statement1', 'bank_statement2', 'bank_statement3', 'bank_statement4',
        'air_ticket', 'invitation_letter'
    ];

    foreach ($fileFields as $field) {
        $existingFilePath = $existingMaterials ? $existingMaterials->$field : null;
        
        if ($request->hasFile($field)) {
            if ($existingFilePath) {
                deleteFile($existingFilePath);
            }
            $filePaths[$field] = uploadFile($request->file($field), 'uploads/materials');
        } else {
            // Keep existing file path if no new file uploaded
            $filePaths[$field] = $existingFilePath;
        }
    }

    Material::updateOrCreate(
        ['application_id' => $application->id],
        $filePaths
    );

    return redirect()->route('admin.applications.edit', ['application' => $application->id, 'step' => 10])
        ->with('success', 'Upload materials updated successfully!');
}
}
