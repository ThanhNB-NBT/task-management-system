<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách task</title>
</head>
<body>
    <h1>Danh sách task của tôi</h1>
    <a href="{{ route('member.dashboard') }}">← Về Dashboard</a>

    <h3>Filter</h3>
    <form method="GET" action="{{ route('member.tasks.index') }}">
        <label>Status:
            <select name="status">
                <option value="">-- Tất cả --</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
            </select>
        </label>

        <label>Priority:
            <select name="priority">
                <option value="">-- Tất cả --</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </label>

        <button type="submit">Lọc</button>
        <a href="{{ route('member.tasks.index') }}">Reset</a>
    </form>

    @if($tasks->isEmpty())
        <p>Không có task nào.</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Dự án</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->project->name }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->due_date ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('member.tasks.show', $task->id) }}">Xem</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $tasks->links() }}
    @endif
</body>
</html>
