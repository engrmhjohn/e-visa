@extends('backend.master')
@section('title', 'Visa Application List :: E-Visa')
@section('content')
<div class="page-inner mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Visa Application List</h4>
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
                                    <td>
                                        {{ $application->tracking_number }}
                                    </td>
                                    <td>{{ $application->status ?? '—' }}</td>
                                    <td>{{ $application->created_at->format('d F Y') ?? '—' }}</td>
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
                                            <a class="btn btn-sm btn-secondary" href="#" title="Edit Application">
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
