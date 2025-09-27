<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

require_once app_path('Helper/image.php');

class FrontviewController extends Controller
{
    public function index()
    {
        return view('frontend.home.index');
    }

    public function studentStore(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'picture' => 'required|image|mimes:jpg,jpeg,png|max:1024',
        'name' => 'required|string|max:255',
        'institute_id' => 'required|exists:institutes,id',
        'email' => 'nullable|email|max:255',
        'phone' => 'required|string|max:20',
        'dob' => 'required|date',
        'stu_id' => 'nullable|string|max:50',
        'batch_no' => 'required|string|max:50',
        'blood_group' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-,Unknown',
        'present_address' => 'nullable|string',
        'permanent_address' => 'nullable|string',
        'fathers_name' => 'required|string|max:255',
        'mothers_name' => 'required|string|max:255',
        'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
    ], [
        'picture.required' => 'A formal picture is required.',
        'picture.image' => 'The picture must be a valid image.',
        'picture.mimes' => 'The picture must be a JPG or PNG file.',
        'picture.max' => 'The picture size must not exceed 1MB.',

        'name.required' => 'Please enter the student’s full name.',
        'name.max' => 'Student name cannot exceed 255 characters.',

        'institute_id.required' => 'Please select an institute.',
        'institute_id.exists' => 'The selected institute is invalid.',

        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Email cannot exceed 255 characters.',

        'phone.required' => 'Phone number is required.',
        'phone.max' => 'Phone number is too long.',

        'dob.required' => 'Date of birth is required.',
        'dob.date' => 'Please enter a valid date for date of birth.',

        'batch_no.required' => 'Batch number is required.',
        'batch_no.max' => 'Batch number cannot exceed 50 characters.',

        'blood_group.required' => 'Please select your blood group.',
        'blood_group.in' => 'The selected blood group is invalid.',

        'fathers_name.required' => 'Father’s name is required.',
        'mothers_name.required' => 'Mother’s name is required.',

        'document.mimes' => 'Document must be a PDF, DOC, JPG, or PNG file.',
        'document.max' => 'Document size must not exceed 5MB.',
    ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $picturePath = null;
        $documentPath = null;

        if ($request->hasFile('picture')) {
            $picturePath = image_upload($request->picture);
        }
        if ($request->hasFile('document')) {
            $documentPath = document_upload($request->document);
        }
        $student = Student::create([
            'picture' => $picturePath,
            'name' => $request->name,
            'institute_id' => $request->institute_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'stu_id' => $request->stu_id,
            'batch_no' => $request->batch_no,
            'blood_group' => $request->blood_group,
            'present_address' => $request->present_address,
            'permanent_address' => $request->permanent_address,
            'fathers_name' => $request->fathers_name,
            'mothers_name' => $request->mothers_name,
            'document' => $documentPath,
        ]);

        return redirect()->back()->with('success', 'Student information submitted successfully.');
    }
}
