@extends('adminlte::page')

@section('title', 'Completed Trips')

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
             <h4 class="mb-0">Completed Trips</h4>
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
    <div class="card-body p-2">
      <div class="mb-2 d-flex justify-content-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reportModal">
          Generate Report
        </button>
      </div>

      <table class="table table-bordered table-hover mb-0 text-center">
        <thead class="thead-dark">
          <tr>
            <th>Transaction ID</th>
            <th>Company Name</th>
            <th>Type</th>
            <th>Distance</th>
            <th>Cost</th>
            <th>SDC</th>
            <th>Completed</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($completedTrips as $trip)
            <tr>
              <td>{{ $trip->transaction_id }}</td>
              <td>{{ $trip->compname }}</td>
              <td>{{ $trip->type }}</td>
              <td>{{ $trip->distance }} mi</td>
              <td>${{ number_format($trip->cost,2) }}</td>
              <td>{{ \Carbon\Carbon::parse($trip->schedule)->format('F d, Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($trip->updated_at)->format('F d, Y h:i A') }}</td>  
              <td>
                <button class="btn btn-sm btn-info"
                  data-bs-toggle="modal"
                  data-bs-target="#tripDetailsModal"
                  data-id="{{ $trip->id }}"
                  data-trucker="{{ $trip->trucker_name }}"
                  data-recipient="{{ $trip->name }}"
                  data-address="{{ $trip->address }}"
                  data-contact="{{ $trip->contact }}"
                >View Details</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="d-flex justify-content-center mt-4">
        {{ $completedTrips->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tripDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Trip Details</h5>
      <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
      <p><strong>Completed By:</strong> <span id="modalTruckerName"></span></p>
      <p><strong>Recipient:</strong> <span id="modalRecipient"></span></p>
      <p><strong>Address:</strong> <span id="modalAddress"></span></p>
      <p><strong>Contact:</strong> <span id="modalContact"></span></p>
    </div>
    <div class="modal-footer">
      <form action="{{ route('admin.settle',0) }}" method="POST">
        @csrf
        <input type="hidden" name="trip_id" id="modalTripId">
        <button class="btn btn-danger">Confirm Completion</button>
      </form>
      <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </div></div>
</div>

<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl"><div class="modal-content">
    <div class="modal-body">
      <h5>Summary Report</h5>

      <form action="{{ route('completedtrips') }}" method="GET">
        <div class="mb-3">
          <label for="companyDropdown" class="form-label">Select Company</label>
          <select id="companyDropdown" name="company" class="form-select">
            <option value="">All Companies</option>
            @foreach($summaryByCompany->keys() as $companyName)
              <option value="{{ $companyName }}" {{ request('company') == $companyName ? 'selected' : '' }}>{{ $companyName }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="startDate" class="form-label">Start Date</label>
          <input type="date" id="startDate" name="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>

        <div class="mb-3">
          <label for="endDate" class="form-label">End Date</label>
          <input type="date" id="endDate" name="end_date" value="{{ request('end_date') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportModal" >Generate</button>
      </form>

      <table class="table table-bordered text-center" id="summaryTable">
        <thead>
          <tr><th>Company Name</th><th>Total Cost</th></tr>
        </thead>
        <tbody>
          @foreach($summaryByCompany as $companyName => $total)
            <tr>
              <td class="company-cell">{{ $companyName }}</td>
              <td>${{ number_format($total, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </div></div>
</div>

<script>
document.getElementById('tripDetailsModal')
  .addEventListener('show.bs.modal', e => {
    let b = e.relatedTarget;
    document.getElementById('modalTruckerName').textContent = b.getAttribute('data-trucker');
    document.getElementById('modalRecipient').textContent  = b.getAttribute('data-recipient');
    document.getElementById('modalAddress').textContent    = b.getAttribute('data-address');
    document.getElementById('modalContact').textContent    = b.getAttribute('data-contact');
    document.getElementById('modalTripId').value           = b.getAttribute('data-id');

    let form = document.getElementById('tripDetailsModal').querySelector('form');
    form.action = '/completedtrips/settle/' + b.getAttribute('data-id');
  });

setTimeout(() => {
  document.getElementById('alertMessage')?.remove();
}, 3000);

document.getElementById('companyDropdown').addEventListener('change', function() {
  let filter = this.value.toLowerCase();
  document.querySelectorAll('#summaryTable tbody tr').forEach(row => {
    let name = row.querySelector('.company-cell').textContent.toLowerCase();
    row.style.display = (!filter || name === filter) ? '' : 'none';
  });
});

document.querySelector('#reportModal form').addEventListener('submit', function(event) {
  event.preventDefault();

const modal = new bootstrap.Modal(document.getElementById('reportModal'));


  alert('Report generated!');

  this.submit(); 
});

</script>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
