@extends('adminlte::page')

@section('title', 'Selected Trips')

@section('content')
@section('js')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@endsection
<div class="wrapper">
<aside class="main-sidebar">
    <div class="sidebar-user-info p-3">
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle text-white" style="font-size: 4rem; margin-right: 20px;"></i>
            <div>
                <p class="text-white mb-0">{{ session('company.owner_name') }}</p>
                <p class="text-white mb-0">{{ session('company.company') }}</p>                   
                <p class="text-white mb-0">{{ session('company.compname') }}</p>
            </div>
        </div>
    </div>
    <nav class="nav flex-column">
        <a href="{{ route('company.index') }}" class="nav-link"><i class="bi bi-truck"></i> Truckers List</a>

        @php
            $tripCount = $trips->count();
            $selectedCount = $allSelectedTrips->where('compname', session('company.compname'))->count();
            $assignedCount = $assignedTrips->where('compname', session('company.compname'))->count();
            $completedCount = $completedTrips->where('compname', session('company.compname'))->count();
        @endphp

    <a href="{{ route('company.trips') }}" class="nav-link position-relative">
        <i class="bi bi-check-circle"></i> Available Trips
        @if($tripCount > 0)
            <span class="badge bg-info rounded-pill position-absolute" style="top: 13px; left: 180px; font-size: 0.8rem;">
                {{ $tripCount }}
            </span>
        @endif
    </a>

    <a href="{{ route('company.selectedtrips') }}" class="nav-link position-relative">
        <i class="bi bi-clipboard-check"></i> Selected Trips
        @if($selectedCount > 0)
            <span class="badge bg-primary rounded-pill position-absolute" style="top: 13px; left: 180px; font-size: 0.8rem;">
                {{ $selectedCount }}
            </span>
        @endif
    </a>

    <a href="{{ route('company.pendingtrips') }}" class="nav-link position-relative">
        <i class="bi bi-clock"></i> Pending Trips
        @if($assignedCount > 0)
            <span class="badge bg-warning rounded-pill position-absolute" style="top: 13px; left: 180px; font-size: 0.8rem;">
                {{ $assignedCount }}
            </span>
        @endif
    </a>

    <a href="{{ route('company.completedtrips') }}" class="nav-link position-relative">
        <i class="bi bi-check-all"></i> Completed Trips
        @if($completedCount > 0)
            <span class="badge bg-success rounded-pill position-absolute" style="top: 13px; left: 180px; font-size: 0.8rem;">
                {{ $completedCount }}
            </span>
        @endif
    </a>

       <a href="{{ route('company.notifications') }}" class="nav-link position-relative">
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
            <div class="card-header">
                <h4 class="mb-0">Selected Trips</h4>
            </div>

            <div class="card-body p-3">
                <table class="table table-bordered table-hover mb-0 text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Transaction ID</th>                   
                            <th>Type</th>
                            <th>Distance</th>
                            <th>Cost</th>
                            <th>Recipient</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>SDC</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selectedTrips->where('compname', session('company.compname')) as $trip)  
                            <tr class="table-row-hover">
                                <td>{{ $trip->transaction_id }}</td>                          
                                <td>{{ $trip->type }}</td>
                                <td>{{ $trip->distance }} mi</td>
                                <td>${{ number_format($trip->cost, 2) }}</td>
                                <td>{{ $trip->name }}</td>
                                <td>{{ $trip->address }}</td>
                                <td>{{ $trip->contact }}</td>
                                <td>{{ \Carbon\Carbon::parse($trip->schedule)->format('F d, Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $trip->id }}">
                                        Cancel
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="cancelModal{{ $trip->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $trip->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('trip.cancel', ['id' => $trip->id]) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="cancel_reason{{ $trip->id }}">REASON FOR CANCELLATION</label>
                                                    <textarea name="cancel_reason" id="cancel_reason{{ $trip->id }}" class="form-control" rows="3" required></textarea>
                                                </div>
                                                <input type="hidden" name="owner_name" value="{{ session('company.owner_name') }}">
                                                <input type="hidden" name="compname" value="{{ session('company.compname') }}">
                                                <input type="hidden" name="transaction_id" value="{{ $trip->transaction_id }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Confirm Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach                
                    </tbody>
                </table>
                            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $selectedTrips->links('pagination::bootstrap-4') }}
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        background: url('https://www.transparenttextures.com/patterns/white-wall-3.png');
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        background-size: cover;
        color: #000;
        min-height: 100vh;
    }

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

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const textarea = form.querySelector('textarea');
        if (textarea && textarea.value.trim() === '') {
            e.preventDefault();
            alert('Please enter a reason for cancellation.');
        }
    });
});

setTimeout(function() {
    var alert = document.getElementById('alertMessage');
    if (alert) {
        alert.style.display = 'none';
    }
}, 3000);
</script>
@endsection
