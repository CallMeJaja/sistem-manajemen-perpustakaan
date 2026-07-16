<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GramediKu — Sistem Perpustakaan')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body style="background:#f8fafc;">

    {{-- SIDEBAR OVERLAY --}}
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-book-half"></i>
            </div>
            <div class="sidebar-brand-text">
                GramediKu
                <small>Digital Library</small>
            </div>
        </a>

        <nav class="sidebar-nav">
            <div class="sidebar-label">Menu Utama</div>

            <a href="{{ route('dashboard') }}"
               class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="sidebar-label mt-2">Manajemen</div>

            <a href="{{ route('books.index') }}"
               class="sidebar-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Buku
            </a>

            <a href="{{ route('members.index') }}"
               class="sidebar-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Anggota
            </a>

            <div class="sidebar-label mt-2">Transaksi</div>
            
            <a href="{{ route('borrowings.index') }}"
               class="sidebar-link {{ request()->routeIs('borrowings.index') || request()->routeIs('borrowings.show') || request()->routeIs('borrowings.create') ? 'active' : '' }}">
                <i class="bi bi-arrow-up-right-circle"></i> Peminjaman Aktif
            </a>
            
            <a href="{{ route('returns.index') }}"
               class="sidebar-link {{ request()->routeIs('returns.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-down-left-circle"></i> Pengembalian
            </a>
            
            <a href="{{ route('borrowings.history') }}"
               class="sidebar-link {{ request()->routeIs('borrowings.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Transaksi
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button id="sidebarToggle" class="btn btn-outline-secondary d-lg-none btn-sm px-2">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                    <div class="topbar-subtitle">@yield('page-subtitle', 'Sistem Manajemen Perpustakaan Digital')</div>
                </div>
            </div>
            @yield('topbar-actions')
        </div>

        <div class="main-content">
            <x-alert type="success" session="success" dismissible />
            <x-alert type="danger" session="error" dismissible />

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('sidebarToggle');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            if (toggle) toggle.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);
        });
    </script>
    @stack('scripts')
</body>
</html>
