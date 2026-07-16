<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GramediKu')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background:#1e3a5f; display:flex; align-items:center; justify-content:center; min-height:100vh;">
    <div class="auth-card">
        <div class="text-center mb-4">
            <div class="auth-logo"><i class="bi bi-@yield('logo', 'book-half')"></i></div>
            <h5 class="fw-bold mb-1">@yield('card-title', 'GramediKu')</h5>
            @hasSection('card-subtitle')
                <p class="text-muted small mb-0">@yield('card-subtitle')</p>
            @endif
        </div>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>