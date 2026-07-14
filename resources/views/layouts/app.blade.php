<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Viberlink Fiber Optic System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem; background: var(--navy); border-bottom: 1px solid var(--navy-light);">
        <div class="logo" style="display: flex; gap: 15px; align-items: center;">
            <a href="{{ url('/') }}" style="color: white; text-decoration: none; font-weight: bold; font-size: 1.2rem;">Viberlink Edu</a>
            @auth
                @if(Auth::user()->role === 'Peserta')
                    <div style="position: relative; display: inline-block;" class="dropdown-wrapper">
                        <span style="color: var(--secondary); cursor: pointer; padding: 5px 0;">Kategori Misi ▼</span>
                        <div class="dropdown-menu" style="display: none; position: absolute; background: white; min-width: 150px; box-shadow: 0 8px 16px rgba(0,0,0,0.2); z-index: 100; border-radius: 4px; top: 100%; left: 0;">
                            <a href="{{ route('simulasi.game', 'olt') }}" style="color: var(--navy); padding: 10px 15px; text-decoration: none; display: block; border-bottom: 1px solid #e2e8f0;">Modul OLT</a>
                            <a href="{{ route('simulasi.game', 'odc') }}" style="color: var(--navy); padding: 10px 15px; text-decoration: none; display: block; border-bottom: 1px solid #e2e8f0;">Modul ODC</a>
                            <a href="{{ route('simulasi.game', 'odp') }}" style="color: var(--navy); padding: 10px 15px; text-decoration: none; display: block; border-bottom: 1px solid #e2e8f0;">Modul ODP</a>
                            <a href="{{ route('simulasi.game', 'ont') }}" style="color: var(--navy); padding: 10px 15px; text-decoration: none; display: block; border-bottom: 1px solid #e2e8f0;">Modul ONT</a>
                            <a href="{{ route('simulasi.game', 'kabel') }}" style="color: var(--navy); padding: 10px 15px; text-decoration: none; display: block;">Modul Splicing</a>
                        </div>
                    </div>
                    <style>
                        .dropdown-wrapper:hover .dropdown-menu { display: block !important; }
                        .dropdown-menu a:hover { background: #f1f5f9; }
                    </style>
                @endif
            @endauth
        </div>
        <div>
            @auth
                <span style="margin-right: 15px; color: white;">Halo, {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</span>
                @if(Auth::user()->role === 'Admin')
                    <a href="{{ route('admin.dashboard') }}" style="color: var(--secondary); text-decoration: none; margin-right: 15px; font-weight: bold;">Ruang Admin</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn" style="background: #ef4444; border: none; padding: 5px 15px; font-size: 0.9rem; color: white;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn" style="background: var(--primary); color: white;">Login</a>
            @endauth
        </div>
    </nav>

    <main style="display: flex; flex-direction: column; flex: 1;">
        @yield('content')
    </main>

    <footer style="background: var(--navy); color: #cbd5e1; text-align: center; padding: 1.5rem; border-top: 1px solid var(--navy-light); font-size: 0.9rem;">
        &copy; {{ date('Y') }} PT Khatulistiwa Jaringan Indonesia (Viberlink). Seluruh hak cipta dilindungi.
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
