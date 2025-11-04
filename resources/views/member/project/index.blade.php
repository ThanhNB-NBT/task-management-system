<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách dự án</title>
</head>
<body>
    <h1>Danh sách dự án của tôi</h1>
    <a href="{{ route('member.dashboard') }}">← Về Dashboard</a>

    @if($projects->isEmpty())
        <p>Bạn chưa tham gia dự án nào.</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên dự án</th>
                    <th>Leader</th>
                    <th>Số task</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->leader->name }}</td>
                    <td>{{ $project->tasks_count }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
