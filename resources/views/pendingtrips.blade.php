@extends('adminlte::page')
@section('title', 'Pending Trips')
@section('content')
<div class="container mt-4">
    @if(session()->has('success'))
        <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

        <div class="card shadow-sm rounded">
        <div class="card-body p-3">
            {{-- Sorting Controls --}}
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Trip List</h4>
                <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center">
                    <div class="me-2">
                        <select name="sort_by" class="form-select">
                            <option value="compname" {{ request('sort_by') == 'compname' ? 'selected' : '' }}>Company</option>
                            <option value="type" {{ request('sort_by') == 'type' ? 'selected' : '' }}>Type</option>
                            <option value="distance" {{ request('sort_by') == 'distance' ? 'selected' : '' }}>Distance</option>
                            <option value="cost" {{ request('sort_by') == 'cost' ? 'selected' : '' }}>Cost</option>
                            <option value="schedule" {{ request('sort_by') == 'schedule' ? 'selected' : '' }}>SDC</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Sort</button>
                </form>
            </div>

    <div class="card shadow-sm rounded">
        <div class="card-header">
            <h4 class="mb-0">Pending Trips</h4>
        </div>
        <div class="card-body p-2">
            <table class="table table-bordered table-hover mb-0 text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Transction ID</th>
                        <th>Company Name</th>                                         
                        <th>Type</th>
                        <th>Distance</th>
                        <th>Cost</th>
                        <th>Recipient</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>SDC</th>
                    </tr>
                </thead>
<tbody>
    @foreach ($pendingTrips as $trip)
        <tr class="table-row-hover">
            <td>{{ $trip->transaction_id }}</td>
            <td>{{ $trip->compname }}</td>
            <td>{{ $trip->type }}</td>
            <td>{{ $trip->distance }} mi</td>
            <td>${{ number_format($trip->cost, 2) }}</td>
            <td>{{ $trip->name }}</td>
            <td>{{ $trip->address }}</td>
            <td>{{ $trip->contact }}</td>
            <td>{{ \Carbon\Carbon::parse($trip->schedule)->format('F d, Y') }}</td>

        </tr>
    @endforeach
</tbody>
</table>

<div class="d-flex justify-content-center mt-4">
    {{ $pendingTrips->links('pagination::bootstrap-4') }}
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
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

