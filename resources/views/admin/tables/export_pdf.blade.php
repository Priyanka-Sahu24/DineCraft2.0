<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tables PDF Export</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Tables Export</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Table Number</th>
                <th>Capacity</th>
                <th>Location</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tables as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->table_number ?? '' }}</td>
                <td>{{ $t->capacity }}</td>
                <td>{{ $t->location }}</td>
                <td>{{ $t->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
