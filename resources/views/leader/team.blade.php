@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-users"></i> {{ __('Team Members') }}
            </h1>
            <p class="text-muted small">{{ __('Members in your projects') }}</p>
        </div>
    </div>

    <!-- Team Members Grid -->
    <div class="row">
        @forelse($members as $member)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user fa-2x text-muted"></i>
                            </div>
                        </div>
                        <h6 class="card-title mb-1">{{ $member->name }}</h6>
                        <p class="text-muted small mb-2">{{ $member->email }}</p>
                        <div class="mb-3">
                            <span class="badge bg-{{ $member->role === 'admin' ? 'danger' : ($member->role === 'leader' ? 'primary' : 'secondary') }}">
                                {{ ucfirst($member->role) }}
                            </span>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-briefcase"></i> Joined on {{ $member->created_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> {{ __('No team members found.') }}
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
