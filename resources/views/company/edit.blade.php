@extends('adminlte::page')

@section('title', 'Edit Company')

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
                    <h4 class="mb-0">Edit Company</h4>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('update.company', $users->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label for="compname" class="form-label">Company Name</label>
                            <input type="text" class="form-control" name="compname" value="{{ old('compname', $users->compname) }}" required>
                        </div>

                        <div class="mb-2">
                            <label for="email" class="form-label">Company Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $users->email) }}" required>
                        </div>

                        <div class="mb-2">
                            <label for="company_phone" class="form-label">Company Phone</label>
                            <input type="tel" class="form-control" name="company_phone" value="{{ old('company_phone', $users->company_phone) }}" required>
                        </div>

                        <div class="mb-2">
                            <label for="company_address" class="form-label">Company Address</label>
                            <input type="text" class="form-control" name="company_address" value="{{ old('company_address', $users->company_address) }}" required>
                        </div>

                        <div class="mb-2">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" name="owner_name" value="{{ old('owner_name', $users->owner_name) }}" required>
                        </div>

                        <div class="mb-2">
                            <label for="owner_email" class="form-label">Owner Email</label>
                            <input type="email" class="form-control" name="owner_email" value="{{ old('owner_email', $users->owner_email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="owner_phone" class="form-label">Owner Phone</label>
                            <input type="tel" class="form-control" name="owner_phone" value="{{ old('owner_phone', $users->owner_phone) }}" required>
                        </div>

                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-check-circle me-1"></i> Update
                        </button>
                        <a href="{{ route('company') }}" class="btn btn-secondary">
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
