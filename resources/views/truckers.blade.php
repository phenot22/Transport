@extends('adminlte::page')

@section('title', 'Truckers List')

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
            <h4 class="mb-0">Truckers List</h4>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Company Name</th>                        
                            <th class="text-center">Fullname</th>
                            <th class="text-center">Gender</th>  
                            <th class="text-center">Contact no.</th>
                            <th class="text-center">Actions</th>                                                  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="table-row-hover">
                                <td>{{ $user->compname }}</td>
                                <td>{{ $user->trucker_name }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->trucker_phone }}</td> 
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <button class="btn btn-sm btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#tripDetailsModal"
                                            data-id="{{ $user->id }}"
                                            data-dob="{{ \Carbon\Carbon::parse($user->dob)->format('F d, Y') }}"
                                            data-trucker_address ="{{ $user->trucker_address }}"
                                            data-email="{{ $user->email }}"
                                            data-created_at="{{ $user->created_at ->format('F d, Y h:i A')}}"
                                        >View</button>
                                        <form action="{{ route('delete.trucker', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this trucker?')">Delete</button>
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
      <h5 class="modal-title">Truckers Details</h5>
      <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
      <p><strong>Birthdate:</strong> <span id="modalBirthdate"></span></p>
      <p><strong>Address:</strong> <span id="modalAddress"></span></p>
      <p><strong>Email:</strong> <span id="modalEmail"></span></p>
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
        document.getElementById('modalBirthdate').textContent = b.getAttribute('data-dob');
        document.getElementById('modalAddress').textContent  = b.getAttribute('data-trucker_address');
        document.getElementById('modalEmail').textContent    = b.getAttribute('data-email');
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
        display: inline;
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
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
