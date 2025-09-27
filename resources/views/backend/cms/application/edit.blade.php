@extends('backend.master')
@section('title', 'Visa Application List :: E-Visa')
@section('content')
<div class="page-inner mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Edit Application Status
                    </h4>
                </div>

                <div class="card-body">
                    <button class="btn btn-black btn-sm mb-2" title="Go Back" onclick="history.back();">
                        <span class="btn-label">
                            <i class="fas fa-reply"></i>
                        </span>
                        Go Back
                    </button>
                    <div class="row mb-4 d-flex justify-content-center">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Tracking Number:</th>
                                    <td>{{ $application->tracking_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Applicant Name:</th>
                                    <td>
                                        {{ $application->personalInfo->given_names ?? 'N/A' }}
                                        {{ $application->personalInfo->family_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Passport Number:</th>
                                    <td>{{ $application->personalInfo->passport_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Current Status:</th>
                                    <td>
                                        {{ ucfirst($application->status) }}
                                    </td>
                                </tr>
                                 <tr>
                                    <th>Reason of Status:</th>
                                    <td>{{ $application->admin_notes ?? 'N/A'}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                    <!-- Status Update Form -->
                    <form action="{{ route('application.update.status', $application->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="status" class="form-label"><strong>Update Status</strong></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select New Status</option>
                                        <option value="submitted" {{ old('status', $application->status) == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                        <option value="under_review" {{ old('status', $application->status) == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                        <option value="approved" {{ old('status', $application->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status', $application->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label"><strong>Admin Notes</strong></label>
                            <textarea class="form-control @error('admin_notes') is-invalid @enderror" id="admin_notes" name="admin_notes" rows="4" placeholder="Add notes about this status change...">{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                Update Status
                            </button>
                        </div>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
