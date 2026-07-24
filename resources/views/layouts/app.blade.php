<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Viberlink LMS</title>
    <!-- CSS di-link ke style.css yang baru -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <nav class="navbar">
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="{{ url('/') }}" style="color: white; text-decoration: none; font-weight: 800; font-size: 1.25rem; letter-spacing: -0.02em;">
                <span class="text-gradient">Viberlink</span> LMS
            </a>
            @auth
                @if(Auth::user()->role === 'Peserta')
                    <div style="position: relative; display: inline-block;" class="dropdown-wrapper">
                        <span style="color: var(--text-secondary); cursor: pointer; padding: 5px 0; font-weight: 500;">Modul Tersedia ▼</span>
                        <div class="dropdown-menu glass-panel" style="display: none; position: absolute; min-width: 180px; z-index: 100; top: 100%; left: 0; padding: 0.5rem; margin-top: 10px;">
                            <a href="{{ route('peserta.modul.detail', 'olt') }}" class="sidebar-link" style="margin-bottom: 2px;">Modul OLT</a>
                            <a href="{{ route('peserta.modul.detail', 'odc') }}" class="sidebar-link" style="margin-bottom: 2px;">Modul ODC</a>
                            <a href="{{ route('peserta.modul.detail', 'odp') }}" class="sidebar-link" style="margin-bottom: 2px;">Modul ODP</a>
                            <a href="{{ route('peserta.modul.detail', 'ont') }}" class="sidebar-link" style="margin-bottom: 2px;">Modul ONT</a>
                            <a href="{{ route('peserta.modul.detail', 'kabel') }}" class="sidebar-link" style="margin-bottom: 0;">Modul Splicing</a>
                        </div>
                    </div>
                    <style>
                        .dropdown-wrapper:hover .dropdown-menu { display: block !important; animation: fadeIn 0.2s ease-out; }
                    </style>
                @endif
            @endauth
        </div>
        <div>
            @auth
                <span style="margin-right: 15px; color: var(--text-secondary); font-size: 0.95rem;">
                    Halo, <span style="color: var(--text-primary); font-weight: 600;">{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</span>
                </span>
                @if(Auth::user()->role === 'Admin')
                    <a href="{{ route('admin.dashboard') }}" style="color: var(--primary); text-decoration: none; margin-right: 20px; font-weight: 600;">Ruang Admin</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="border-color: var(--danger); color: var(--danger); padding: 0.4rem 1rem;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Masuk / Login</a>
            @endauth
        </div>
    </nav>

    <main style="display: flex; flex-direction: column; flex: 1; width: 100%;">
        @yield('content')
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
