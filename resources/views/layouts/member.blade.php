<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Member Portal — GramediKu')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body style="background:#f8fafc; min-height:100vh; display:flex; flex-direction:column;">

    <nav class="navbar public-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('member.dashboard') }}">
                <i class="bi bi-book-half me-2"></i>GramediKu
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-light {{ request()->routeIs('catalog.*') ? 'active' : '' }}">
                    <i class="bi bi-grid me-1"></i>Katalog
                </a>
                <a href="{{ route('member.dashboard') }}" class="btn btn-sm btn-outline-light {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                </a>
                <a href="{{ route('member.borrowings') }}" class="btn btn-sm btn-outline-light {{ request()->routeIs('member.borrowings') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark me-1"></i>Pinjaman Saya
                </a>
                <a href="{{ route('member.profile') }}" class="btn btn-sm btn-outline-light {{ request()->routeIs('member.profile') ? 'active' : '' }}">
                    <i class="bi bi-person me-1"></i>Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light">
                        <i class="bi bi-box-arrow-right me-1"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="flex-grow-1">
        <div class="container py-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <footer class="public-footer">
        &copy; {{ date('Y') }} GramediKu &mdash; Member Portal
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
