@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ __('Project Productivity Analytics') }}</span>
            <a href="{{ route('admin.reports') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <canvas id="projectsChart" height="120"></canvas>

            <hr>
            <h5>Details</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Total Tasks</th>
                            <th>Completed</th>
                            <th>In Progress</th>
                            <th>Pending</th>
                            <th>Progress %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->total }}</td>
                            <td>{{ $p->done }}</td>
                            <td>{{ $p->in_progress }}</td>
                            <td>{{ $p->pending }}</td>
                            <td>{{ $p->progress }}%</td>
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
    const total = {!! json_encode($totalData) !!};
    const done = {!! json_encode($doneData) !!};

    const ctx = document.getElementById('projectsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { label: 'Total Tasks', data: total, backgroundColor: 'rgba(255,159,64,0.6)' },
                { label: 'Completed', data: done, backgroundColor: 'rgba(153,102,255,0.6)' }
            ]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endpush

@endsection
