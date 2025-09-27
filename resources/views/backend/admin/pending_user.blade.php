@extends('backend.master')
@section('title')
Admin :: User Management
@endsection
@section('content')
<div class="page-inner mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin Manage</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-black btn-sm mb-2" title="Go Back" onclick="history.back();">
                        <span class="btn-label">
                            <i class="fas fa-reply"></i>
                        </span>
                        Go Back
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-success btn-sm mb-2" title="Dashboard">
                        <span class="btn-label">
                            <i class="fas fa-undo"></i>
                        </span>
                        Go Dashboard
                    </a>
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pending_user as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                             <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role == 2)
                                        <div class="mt-sm-1 d-block">
                                            <span class="badge badge-primary">Admin</span>
                                        </div>
                                        @else
                                        <div class="mt-sm-1 d-block">
                                            <span class="badge badge-warning">User</span>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-list d-flex justify-content-center gap-1">
                                            @if ($user->role == 0)
                                            <a class="btn btn-sm btn-danger" href="{{ route('admin.role', ['id' => $user->id, 'newRole' => 2]) }}" title="Make Admin">
                                                <span class="btn-label">
                                                    <i class="fas fa-user-shield"></i>
                                                </span> 
                                                Admin
                                            </a>
                                            @else($user->role == 2)
                                            <a class="btn btn-black btn-sm" href="{{ route('admin.role', ['id' => $user->id, 'newRole' => 0]) }}" title="Remove Admin">
                                                <span class="btn-label">
                                                    <i class="fas fa-user-times"></i>
                                                </span>
                                                Admin
                                            </a>
                                            @endif
                                            <a class="btn btn-sm btn-secondary" href="{{ route('admin.edit_admin', $user->id) }}" title="Edit Admin">
                                                <span class="btn-label">
                                                    <i class="fas fa-user-edit"></i>
                                                </span> 
                                                User
                                            </a>
                                            <form action="{{ route('admin.delete_admin', ['id' => $user->id]) }}" method="post">
                                                <button class="btn btn-danger btn-sm delete_unique" type="submit" title="Delete User"> 
                                                    <span class="btn-label">
                                                        <i class="fas fa-user-minus"></i>
                                                    </span> 
                                                    User
                                                </button>
                                                @csrf
                                                @method('delete')
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
@endsection