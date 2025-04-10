@extends('layouts.app')

@section('content')
@include('includes.flash')
<div class="container mt-5">
    <h2 class="mb-4">👤 Update Profile</h2>

    {{-- Update Profile Info --}}
    <div class="card mb-4">
        <div class="card-header">Update Name & Email</div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.updateUserProfile') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>

    {{-- Update Password --}}
    <div class="card mb-4">
        <div class="card-header">Change Password</div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-warning">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
