<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách dự án</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-4">
        <h1 class="mb-4">Danh sách dự án</h1>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress
                    </option>
                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="priority" class="form-select">
                    <option value="">-- Tất cả độ ưu tiên --</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo tiêu đề..."
                    value="{{ request('keyword') }}">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Lọc</button>
            </div>
        </form>

        @if ($tasks->isEmpty())
            <div class="alert alert-warning">Không có task nào được tìm thấy.</div>
        @else
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Dự án</th>
                        <th>Ưu tiên</th>
                        <th>Trạng thái</th>
                        <th>Ngày đến hạn</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->project->name }}</td>
                            <td><span
                                    class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'secondary') }}">{{ ucfirst($task->priority) }}</span>
                            </td>
                            <td>{{ ucfirst($task->status) }}</td>
                            <td>{{ $task->due_date ?? '—' }}</td>
                            <td><a href="{{ route('member.tasks.show', $task->id) }}"
                                    class="btn btn-sm btn-outline-primary">Xem</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $tasks->links() }}
        @endif
    </div>

</body>

</html>
