<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Katalog Buku — GramediKu')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body style="background:#f8fafc;">

    <nav class="navbar public-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('catalog.index') }}">
                <i class="bi bi-book-half me-2"></i>GramediKu
            </a>
            <div class="d-flex align-items-center gap-2">
                @auth
                    @if (auth()->user()->isMember())
                        <a href="{{ route('member.dashboard') }}" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-person-circle me-1"></i>Portal Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light">
                                <i class="bi bi-box-arrow-right me-1"></i>Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard Admin
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">
                        <i class="bi bi-person-plus me-1"></i>Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="flex-grow-1">
        @yield('hero')

        <div class="container py-4">
            @yield('content')
        </div>
    </div>

    <footer class="public-footer">
        &copy; {{ date('Y') }} GramediKu &mdash; Sistem Manajemen Perpustakaan
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
