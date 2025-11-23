@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ __('User Productivity Analytics') }}</span>
            <a href="{{ route('admin.reports') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <canvas id="usersChart" height="120"></canvas>

            <hr>
            <h5>Details</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Assigned</th>
                            <th>Completed</th>
                            <th>In Progress</th>
                            <th>Pending</th>
                            <th>Completion %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->assigned }}</td>
                            <td>{{ $u->completed }}</td>
                            <td>{{ $u->in_progress }}</td>
                            <td>{{ $u->pending }}</td>
                            <td>{{ $u->completion_rate }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($labels) !!};
    const assigned = {!! json_encode($assignedData) !!};
    const completed = {!! json_encode($completedData) !!};

    const ctx = document.getElementById('usersChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { label: 'Assigned', data: assigned, backgroundColor: 'rgba(54,162,235,0.6)' },
                { label: 'Completed', data: completed, backgroundColor: 'rgba(75,192,192,0.6)' }
            ]
        },
        options: { responsive: true, scales: { x: { stacked: false }, y: { beginAtZero: true } } }
    });
</script>
@endpush

@endsection
