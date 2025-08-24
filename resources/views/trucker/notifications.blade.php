@extends('adminlte::page')
@section('title', 'Notifications')
@section('content')
<div class="wrapper">
<aside class="main-sidebar">
    <div class="sidebar-user-info p-3">
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle text-white" style="font-size: 4rem; margin-right: 20px;"></i>
            <div>
                <p class="text-white mb-0">{{ session('trucker.trucker_name') }}</p>
                <p class="text-white mb-0">{{ session('trucker.trucker') }}</p>                   
                <p class="text-white mb-0">{{ session('trucker.compname') }}</p>
            </div>
        </div>
    </div>
    <nav class="nav flex-column">
        @php
            $tripCount = $trips->where('compname', session('compname'))->count();
            $selectedCount = $selectedTrips->where('compname', session('trucker.compname'))->count();
            $assignedCount = $assignedTrips->where('compname', session('trucker.compname'))->count();
            $completedCount = $allCompletedTrips->where('compname', session('trucker.compname'))->count();
        @endphp

        <a href="{{ route('trucker.index') }}" class="nav-link position-relative">
        <i class="bi bi-check-circle"></i> Available Trips
        @if($selectedCount > 0)
            <span class="badge bg-info rounded-pill position-absolute" style="top: 13px; left: 180px; font-size: 0.8rem;">
                {{ $selectedCount }}
            </span>
        @endif
    </a>

        <a href="{{ route('trucker.selectedtrips') }}" class="nav-link position-relative">
        <i class="bi bi-clipboard-check"></i> Selected Trips
        @if($assignedCount > 0)
            <span class="badge bg-primary rounded-pill position-absolute" style="top: 13px; left: 180px; font-size: 0.8rem;">
                {{ $assignedCount }}
            </span>
        @endif
    </a>


        <a href="{{ route('trucker.completedtrips') }}" class="nav-link position-relative">
        <i class="bi bi-check-all"></i> Completed Trips
        @if($completedCount > 0)
            <span class="badge bg-success rounded-pill position-absolute" style="top: 13px; left: 180px; font-size: 0.8rem;">
                {{ $completedCount }}
            </span>
        @endif
    </a>

       <a href="{{ route('trucker.notifications') }}" class="nav-link position-relative">
            <i class="bi bi-bell"></i> Notifications

        </a>        


        <a href="{{ route('logout') }}" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </nav>
</aside>
<div class="container mt-4">
    @if(session()->has('success'))
        <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-sm rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Notifications 
                <span class="notification-count {{ $readNotificationsCount > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $readNotificationsCount }}
                </span>
            </h4>
        </div>

        <div class="card-body">
            @forelse($messages as $message)
                <div id="notification-{{ $message->id }}" class="mb-2 p-2 rounded shadow-sm {{ $message->read_at ? 'bg-light' : 'bg-white' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">{{ $message->created_at->format('M d, Y h:i A') }}</small>
                            <div><strong>Trip ID: {{ $message->id }}</strong></div>
                        </div>
                        <div class="d-flex">
                            <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewMessageModal{{ $message->id }}">
                                View
                            </button>
                            <form method="POST" action="{{ route($message->read_at ? 'notifications.markAsUnread2' : 'notifications.markAsRead2', $message->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $message->read_at ? 'btn-warning' : 'btn-success' }}">
                                    {{ $message->read_at ? 'Read' : 'Unread' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="viewMessageModal{{ $message->id }}" tabindex="-1" aria-labelledby="viewMessageModalLabel{{ $message->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewMessageModalLabel{{ $message->id }}">Notification Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {!! $message->message !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No notifications available.</p>
            @endforelse

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {!! $messages->links('pagination::bootstrap-4') !!}
            </div>
        </div>
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
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        background: url('https://www.transparenttextures.com/patterns/white-wall-3.png');
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
        border-radius: 10px;
    }
    .card-header {
        border-bottom: 1px solid #dee2e6;
    }
    .card-header h4 {
        font-size: 1.5rem;
        margin: 0;
    }
    table {
        width: 100%;
        border-collapse: separate;
    }
    table th, table td {
        padding: 10px 12px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
        white-space: nowrap;
    }
    table th {
        background-color: #343a40;
        color: #fff;
    }
    .table-row-hover {
        transition: background-color 0.25s ease;
    }
    .table-row-hover:hover {
        background-color: #e9ecef;
    }
    thead th:first-child {
        border-top-left-radius: 10px;
    }
    thead th:last-child {
        border-top-right-radius: 10px;
    }
    @media (max-width: 992px) {
        table th, table td {
            padding: 8px 10px;
            font-size: 0.9rem;
        }
        .card-header h4 {
            font-size: 1.25rem;
        }
    }
</style>
@endsection
<style>
.wrapper {
    display: flex;
}

.main-sidebar {
    width: 250px;
    position: fixed;
    height: 100%;
    background-color: #343a40;
    padding-top: 20px;
    left: 0;
    top: 0;
}

.main-sidebar .nav-link {
    color: white;
    padding: 12px;
    display: block;
    font-size: 16px;
}

.main-sidebar .nav-link:hover {
    background-color: #495057;
}

.content-wrapper {
    margin-left: 250px;
    width: calc(100% - 250px);
    background: #f8f9fa;
    overflow-y: auto;
    min-height: 100vh;
}

.table {
    background: white;
}

.btn-close {
    float: right;
}

body.sidebar-mini {
    overflow-x: hidden;
}

body {
    margin: 0;
    background-size: cover;
    color: #000;
    min-height: 100vh;
    background-color: #f4f4f4;
}

.navbar {
    width: 100%;
    position: fixed;
    top: 0;
}

    .notification-count {
        display:inline-block; min-width:30px; padding:5px 10px;
        font-size:14px; font-weight:bold; color:#fff;
        border-radius:12px; background:#28a745;
        text-align:center; animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%{box-shadow:0 0 0 0 rgba(40,167,69,0.7);}
        70%{box-shadow:0 0 0 10px rgba(40,167,69,0);}
        100%{box-shadow:0 0 0 0 rgba(40,167,69,0);}
    }
</style>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection