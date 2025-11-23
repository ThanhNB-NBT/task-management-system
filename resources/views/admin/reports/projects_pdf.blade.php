<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projects Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Projects Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Leader</th>
                <th>Start</th>
                <th>End</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->leader?->name }}</td>
                <td>{{ $p->start_date }}</td>
                <td>{{ $p->end_date }}</td>
                <td>{{ $p->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
