@extends('adminlte::page')
@section('title', 'Archived Trips')
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
            <h4 class="mb-0">Archived Trips</h4>
        </div>
        <div class="card-body p-3">
            <table class="table table-bordered table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Transaction ID</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Distance</th>
                        <th class="text-center">Cost</th>
                        <th class="text-center">Recipient</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Contact</th>
                        <th class="text-center">SDC</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archivedTrips as $trip)
                        <tr>
                            <td class="text-center">{{ $trip->transaction_id }}</td>
                            <td class="text-center">{{ $trip->type }}</td>
                            <td class="text-center">{{ $trip->distance }} mi</td>
                            <td class="text-center">${{ number_format($trip->cost, 2) }}</td>
                            <td class="text-center">{{ $trip->name }}</td>
                            <td class="text-center">{{ $trip->address }}</td>
                            <td class="text-center">{{ $trip->contact }}</td>
                            <td>{{ \Carbon\Carbon::parse($trip->schedule)->format('F d, Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('archived.restore', ['id' => $trip->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                                </form>
                            </td>              
                        </tr>
                    @endforeach
                </tbody>
            </table>
                        <div class="d-flex justify-content-center mt-4">
                {{ $archivedTrips->links('pagination::bootstrap-4') }}
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
