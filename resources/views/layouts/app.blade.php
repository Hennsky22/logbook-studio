<!DOCTYPE html>
<html lang="id">
<head>

    <link rel="icon" type="image/png" href="{{ asset('images/logbook-logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Logbook Studio')</title>

    <link rel="stylesheet" href="{{ asset('css/logbook.css') }}">

    @stack('styles')
</head>
<body>

<div class="app-container">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        {{-- BRAND --}}
        <div class="brand">
            <div class="brand-icon">L</div>
            <div>
                <h2>Logbook Studio</h2>
                <p>Broadcast Management</p>
            </div>
        </div>

        {{-- MENU UTAMA --}}
<div class="menu-label">MENU UTAMA</div>

<nav class="sidebar-menu">

    <a href="{{ url('/logbooks') }}"
       class="menu-item {{ request()->is('logbooks') || request()->is('logbooks/*') ? 'active' : '' }}">
        <span>▦</span>
        Dashboard
    </a>

    <a href="{{ url('/reports') }}"
       class="menu-item {{ request()->is('reports') || request()->is('reports/*') ? 'active' : '' }}">
        <span>▤</span>
        Laporan
    </a>

</nav>

{{-- MANAJEMEN --}}
<div class="sidebar-section">

    <div class="menu-label">MANAJEMEN</div>

    <a href="{{ route('maintenance.index') }}"
       class="menu-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
        <span>⚙</span>
        Pemeliharaan
    </a>

</div>

{{-- ADMINISTRASI --}}
@if(auth()->check() && auth()->user()->role === 'admin')

    <div class="sidebar-section">

        <div class="menu-label">ADMINISTRASI</div>

        <a href="{{ route('management.users.index') }}"
           class="menu-item {{ request()->routeIs('management.users.*') ? 'active' : '' }}">
            <span>♙</span>
            Manajemen User
        </a>

    </div>

@endif

        {{-- FOOTER SIDEBAR --}}
        <div class="sidebar-bottom">
            <p>Logbook Studio</p>
            <small>Sistem pencatatan kegiatan</small>
        </div>

    </aside>

    {{-- AREA UTAMA --}}
    <main class="main-content">

        {{-- HEADER --}}
        <header class="topbar">

            <div>
                <h3>@yield('page-title', 'Dashboard')</h3>
                <p>Sistem Informasi Logbook Studio</p>
            </div>

            <div class="realtime-date" id="realtimeDate">
                <span id="realtimeDateText"></span>
                <span id="realtimeClock"></span>
            </div>

            <div class="user-info">

                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>

                <div class="user-details">
                    <strong>{{ auth()->user()->name ?? 'Pengguna' }}</strong>

                    <small>
                        @if(auth()->user()->role === 'admin')
                            Admin
                        @elseif(auth()->user()->role === 'kepala_studio')
                            Kepala Studio
                        @else
                            Petugas
                        @endif
                    </small>
                </div>

                <form action="{{ url('/logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="logout-btn">
                        <span>↪</span>
                        Logout
                    </button>
                </form>

            </div>

        </header>

        {{-- KONTEN HALAMAN --}}
        <section class="page-content">
            @yield('content')
        </section>

    </main>

</div>

</body>
</html>
