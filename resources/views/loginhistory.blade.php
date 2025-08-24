@extends('adminlte::page')
@section('title', 'Login History')
@section('content')
<div class="container mt-4">
    @if(session()->has('success'))
        <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm rounded">
        <div class="card-header">
            <h4 class="mb-0">Login History Details</h4>
        </div>
        <div class="card-body p-3">
            <table class="table table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">User ID</th>
                        <th class="text-center">User Email</th>
                        <th class="text-center">IP Address</th>
                        <th class="text-center">User Agent</th>
                        <th class="text-center">Login Time</th>
                        <th class="text-center">Logout Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loginHistory as $history)
                        <tr>
                            <td class="text-center">{{ $history->user_id }}</td>
                            <td class="text-center">{{ $history->email }}</td>
                            <td class="text-center">{{ $history->ip_address }}</td>
                            <td class="text-center">{{ $history->user_agent }}</td>
                            <td class="text-center">{{ $history->login_time }}</td>
                            <td class="text-center">
                                @if($history->logout_time)
                                    {{ $history->logout_time }}
                                @else
                                    <span class="text-warning">Not logged out yet</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $loginHistory->links() }}
    </div>
</div>

<script>
    setTimeout(function() {
        var alert = document.getElementById('alertMessage');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 3000);
</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/loginhistory.css') }}">
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
