@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-bell"></i> {{ __('Notifications') }}
            </h1>
            <p class="text-muted small">
                {{ __('You have') }} <strong>{{ $unreadCount }}</strong> {{ __('unread notification(s)') }}
            </p>
        </div>
        <div class="col-md-4 text-end">
            @if($unreadCount > 0)
                <form action="{{ route('member.notifications.mark-all-as-read') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-check-double"></i> {{ __('Mark All as Read') }}
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($notifications->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="list-group">
                    @foreach($notifications as $notification)
                        <div class="list-group-item {{ !$notification->is_read ? 'bg-light border-primary' : '' }}">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1">
                                        <h6 class="mb-0">
                                            @if(!$notification->is_read)
                                                <span class="badge bg-primary me-2">{{ __('New') }}</span>
                                            @endif
                                            {{ $notification->message }}
                                        </h6>
                                    </div>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-clock"></i>
                                        @php
                                            try {
                                                echo $notification->created_at->diffForHumans();
                                            } catch (\Exception $e) {
                                                echo '—';
                                            }
                                        @endphp
                                    </small>
                                </div>

                                <div class="text-end ms-3">
                                    @if(!$notification->is_read)
                                        <form action="{{ route('member.notifications.mark-as-read', $notification) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary" title="{{ __('Mark as Read') }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> {{ __('Read') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            {{ __('No notifications yet.') }}
        </div>
    @endif
</div>

<style>
    .list-group-item {
        border: 1px solid #dee2e6;
        padding: 1.25rem;
        transition: background-color 0.2s;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .list-group-item.bg-light {
        background-color: #e7f3ff !important;
    }

    .list-group-item.border-primary {
        border-left: 4px solid #007bff !important;
    }
</style>
@endsection
