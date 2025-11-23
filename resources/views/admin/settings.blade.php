@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('System Settings') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="app_name" class="form-label">{{ __('Application Name') }}</label>
                            <input type="text" class="form-control @error('app_name') is-invalid @enderror" 
                                   id="app_name" name="app_name" value="{{ old('app_name', $settings['app_name'] ?? config('app.name')) }}" required>
                            @error('app_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notification_email" class="form-label">{{ __('Notification Email') }}</label>
                            <input type="email" class="form-control @error('notification_email') is-invalid @enderror" 
                                   id="notification_email" name="notification_email" 
                                   value="{{ old('notification_email', $settings['notification_email'] ?? '') }}" required>
                            @error('notification_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="items_per_page" class="form-label">{{ __('Items Per Page') }}</label>
                            <input type="number" class="form-control @error('items_per_page') is-invalid @enderror" 
                                   id="items_per_page" name="items_per_page" 
                                   value="{{ old('items_per_page', $settings['items_per_page'] ?? 15) }}" 
                                   min="5" max="100" required>
                            @error('items_per_page')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="enable_notifications" 
                                   name="enable_notifications" value="1" 
                                   {{ old('enable_notifications', $settings['enable_notifications'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable_notifications">
                                {{ __('Enable Notifications') }}
                            </label>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="maintenance_mode" 
                                   name="maintenance_mode" value="1" 
                                   {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="maintenance_mode">
                                {{ __('Maintenance Mode') }}
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save Settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection