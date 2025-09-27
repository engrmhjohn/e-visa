@extends('backend.master')
@section('title')
Admin :: User Management
@endsection
@section('content')
<div class="page-inner mt-5 pt-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center">
                    <div class="profile-picture">
                        <div class="avatar avatar-xl">
                            @if($user->profile_photo_path)
                            <img src="{{ asset($user->profile_photo_path) }}" alt="Avatar" class="avatar-img rounded-circle">
                            @else
                            <img src="{{ asset('backendAssets') }}/img/avatar.png" alt="Avatar" class="avatar-img rounded-circle">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name"> <strong>Name:</strong> {{ $user->name }}</div>
                        <div class="job"> <strong>Phone:</strong> {{ $user->phone }}</div>
                        <div class="desc"> <strong>Email:</strong> {{ $user->email }}</div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <strong>User Role:</strong>
                            @if (Auth::user()->role == '2')
                            <span>Admin</span>
                            @else
                            <span>User</span>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <strong>Joined: {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <form action="{{ route('admin.update_user_photo_by_admin') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="card">
                    <div class="card-body">
                        <input type="file" name="profile_photo_path" id="profile_photo_path" class="dropify" />
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-black btn-sm" title="Update">
                                    Update Profile Image
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <form action="{{ route('admin.update_user_password_by_admin') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Change Password</h3>
                    </div>
                    <div class="card-body">
                        <label for="exampleInputnddame">New Password</label>
                        <input type="text" class="form-control" name="password" id="exampleInputnddame">
                        <label for="exampleInsasputname">Confirm New Password</label>
                        <input type="text" class="form-control" name="password_confirmation" id="exampleInsasputname">
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-black btn-sm" title="Update">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <form action="{{ route('admin.update_user_name_by_admin') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Change Name</h3>
                    </div>
                    <div class="card-body">
                        <label for="name" class="col-md-4 col-form-label fw-bold">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $user->name }}">
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-black btn-sm" title="Update">
                                    Update Name
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <form action="{{ route('admin.update_user_email_by_admin') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Change Email</h3>
                    </div>
                    <div class="card-body">
                        <label for="name" class="col-md-4 col-form-label fw-bold">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Name" value="{{ $user->email }}">
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-black btn-sm" title="Update">
                                    Update Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <form action="{{ route('admin.update_user_phone_by_admin') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Change Phone</h3>
                    </div>
                    <div class="card-body">
                        <label for="phone" class="col-md-4 col-form-label fw-bold">Phone</label>
                        <input type="phone" class="form-control" name="phone" placeholder="Phone" value="{{ $user->phone }}">
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-black btn-sm" title="Update">
                                    Update Phone
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <form action="{{ route('admin.delete_admin', $user->id) }}" method="post">
                <button class="btn btn-danger delete_unique" type="submit"> <span class="fe fe-trash-2"> </span> Delete This Account?</button>
                @csrf
                @method('delete')
            </form>
        </div>
    </div>
</div>
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success'
        , title: 'Success!'
        , text: '{{ session('
        success ') }}'
        , timer: 2000
        , showConfirmButton: false
        , timerProgressBar: true
    , });

</script>
@endif
@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error'
        , title: 'Error Found!'
        , html: `{!! implode('<br>', $errors->all()) !!}`
    , });

</script>
@endif
@endsection
