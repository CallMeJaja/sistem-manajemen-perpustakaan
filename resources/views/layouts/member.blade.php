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

    <nav class="navbar navbar-expand-lg public-navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('member.dashboard') }}">
                <i class="bi bi-book-half me-2"></i>GramediKu
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#memberNavbar" aria-controls="memberNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="memberNavbar">
                <div class="navbar-nav ms-auto align-items-lg-center gap-2 mt-2 mt-lg-0">
                    <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-light {{ request()->routeIs('catalog.*') ? 'active' : '' }} text-start">
                        <i class="bi bi-grid me-1"></i>Katalog
                    </a>
                    <a href="{{ route('member.dashboard') }}" class="btn btn-sm btn-outline-light {{ request()->routeIs('member.dashboard') ? 'active' : '' }} text-start">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                    <a href="{{ route('member.borrowings') }}" class="btn btn-sm btn-outline-light {{ request()->routeIs('member.borrowings') ? 'active' : '' }} text-start">
                        <i class="bi bi-journal-bookmark me-1"></i>Pinjaman Saya
                    </a>
                    <a href="{{ route('member.profile') }}" class="btn btn-sm btn-outline-light {{ request()->routeIs('member.profile') ? 'active' : '' }} text-start">
                        <i class="bi bi-person me-1"></i>Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light w-100 text-start">
                            <i class="bi bi-box-arrow-right me-1"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-grow-1">
        <div class="container py-4">
            <x-alert type="success" session="success" dismissible />
            <x-alert type="danger" session="error" dismissible />

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
