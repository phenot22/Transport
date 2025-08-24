@extends('adminlte::page')
@section('title', 'Company List')

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
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-12">
                    <h4 class="mb-0">Company List</h4>
                </div>
                <div class="col-md-6 col-sm-12 text-md-end text-sm-start mt-2 mt-md-0">
                    <a href="{{ route('registration') }}" class="btn btn-primary">Add Company</a>
                </div>
            </div>
        </div>

        <div class="card-body p-3">
            <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 text-center">
                
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Company Name</th>
                            <th class="text-center">Company Email</th>
                            <th class="text-center">Company Phone</th>
                            <th class="text-center">Company Address</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="table-row-hover">
                                <td>{{ $user->compname }}</td>  
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->company_phone }}</td>
                                <td>{{ $user->company_address }}</td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <button class="btn btn-sm btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#tripDetailsModal"
                                            data-id="{{ $user->id }}"
                                            data-owner_name="{{ $user->owner_name }}"
                                            data-owner_email="{{ $user->owner_email }}"
                                            data-owner_phone="{{ $user->owner_phone }}"
                                            data-created_at="{{ $user->created_at ->format('F d, Y h:i A')}}"
                                        >View</button>
                                        <a href="{{ route('edit.company', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('delete.company', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this company?')">Delete</button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>

<div class="modal fade" id="tripDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Company Details</h5>
      <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
      <p><strong>Owner Name:</strong> <span id="modalOwnerName"></span></p>
      <p><strong>Owner Email:</strong> <span id="modalOwnerEmail"></span></p>
      <p><strong>Owner Phone:</strong> <span id="modalOwnerPhone"></span></p>
      <p><strong>Created:</strong> <span id="modalCreated"></span></p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </div></div>
</div>
        </div>
    </div>
</div>
<script>
    document.getElementById('tripDetailsModal')
      .addEventListener('show.bs.modal', e => {
        let b = e.relatedTarget;
        document.getElementById('modalOwnerName').textContent = b.getAttribute('data-owner_name');
        document.getElementById('modalOwnerEmail').textContent  = b.getAttribute('data-owner_email');
        document.getElementById('modalOwnerPhone').textContent    = b.getAttribute('data-owner_phone');
        document.getElementById('modalCreated').textContent    = b.getAttribute('data-created_at');
        document.getElementById('modalTripId').value           = b.getAttribute('data-id');

      });


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
<link rel="stylesheet" href="{{ asset('css/company.css') }}">
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        table-layout: fixed;
    }

    table th, table td {
        padding: 10px;
        word-wrap: break-word;
        white-space: normal;
    }

    .table-row-hover:hover {
        background-color: #f1f1f1;
    }

.pagination {
    justify-content: center;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.pagination li {
    display: inline-block;
    margin: 0 3px;
}

.pagination li a, .pagination li span {
    color: #007bff;
    padding: 8px 15px;
    text-decoration: none;
    border-radius: 0.25rem;
    border: 1px solid #ddd;
}

.pagination li a:hover, .pagination li span:hover {
    background-color: #007bff;
    color: #fff;
}

.pagination .active a {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination .disabled a {
    background-color: #f0f0f0;
    color: #d6d6d6;
    pointer-events: none;
}

/* Add custom style to center pagination items properly */
.pagination .page-item {
    display: inline-block;
}

/* Add extra styling for active page button */
.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination .page-item.disabled .page-link {
    background-color: #f0f0f0;
    border-color: #f0f0f0;
    color: #d6d6d6;
    pointer-events: none;
}

</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
