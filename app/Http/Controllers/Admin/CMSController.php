<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Student;
use App\Models\Institute;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

require_once app_path('Helper/image.php');
require_once app_path('Helpers/FileUploadHelper.php');

class CMSController extends Controller
{
    public function dashboard()
    {
        $auth_user_id = Auth::id();
        // Total Application based on logged in user
        $my_total_success_application_count = ApplicationForm::where('user_id', $auth_user_id)->where('status', 'submitted')->count();
        $my_total_under_review_application_count = ApplicationForm::where('user_id', $auth_user_id)->where('status', 'under_review')->count();
        $my_total_approved_application_count = ApplicationForm::where('user_id', $auth_user_id)->where('status', 'approved')->count();
        $my_total_rejected_application_count = ApplicationForm::where('user_id', $auth_user_id)->where('status', 'rejected')->count();
        $recent_my_application = ApplicationForm::where('user_id', $auth_user_id)->where('status', '<>', 'draft')->orderBy('id', 'desc')->take(2)->get();

        $total_success_application_count = ApplicationForm::where('status', 'submitted')->count();
        $total_under_review_application_count = ApplicationForm::where('status', 'under_review')->count();
        $total_approved_application_count = ApplicationForm::where('status', 'approved')->count();
        $total_rejected_application_count = ApplicationForm::where('status', 'rejected')->count();
        $recent_application = ApplicationForm::where('status', '<>', 'draft')->orderBy('id', 'desc')->take(5)->get();

        // Total super admin
        $total_super_admin_count = User::where('role', '2')->count();

        // Not admin
        $total_not_admin_count = User::where('role', '0')->count();

        return view('backend.home.index', [
            'total_super_admin_count' => $total_super_admin_count,
            'total_not_admin_count' => $total_not_admin_count,
            'my_total_success_application_count' => $my_total_success_application_count,
            'my_total_approved_application_count' => $my_total_approved_application_count,
            'my_total_under_review_application_count' => $my_total_under_review_application_count,
            'my_total_rejected_application_count' => $my_total_rejected_application_count,
            'recent_my_application' => $recent_my_application,
            'total_success_application_count' => $total_success_application_count,
            'total_approved_application_count' => $total_approved_application_count,
            'total_under_review_application_count' => $total_under_review_application_count,
            'total_rejected_application_count' => $total_rejected_application_count,
            'recent_application' => $recent_application,
        ]);
    }


    public function manageMyApplication()
    {
        $auth_user_id = Auth::id();

            return view('backend.cms.application.my_application', [
            'applications' => ApplicationForm::with(['personalInfo'])
                ->where('user_id', $auth_user_id)
                ->where('status', '<>', 'draft')
                ->orderBy('id', 'desc')
                ->get()
        ]);
    }

    public function manageVisaApplication()
    {
        // Eager load personalInfo to avoid N+1 queries when accessing passport_number
        $applications = ApplicationForm::with('personalInfo') 
            ->where('status', '<>', 'draft')
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.cms.application.index', compact('applications'));
    }

    // app/Http/Controllers/CMSController.php
    public function editStatus($id)
    {
        try {
            $application = ApplicationForm::with(['personalInfo'])->findOrFail($id);
            
            return view('backend.cms.application.edit', compact('application'));
            
        } catch (\Exception $e) {
            return redirect()->route('manage_visa_application')
                ->with('error', 'Application not found: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:submitted,under_review,approved,rejected',
                'admin_notes' => 'nullable|string|max:1000'
            ]);

            $application = ApplicationForm::findOrFail($id);
            
        // Update status
        $application->status = $request->status;

        // Only keep the new note (overwrite old one)
        $application->admin_notes = $request->admin_notes;

            $application->save();

            return redirect()->route('manage_visa_application')
                ->with('success', 'Application status updated successfully!');

        } catch (\Exception $e) {
            return redirect()->route('manage_visa_application')
                ->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }

    public function deleteApplication($id)
{
    $application = ApplicationForm::with(['personalInfo', 'travelInfo', 'materials'])->findOrFail($id);

    // Delete Personal Info files
    if ($application->personalInfo) {
        deleteFile($application->personalInfo->picture);
        deleteFile($application->personalInfo->passport_picture);
        
        // Delete personal info record
        $application->personalInfo->delete();
    }

    // Delete Travel Info files
    if ($application->travelInfo && $application->travelInfo->company_approval_letter) {
        deleteFile($application->travelInfo->company_approval_letter);
        
        // Delete travel info record
        $application->travelInfo->delete();
    }

    // Delete Materials files
    if ($application->materials) {
        // Array of all file fields in materials table
        $materialFiles = [
            'other_country_visa1',
            'other_country_visa2', 
            'other_country_visa3',
            'other_country_visa4',
            'other_country_visa5',
            'other_country_visa6',
            'itinerary_china', // Fixed typo: was itinerary_siberia
            'hote_requirement',
            'bank_statement1',
            'bank_statement2',
            'bank_statement3',
            'bank_statement4',
            'air_ticket',
            'invitation_letter',
        ];

        // Delete each file
        foreach ($materialFiles as $field) {
            if (!empty($application->materials->$field)) {
                deleteFile($application->materials->$field);
            }
        }
        
        // Delete materials record
        $application->materials->delete();
    }

    // Delete other related records (add more as needed)
    if ($application->visaType) {
        $application->visaType->delete();
    }
    if ($application->workInfo) {
        $application->workInfo->delete();
    }
    if ($application->educationInfo) {
        $application->educationInfo->delete();
    }
    if ($application->familyInfo) {
        $application->familyInfo->delete();
    }
    if ($application->previousTravelInfo) {
        $application->previousTravelInfo->delete();
    }
    if ($application->otherInfo) {
        $application->otherInfo->delete();
    }
    if ($application->declaration) {
        $application->declaration->delete();
    }

    // Finally delete the main application record
    $application->delete();

    return redirect()->back()->with('success', 'Application and all related files deleted successfully!');
}

}
