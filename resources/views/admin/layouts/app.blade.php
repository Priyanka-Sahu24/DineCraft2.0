<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') | Dinecraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin/admin.css') }}" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand text-orange" href="{{ route('admin.staff.index') }}">Dinecraft Admin</a>
            <!-- Add menu links here -->
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
