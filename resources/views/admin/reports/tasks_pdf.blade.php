<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Tasks Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Project</th>
                <th>Assignee</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->title }}</td>
                <td>{{ $t->project?->name }}</td>
                <td>{{ $t->assignee?->name }}</td>
                <td>{{ $t->status }}</td>
                <td>{{ $t->priority }}</td>
                <td>{{ $t->due_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
