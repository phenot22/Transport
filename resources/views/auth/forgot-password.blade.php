@extends('adminlte::page')

@section('content')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

<div class="container">
    <h2>Forgot Password</h2>
    
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('forgot-password') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send OTP</button>
    </form>
    <a href="{{ route('adminlogin') }}" class="back-btn">← Back to Login</a>
</div>

@endsection
