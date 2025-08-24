@extends('adminlte::page')

@section('title', 'Trip Lists')

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
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Trip List</h4>
                <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center">
                    <div class="me-2">
                        <select name="sort_by" class="form-select">
                            <option value="type" {{ request('sort_by') == 'type' ? 'selected' : '' }}>Type</option>
                            <option value="distance" {{ request('sort_by') == 'distance' ? 'selected' : '' }}>Distance</option>
                            <option value="cost" {{ request('sort_by') == 'cost' ? 'selected' : '' }}>Cost</option>
                            <option value="schedule" {{ request('sort_by') == 'schedule' ? 'selected' : '' }}>SDC</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Sort</button>
                </form>
            </div>

            {{-- "Add Trip" button --}}
            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('trip.create') }}" class="btn btn-primary">Add Trip</a>
            </div>

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
                    @foreach ($trips as $trip)
                        <tr class="table-row-hover">
                            <td>{{ $trip->transaction_id }}</td>
                            <td>{{ $trip->type }}</td>
                            <td>{{ number_format($trip->distance, 2) }} mi</td>
                            <td>${{ number_format($trip->cost, 2) }}</td>
                            <td>{{ $trip->name }}</td>
                            <td>{{ $trip->address }}</td>
                            <td>{{ $trip->contact }}</td>
                            <td>{{ \Carbon\Carbon::parse($trip->schedule)->format('F d, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('trip.edit', ['trip' => $trip]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="post" action="{{ route('trip.destroy', ['trip' => $trip]) }}" onsubmit="return confirm('Are you sure you want to delete this trip?');">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Summary Section --}}
            <div class="mt-4 p-3 bg-light rounded shadow-sm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-white border rounded shadow-sm"><br>
                            Total Trips: <strong>{{ $dryCount + $chilledCount }}</strong><br><br>
                            Total Distance: <strong>{{ number_format($totalDistance, 2) }} miles</strong><br>
                            Total Cost: <strong>${{ number_format($totalCost, 2) }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-white border rounded shadow-sm">
                            Dry Deliveries: <strong>{{ $dryCount }}</strong><br>
                            Total Cost: <strong>${{ number_format($dryTotalCost, 2) }}</strong><br><br>

                            Chilled Deliveries: <strong>{{ $chilledCount }}</strong><br>
                            Total Cost: <strong>${{ number_format($chilledTotalCost, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $trips->links('pagination::bootstrap-4') }}
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
<style>
.table-row-hover:hover {
    background-color: #f0f8ff;
}
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
