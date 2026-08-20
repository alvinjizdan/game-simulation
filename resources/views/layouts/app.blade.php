<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ViberLink LMS</title>
    <!-- CSS di-link ke style.css yang baru -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <nav class="navbar glass-panel">
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="{{ url('/') }}" style="color: white; text-decoration: none; font-weight: 800; font-size: 1.75rem; letter-spacing: -0.02em;">
                <span style="color: var(--primary);">ViberLink</span>
            </a>
        </div>

        <div style="display: flex; align-items: center; gap: 15px;">
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
