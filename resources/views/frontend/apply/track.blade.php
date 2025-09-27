@extends('frontend.master')
@section('title', 'Track Application | E-Visa')
@section('content')
<div class="container">
    <!-- Contact Section -->
    <section id="contact" class="contact light-background passport-verify-section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="fw-bold text-center"><i class="fas fa-search me-2"></i>Track Your Application</h3>
                        <form id="trackingForm">
                            @csrf

                            <!-- Tracking Number Search -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">Search by Tracking Number</h5>
                                <div class="form-group">
                                    <label for="tracking_number" class="form-label">Tracking Number</label>
                                    <input type="text" class="form-control" id="tracking_number" name="tracking_number" placeholder="e.g., John-2124578852123252">
                                </div>
                            </div>

                            <!-- OR Separator -->
                            <div class="text-center my-4">
                                <span class="bg-light px-3 py-1 rounded">OR</span>
                            </div>

                            <!-- Passport & DOB Search -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">Search by Passport & Date of Birth</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="passport_number" class="form-label">Passport Number</label>
                                            <input type="text" class="form-control" id="passport_number" name="passport_number" placeholder="Enter passport number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dob" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control flat_date" id="dob" name="dob">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Button -->
                            <div class="text-center">
                                <button type="button" id="searchBtn" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Track Application
                                </button>
                            </div>
                        </form>
                        <!-- Loader -->
                        <div id="loader" class="text-center d-none my-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Searching for your application...</p>
                        </div>
                        <!-- Results Table -->
                        <div class="result-table d-none mt-4">
                            <h5 class="border-bottom pb-2">Application Details</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th width="30%">Tracking Number</th>
                                            <td id="tdTrackingNumber">—</td>
                                        </tr>
                                        <tr>
                                            <th>Applicant Name</th>
                                            <td id="tdApplicantName">—</td>
                                        </tr>
                                        <tr>
                                            <th>Passport Number</th>
                                            <td id="tdPassportNumber">—</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td id="tdDob">—</td>
                                        </tr>
                                        <tr>
                                            <th>Application Status</th>
                                            <td><span id="tdStatus" class="badge">—</span></td>
                                        </tr>
                                        <tr>
                                            <th>Notes</th>
                                            <td id="notes">—</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Contact Section -->
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function searchApplication() {
        let trackingNumber = $('#tracking_number').val().trim();
        let passportNumber = $('#passport_number').val().trim();
        let dob = $('#dob').val().trim();

        // Validate input
        if (!trackingNumber && (!passportNumber || !dob)) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please provide either Tracking Number OR both Passport Number and Date of Birth.'
            });
            $('.result-table').addClass('d-none');
            return;
        }

        // Show loader
        $('#loader').removeClass('d-none');
        $('.result-table').addClass('d-none');

        $.ajax({
            url: '{{ route("search.application") }}',
            type: 'POST',
            data: {
                tracking_number: trackingNumber,
                passport_number: passportNumber,
                dob: dob,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Hide loader
                $('#loader').addClass('d-none');

                if (response.success) {
                    $('.result-table').removeClass('d-none');
                    
                    // Populate table with data
                    $('#tdTrackingNumber').text(response.data.tracking_number || '—');
                    $('#tdApplicantName').text(response.data.applicant_name || '—');
                    $('#tdPassportNumber').text(response.data.passport_number || '—');
                    $('#notes').text(response.data.admin_notes || '—');
                    $('#tdDob').text(response.data.dob ? new Date(response.data.dob).toLocaleDateString('en-US', {
                                year: 'numeric', month: 'short', day: 'numeric'
                            }) : '—');

                    // Handle status with appropriate badge color
                    let status = response.data.status || 'draft';
                    let statusClass = '';
                    let statusText = status.charAt(0).toUpperCase() + status.slice(1);

                    switch(status) {
                        case 'submitted':
                            statusClass = 'bg-success';
                            $('#submittedRow').removeClass('d-none');
                            $('#tdSubmittedDate').text(response.data.submitted_at ? new Date(response.data.submitted_at).toLocaleDateString('en-US', {
                                year: 'numeric', month: 'short', day: 'numeric'
                            }) : '—');
                            break;
                        case 'approved':
                            statusClass = 'bg-success';
                            break;
                        case 'rejected':
                            statusClass = 'bg-danger';
                            break;
                        case 'draft':
                            statusClass = 'bg-warning text-dark';
                            statusText = 'In Progress (Draft)';
                            $('#submittedRow').addClass('d-none');
                            break;
                        default:
                            statusClass = 'bg-secondary';
                    }

                    $('#tdStatus').removeClass().addClass('badge ' + statusClass).text(statusText);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Application Not Found',
                        text: response.message
                    });
                    $('.result-table').addClass('d-none');
                }
            },
            error: function(xhr) {
                $('#loader').addClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while searching. Please try again.'
                });
                console.error('Search error:', xhr.responseText);
            }
        });
    }

    // Search button click event
    $('#searchBtn').on('click', function(e) {
        e.preventDefault();
        searchApplication();
    });

    // Enter key support
    $('#tracking_number, #passport_number, #dob').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            searchApplication();
        }
    });

    // Clear other field when one is being used
    $('#tracking_number').on('input', function() {
        if ($(this).val().trim()) {
            $('#passport_number, #dob').val('');
        }
    });

    $('#passport_number, #dob').on('input', function() {
        if ($('#passport_number').val().trim() || $('#dob').val().trim()) {
            $('#tracking_number').val('');
        }
    });
});
</script>
@endpush
