@extends('adminlte::page')
@section('content')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

<div class="card">
    <img src="{{ asset('images/logo.png') }}" alt="System Logo" class="logo">

    @if (Session::has('success'))
        <div class="alert alert-success" id="alertMessage">{{ Session::get('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" id="errorAlert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="post" action="{{ route('companylogin.post') }}">
        @csrf
        <h1>Company Login</h1>

        <div class="input-group">
            <label for="email">Email</label>
            <div>
        <input type="text" id="email" name="email" class="form-control" placeholder="Enter your Email" 
       oninput="this.value = this.value.trimStart().replace(/\s+$/, '')">                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <div style="position: relative;">
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your Password">
                <span id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                    👁️
                </span>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>

        <input type="submit" class="btn" value="Login" name="submit" />
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <p><strong>Login As:</strong></p>
        <p>
            <a href="{{ route('adminlogin') }}">Admin Login</a> |
            <a href="{{ route('companylogin') }}">Company Login</a> |
            <a href="{{ route('truckerslogin') }}">Trucker Login</a>
        </p>
    </div>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            this.innerText = "🙈";
        } else {
            passwordField.type = "password";
            this.innerText = "👁️";
        }
    });

    setTimeout(function () {
        var alert = document.getElementById('alertMessage');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 3000);

    setTimeout(function () {
        var alert = document.getElementById('errorAlert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 3000);
</script>
@endsection
