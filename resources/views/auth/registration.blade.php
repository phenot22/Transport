@extends('adminlte::page')
@section('content')
<div class="card p-3 shadow-sm" style="max-width: 800px; margin: auto; margin-top: 50px;"> 
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif
    <form method="post" action="{{ route('registration.post') }}" class="needs-validation" novalidate>
        @csrf
        <h3 class="text-center mb-3">Add Company</h3>
        <h5 class="mt-3">Company Details</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="compname" class="small">Company Name</label>
                <input type="text" name="compname" class="form-control form-control-sm" placeholder="Enter company name" required />
                @error('compname') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="small">Company Email</label>
                <input type="email" name="email" class="form-control form-control-sm" placeholder="Enter company email" required />
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <label for="phone" class="small">Company Phone</label>
                <input type="tel" name="company_phone" class="form-control form-control-sm" placeholder="Enter phone number" pattern="[0-9]{10,15}" required />
                @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="address" class="small">Company Address</label>
                <textarea name="company_address" class="form-control form-control-sm" placeholder="Enter address" required></textarea>
                @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <hr>

        <h5 class="mt-3">Owner Details</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="owner_name" class="small">Owner Name</label>
                <input type="text" name="owner_name" class="form-control form-control-sm" placeholder="Enter owner's full name" required />
                @error('owner_name') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="owner_email" class="small">Owner Email</label>
                <input type="email" name="owner_email" class="form-control form-control-sm" placeholder="Enter owner's email" required />
                @error('owner_email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <label for="owner_phone" class="small">Owner Phone</label>
                <input type="tel" name="owner_phone" class="form-control form-control-sm" placeholder="Enter phone number" pattern="[0-9]{10,15}" required />
                @error('owner_phone') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <hr>

        <h5 class="mt-3">Account Details</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="password" class="small">Password</label>
                <input type="password" name="password" class="form-control form-control-sm" placeholder="Enter password" minlength="6" required />
                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="small">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm password" minlength="6" required />
                @error('password_confirmation') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <input type="hidden" name="usertype" value="user">

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            <a href="{{ route('company') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </form>
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
@endsection
