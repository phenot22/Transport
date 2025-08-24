@extends('adminlte::page')

@section('title', 'Notifications')

@section('content')

<div class="container mt-4">
    @if(session()->has('success'))
        <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Notifications 
                <span class="notification-count {{ $readNotificationsCount > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $readNotificationsCount }}
                </span>
            </h4>
        </div>

        <div class="card-body">
            @forelse($messages as $message)
                <div id="notification-{{ $message->id }}" class="mb-2 p-2 rounded shadow-sm {{ $message->read_at ? 'bg-light' : 'bg-white' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">{{ $message->created_at->format('M d, Y h:i A') }}</small>
                            <div><strong>Trip ID: {{ $message->id }}</strong></div>
                            </div>
                        <div class="d-flex">
                            <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewMessageModal{{ $message->id }}">
                                View
                            </button>
                            <form method="POST" action="{{ route($message->read_at ? 'notifications.markAsUnread' : 'notifications.markAsRead', $message->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $message->read_at ? 'btn-success' : 'btn-warning' }}">
                                    {{ $message->read_at ? 'Read' : 'Unread' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="viewMessageModal{{ $message->id }}" tabindex="-1" aria-labelledby="viewMessageModalLabel{{ $message->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewMessageModalLabel{{ $message->id }}">Notification Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {!! $message->message !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No notifications available.</p>
            @endforelse

            <div class="d-flex justify-content-center mt-3">
                {!! $messages->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        let alert = document.getElementById('alertMessage');
        if (alert) alert.style.display = 'none';
    }, 3000);
</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    .notification-count {
        display:inline-block; min-width:30px; padding:5px 10px;
        font-size:14px; font-weight:bold; color:#fff;
        border-radius:12px; background:#28a745;
        text-align:center; animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%{box-shadow:0 0 0 0 rgba(40,167,69,0.7);}
        70%{box-shadow:0 0 0 10px rgba(40,167,69,0);}
        100%{box-shadow:0 0 0 0 rgba(40,167,69,0);}
    }
    .pagination-container, .pagination {
        display:flex; justify-content:center; margin-top:20px;
    }
    .pagination {list-style:none; padding:0;}
    .pagination li {margin:0 5px;}
    .pagination a, .pagination span {
        padding:8px 12px; border:1px solid #ddd;
        border-radius:5px; color:#007bff; text-decoration:none;
    }
    .pagination a:hover, .pagination .active, .pagination .page-link:hover {
        background:#007bff; color:#fff;
    }
    .pagination .disabled {color:#ccc; pointer-events:none;}
    .pagination .active {background:#0056b3;}
    .page-item.active .page-link {
        background:#004085; border-color:#004085; color:#fff;
    }
    .page-link:focus {box-shadow:none;}
    @media(max-width:768px){
        .pagination-container{margin-top:15px;}
        .pagination a, .pagination span{padding:6px 10px;}
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
