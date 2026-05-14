<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Katalog Buku — Perpustakaan Digital')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body style="background:#f8fafc;">

    <nav class="navbar public-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('catalog.index') }}">
                <i class="bi bi-book-half me-2"></i>Perpustakaan Digital
            </a>
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">
                <i class="bi bi-lock me-1"></i>Login Admin
            </a>
        </div>
    </nav>

    @yield('hero')

    <div class="container py-4">
        @yield('content')
    </div>

    <footer class="public-footer">
        &copy; {{ date('Y') }} Perpustakaan Digital &mdash; Sistem Manajemen Perpustakaan
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
