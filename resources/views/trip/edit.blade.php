@extends('adminlte::page')

@section('title', 'Edit Trip')

{{-- Disable the sidebar and force full layout --}}
@section('body_class', 'layout-fixed sidebar-collapse')

@section('adminlte_sidebar')
@stop

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Trip</h4>
                </div>
                <div class="card-body p-3">

                    @if ($errors->any())
                        <div class="alert alert-danger" id="alertMessage">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('trip.update', ['trip' => $trip]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label class="form-label">Type of Delivery</label>
                            <select class="form-select" name="type" required>
                                <option value="Dry" {{ $trip->type == 'Dry' ? 'selected' : '' }}>Dry</option>
                                <option value="Chilled" {{ $trip->type == 'Chilled' ? 'selected' : '' }}>Chilled</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Distance (mi)</label>
                            <input type="number" class="form-control" name="distance" value="{{ $trip->distance }}" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Cost ($)</label>
                            <input type="number" class="form-control" name="cost" value="{{ $trip->cost }}" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Recipient's Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $trip->name }}" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $trip->address }}" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Contact</label>
                            <input type="number" class="form-control" name="contact" value="{{ $trip->contact }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Scheduled Completion Date</label>
                            <input type="date" class="form-control" name="schedule" value="{{ $trip->schedule }}" required>
                        </div>

                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-check-circle me-1"></i> Update
                        </button>
                        <a href="{{ route('trip.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Cancel
                        </a>
                    </form>
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
    .main-sidebar {
        display: none !important;
    }

    .main-header,
    .main-footer,
    .content-wrapper {
        margin-left: 0 !important;
    }

    body {
        background: url('https://www.transparenttextures.com/patterns/white-wall-3.png');
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 0.875rem;
    }

    .card {
        border-radius: 8px;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
        padding: 0.6rem 1rem;
    }

    .card-header h4 {
        font-size: 1.15rem;
        margin: 0;
    }

    .card-body {
        padding: 1rem;
    }

    .form-label {
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }

    .form-control,
    .form-select,
    textarea {
        font-size: 0.85rem;
        padding: 0.4rem 0.6rem;
    }

    .btn {
        font-size: 0.8rem;
        padding: 0.35rem 0.75rem;
    }

    @media (max-width: 768px) {
        .card {
            margin: 0 1rem;
        }
    }
</style>
@endsection

@section('js')
<script>
    setTimeout(function () {
        var alert = document.getElementById('alertMessage');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 3000);
</script>
@endsection
