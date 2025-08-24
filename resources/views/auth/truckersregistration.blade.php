@extends('adminlte::page')

@section('content')
<div class="card shadow-sm mx-auto mt-5" style="max-width: 800px;">
    <div class="card-body">
        @if (Session::has('success'))
            <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
        @endif
        <form method="POST" action="{{ route('truckerregistration.post') }}" class="needs-validation" novalidate>
            @csrf
            <h3 class="text-center mb-3">Add Trucker</h3>
            <hr>
            <h5 class="mt-3">Owner Details</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="trucker_name" class="small">Full Name</label>
                    <input type="text" id="trucker_name" name="trucker_name" class="form-control form-control-sm" placeholder="Enter full name" required>
                    @error('trucker_name')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gender" class="small">Gender</label>
                    <select id="gender" name="gender" class="form-control form-control-sm" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    @error('gender')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="dob" class="small">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="form-control form-control-sm" required>
                    @error('dob')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="trucker_address" class="small">Address</label>
                    <input type="text" id="trucker_address" name="trucker_address" class="form-control form-control-sm" placeholder="Enter address" required>
                    @error('trucker_address')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="small">Email</label>
                    <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="Enter email" required>
                    @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="trucker_phone" class="small">Contact No.</label>
                    <input type="tel" id="trucker_phone" name="trucker_phone" class="form-control form-control-sm" placeholder="Enter phone number" pattern="[0-9]{10,15}" required>
                    @error('trucker_phone')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
            </div>
            <hr>
            <h5 class="mt-3">Account Details</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="small">Password</label>
                    <input type="password" id="password" name="password" class="form-control form-control-sm" placeholder="Enter password" minlength="6" required>
                    @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="small">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm password" minlength="6" required>
                    @error('password_confirmation')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
            </div>
            <input type="hidden" name="usertype" value="trucker"> 
            <input type="hidden" name="compname" value="{{ session('company.compname', 'default_value') }}">
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-custom-primary btn-sm custom-btn">Submit</button>
                <a href="{{ route('company.index') }}" class="btn btn-custom-secondary btn-sm custom-btn">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        var password = document.querySelector('input[name="password"]');
        var confirmPassword = document.querySelector('input[name="password_confirmation"]');
        if (password.value !== confirmPassword.value) {
            event.preventDefault();
            alert('Passwords do not match!');
        }
    });
</script>

@push('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .btn-custom-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border: none;
        border-radius: 4px;
        color: #fff;
        padding: 0.5rem 1rem;
        transition: background 0.3s ease;
    }
    .btn-custom-primary:hover {
        background: linear-gradient(45deg, #0056b3, #003f7f);
        color: #fff;
    }
    .btn-custom-secondary {
        background: linear-gradient(45deg, #6c757d, #5a6268);
        border: none;
        border-radius: 4px;
        color: #fff;
        padding: 0.5rem 1rem;
        transition: background 0.3s ease;
    }
    .btn-custom-secondary:hover {
        background: linear-gradient(45deg, #5a6268, #494f54);
        color: #fff;
    }
    .btn-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 1.5rem;
    }
    .custom-btn {
        width: 120px;
    }
</style>
@endpush
@endsection
