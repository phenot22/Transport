@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    @if(session()->has('success'))
        <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Trips</h5>
                    <p class="card-text fs-3">{{ $totalTrips }}</p>
                    <i class="fas fa-truck dashboard-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Trips</h5>
                    <p class="card-text fs-3">{{ $pendingTrips }}</p>
                    <i class="fas fa-clock dashboard-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Completed Trips</h5>
                    <p class="card-text fs-3">{{ $completedTrips }}</p>
                    <i class="fas fa-check-circle dashboard-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3 text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Cancelled Trips</h5>
                    <p class="card-text fs-3">{{ $totalCancel }}</p>
                    <i class="fas fa-ban dashboard-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Registered Companies</h5>
                    <p class="card-text fs-3">{{ $totalCompanies }}</p>
                    <i class="fas fa-building dashboard-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-purple mb-3">
                <div class="card-body">
                    <h5 class="card-title">Registered Truckers</h5>
                    <p class="card-text fs-3">{{ $totalTruckers }}</p>
                    <i class="fas fa-user dashboard-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Trip Status Overview</h5>
                    <canvas id="tripChart"></canvas>
                </div>
            </div>
        </div>

@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card { border-radius: 10px; }
        .card:not(.notification-card) .card-body {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .dashboard-icon { font-size: 2rem; margin-top: 10px; }
        .bg-purple { background-color: #6f42c1; }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('tripChart'), {
            type: 'bar',
            data: {
                labels: ['Total','Pending','Completed','Cancelled'],
                datasets: [{
                    label: 'Trips', 
                    data: [{{ $totalTrips }},{{ $pendingTrips }},{{ $completedTrips }},{{ $totalCancel }}],
                    backgroundColor: ['#17a2b8', '#ffc107', '#28a745', '#ff4d4d']
                }]
            }
        });



        setTimeout(function () {
            const alert = document.getElementById('alertMessage');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000); 
    </script>
@endsection
