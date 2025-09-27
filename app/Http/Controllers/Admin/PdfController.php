<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use PDF; 

class PdfController extends Controller
{
        public function generateApplicationPdf($applicationId)
    {
        // Get the application with all relationships
        $application = ApplicationForm::with([
            'personalInfo', 'visaType', 'workInfo', 'familyInfo', 
            'educationInfo', 'travelInfo', 'previousTravelInfo', 
            'otherInfo', 'declaration', 'materials'
        ])->findOrFail($applicationId);

        // Verify ownership
        if (auth()->check() && auth()->id() !== $application->user_id) {
            abort(403);
        }

        // Data to pass to the view
        $data = [
            'application' => $application,
            'title' => 'Visa Application - ' . $application->id,
            'date' => now()->format('F j, Y'),
        ];

        // Generate PDF
        $pdf = PDF::loadView('pdf.application', $data);

        // Return PDF for download
        return $pdf->download($application->tracking_number . '.pdf');
    }

    public function viewApplicationPdf($applicationId)
    {
        // Get the application with all relationships
        $application = ApplicationForm::with([
            'personalInfo', 'visaType', 'workInfo', 'familyInfo', 
            'educationInfo', 'travelInfo', 'previousTravelInfo', 
            'otherInfo', 'declaration', 'materials'
        ])->findOrFail($applicationId);

        // Verify ownership
        if (auth()->check() && auth()->id() !== $application->user_id) {
            abort(403);
        }

        $data = [
            'application' => $application,
            'title' => 'Visa Application - ' . $application->id,
            'date' => now()->format('F j, Y'),
        ];

        $pdf = PDF::loadView('pdf.application', $data);
        
        // View PDF in browser
        return $pdf->stream('visa-application-' . $application->id . '.pdf');
    }
}
