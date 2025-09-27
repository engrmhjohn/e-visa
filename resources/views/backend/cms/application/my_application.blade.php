@extends('backend.master')
@section('title', 'My Application List :: E-Visa')
@section('content')
<div class="page-inner mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Application List</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-black btn-sm mb-2" title="Go Back" onclick="history.back();">
                        <span class="btn-label">
                            <i class="fas fa-reply"></i>
                        </span>
                        Go Back
                    </button>
                    <a href="{{ route('apply.now') }}" class="btn btn-success btn-sm mb-2" title="Add New">
                        <span class="btn-label">
                            <i class="fas fa-plus"></i>
                        </span>
                        Add New Application
                    </a>
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Passport No</th>
                                        <th>Tracking No</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                            </thead>
                                <tbody>
                                    @foreach ($applications as $application)
                                    <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->personalInfo->passport_number ?? '—' }}</td>
                                    <td> {{ $application->tracking_number ?? '-'}}
                                    </td>
                                    <td>{{ $application->status ?? '—' }}</td>
                                    <td>{{ $application->created_at->format('d F Y') ?? '—' }}</td>
                                    <td>
                                        <div class="btn-list d-flex justify-content-center gap-1">
                                            <a href="{{ route('application.pdf.download', $application->id) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a class="btn btn-sm btn-warning" href="{{ route('application.submitted', ['application' => $application->id]) }}" title="View Application">
                                                <span class="btn-label">
                                                    <i class="far fa-eye"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="studentModalLabel">Student Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
        <p><strong>Date of Birth:</strong> <span id="modalDob"></span></p>
        <p><strong>Student ID:</strong> <span id="modalStuId"></span></p>
        <p><strong>Batch No:</strong> <span id="modalBatchNo"></span></p>
        <p><strong>Present Address:</strong> <span id="modalPresentAddress"></span></p>
        <p><strong>Permanent Address:</strong> <span id="modalPermanentAddress"></span></p>
        <p><strong>Father's Name:</strong> <span id="modalFathersName"></span></p>
        <p><strong>Mother's Name:</strong> <span id="modalMothersName"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false,
        timerProgressBar: true,
    });
</script>
@endif
<script>
var studentModal = document.getElementById('studentModal')
studentModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget
  var dob = button.getAttribute('data-dob') // e.g., "2025-09-05"

  // Convert to Date object
  var dateObj = new Date(dob)

  // Array of month names
  var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"]

  // Format as "Sept 5, 2025"
  var formattedDate = months[dateObj.getMonth()] + " " + dateObj.getDate() + ", " + dateObj.getFullYear()

  document.getElementById('modalDob').textContent = formattedDate

  // Other fields
  document.getElementById('modalEmail').textContent = button.getAttribute('data-email')
  document.getElementById('modalStuId').textContent = button.getAttribute('data-stu_id')
  document.getElementById('modalBatchNo').textContent = button.getAttribute('data-batch_no')
  document.getElementById('modalPresentAddress').textContent = button.getAttribute('data-present_address')
  document.getElementById('modalPermanentAddress').textContent = button.getAttribute('data-permanent_address')
  document.getElementById('modalFathersName').textContent = button.getAttribute('data-fathers_name')
  document.getElementById('modalMothersName').textContent = button.getAttribute('data-mothers_name')
})
</script>
@endsection
