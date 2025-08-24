@extends('adminlte::page')

@section('content')
<div class="card p-3 shadow-sm" style="max-width: 800px; margin: auto; margin-top: 50px;"> 
    <h3 class="text-center mb-3">Add New Trip</h3>
    @if (Session::has('success'))
        <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif   
    <form method="post" action="{{ route('trip.store') }}" class="needs-validation" novalidate>
        @csrf
        <input type="hidden" name="status" value="available">

        <h5 class="mt-3">Trip Details</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="transaction_id" class="small">Transaction ID</label>
                <input type="text" id="transaction_id" name="transaction_id" class="form-control form-control-sm" readonly required>
                @error('transaction_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
                <label for="type" class="small">Type of Delivery</label>
                <select id="type" name="type" class="form-control form-control-sm">
                    <option value="Dry">Dry</option>
                    <option value="Chilled">Chilled</option>
                </select>
                @error('type') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <label for="distance" class="small">Distance (mi)</label>
                <input type="number" id="distance" name="distance" class="form-control form-control-sm" placeholder="Enter distance in miles" required>
                @error('distance') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
                <label for="cost" class="small">Cost ($)</label>
                <input type="number" id="cost" name="cost" class="form-control form-control-sm" placeholder="Auto-calculated" readonly required>
                @error('cost') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        
        <hr>
        <h5 class="mt-3">Recipient Details</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="name" class="small">Recipient's Name</label>
                <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Enter recipient's name" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
                <label for="contact" class="small">Contact</label>
                <input type="text" id="contact" name="contact" class="form-control form-control-sm" placeholder="Enter contact number" required>
                @error('contact') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label for="address" class="small">Address</label>
                <input type="text" id="address" name="address" class="form-control form-control-sm" placeholder="Enter address" required>
                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <hr>
        <h5 class="mt-3">Schedule</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="schedule" class="small">Scheduled Completion Date</label>
                <input type="date" id="schedule" name="schedule" class="form-control form-control-sm" required>
                @error('schedule') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> Submit</button>
            <a href="{{ route('index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </form>
</div>

<script>
    function generateTransactionID() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let transactionId = '';
        for (let i = 0; i < 8; i++) {
            transactionId += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        document.getElementById('transaction_id').value = transactionId;
    }

    window.onload = generateTransactionID;

    function recalcCost() {
        let distance = parseFloat(document.getElementById('distance').value) || 0;
        let type = document.getElementById('type').value;
        let rate = type === 'Chilled' ? 10.5 : 8; 
        document.getElementById('cost').value = (distance * rate).toFixed(2);
    }

    document.getElementById('distance').addEventListener('input', recalcCost);
    document.getElementById('type').addEventListener('change', recalcCost);
</script>
@endsection
