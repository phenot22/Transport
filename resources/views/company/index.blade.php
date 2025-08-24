@extends('adminlte::page')
@section('title', 'Truckers List')
@section('content')
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
            $selectedCount = $selectedTrips->where('compname', session('company.compname'))->count();
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
                    <h4 class="mb-0">Truckers List </h4>
            <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('truckersregistration') }}" class="btn btn-primary">Add Trucker</a>
    </div> 
        </div>             
                <div class="card-body p-3">
                    <table class="table table-bordered table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Fullname</th>
                        <th class="text-center">Gender</th>  
                        <th class="text-center">Birthdate</th>   
                        <th class="text-center">Address</th>                                                                                           
                        <th class="text-center">Contact no.</th>
                        <th class="text-center">Email</th>                                                                                                                   
                        <th class="text-center">Created</th>
                        <th class="text-center">Actions</th>                                                 
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)      
                        <tr class="table-row-hover">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->trucker_name }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->dob }}</td>                            
                            <td>{{ $user->trucker_address }}</td>
                            <td>{{ $user->trucker_phone }}</td>                            
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('F d, Y h:i A') }}</td>
                            <td class="text-center">
                                <a href="{{ route('trucker.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('delete1.company', $user->id) }}" method="POST" style="display:inline-block;">

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Trucker?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach                
                </tbody>
                    </table>
            <div class="d-flex justify-content-center mt-4">
                <div>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
                </div>
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
</style>

@endsection
