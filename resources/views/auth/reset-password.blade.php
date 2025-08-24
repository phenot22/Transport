@extends('adminlte::page')
@section('content')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> 
@endpush
<style>
</style>
<div class="container">
    <h2>Reset Password</h2>
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <form action="{{ route('reset.password') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <button type="submit">Reset Password</button>
    </form>
        <a href="{{ route('forgot-password') }}" class="back-btn">← Back</a>
</div>
@endsection
