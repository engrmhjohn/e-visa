@extends('backend.master')
@section('content')
<div class="container">
    <div class="page-inner">
        @if(Auth::user()->role == 0)
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <a href="">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Submitted Visa</p>
                                        <h4 class="card-title">{{ $my_total_success_application_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Approved Visa</p>
                                        <h4 class="card-title">{{ $my_total_approved_application_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-warning bubble-shadow-small">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Under Review Visa</p>
                                        <h4 class="card-title">{{ $my_total_under_review_application_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-danger bubble-shadow-small">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Rejected Visa</p>
                                        <h4 class="card-title">{{ $my_total_rejected_application_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">My Latest Visa List</h4>
                    </div>
                    <div class="card-body">
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
                                    @foreach ($recent_my_application as $application)
                                    <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->personalInfo->passport_number ?? '—' }}</td>
                                    <td> {{ $application->tracking_number ?? '-'}}</td>
                                    <td>{{ $application->status ?? '—' }}</td>
                                    <td>{{ optional($application->created_at)->format('d F Y') ?? '—' }}</td>
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
        @endif
        @if(Auth::user()->role == 2)
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <a href="">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">All Submitted Visa</p>
                                        <h4 class="card-title">{{ $total_success_application_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">All Approved Visa</p>
                                        <h4 class="card-title">{{ $total_approved_application_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-warning bubble-shadow-small">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">All Under Review Visa</p>
                                        <h4 class="card-title">{{ $total_under_review_application_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-danger bubble-shadow-small">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">All Rejected Visa</p>
                                        <h4 class="card-title">{{ $total_rejected_application_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Latest Visa List</h4>
                    </div>
                    <div class="card-body">
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
                                    @foreach ($recent_application as $application)

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->personalInfo->passport_number ?? '—' }}</td>
                                    <td> {{ $application->tracking_number ?? '-'}}
                                    </td>
                                    <td>{{ $application->status ?? '—' }}</td>
                                    <td>{{ optional($application->created_at)->format('d F Y') ?? '—' }}</td>
                                    <td>
                                        <div class="btn-list d-flex justify-content-center gap-1">
                                            <a href="{{ route('application.edit.status', $application->id) }}" class="btn btn-sm btn-primary" title="Edit Status">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a href="{{ route('application.pdf.download', $application->id) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a class="btn btn-sm btn-warning" href="{{ route('application.submitted', ['application' => $application->id]) }}" title="View Application">
                                                <span class="btn-label">
                                                    <i class="far fa-eye"></i>
                                                </span>
                                            </a>
                                            <a class="btn btn-sm btn-secondary" href="{{ route('admin.applications.edit', $application->id) }}" title="Edit Application">
                                                <span class="btn-label">
                                                    <i class="far fa-edit"></i>
                                                </span>
                                            </a>
                                            <form action="{{ route('application.delete', ['id' => $application->id]) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm delete_unique" type="submit" title="Delete Application">
                                                    <span class="btn-label">
                                                        <i class="far fa-trash-alt"></i>
                                                    </span>
                                                </button>
                                            </form>
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
        @endif
    </div>
</div>
@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 2000, // 2 sec auto close
                showConfirmButton: false
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                timer: 2000, // 2 sec auto close
                showConfirmButton: false
            });
        });
    </script>
@endif
@endsection
