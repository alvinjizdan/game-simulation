<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - ViberLink LMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            height: 100%;
            background-color: #0F0F0F;
            overflow: hidden;
        }
        
        .bg-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(135deg, #0F0F0F 0%, #1A1A1A 50%, #050505 100%);
            z-index: 1;
        }

        /* Geometric Abstract Shapes with subtle red accents */
        .shape-1 {
            position: absolute;
            top: -20%;
            left: -10%;
            width: 60%;
            height: 150%;
            background: rgba(255, 0, 0, 0.02);
            transform: rotate(30deg);
            border-right: 1px solid rgba(255, 0, 0, 0.05);
        }
        .shape-2 {
            position: absolute;
            bottom: -30%;
            left: 20%;
            width: 50%;
            height: 150%;
            background: rgba(0, 0, 0, 0.5);
            transform: rotate(-45deg);
            border-left: 1px solid rgba(255, 255, 255, 0.03);
        }
        .shape-3 {
            position: absolute;
            top: 20%;
            right: -10%;
            width: 40%;
            height: 100%;
            background: rgba(255, 0, 0, 0.01);
            transform: rotate(15deg);
        }

        .main-content {
            position: relative;
            z-index: 10;
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        .left-section {
            flex: 1;
            position: relative;
            padding: 40px 60px 60px 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }
        .logo-icon {
            background: #FF0000;
            color: #FFFFFF;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 18px;
        }
        .logo-text {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .hero-text {
            max-width: 500px;
            margin-bottom: 20px;
        }
        .hero-title {
            color: white;
            font-size: 42px;
            font-weight: 700;
            margin: 0 0 16px 0;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .hero-subtitle {
            color: #AAAAAA;
            font-size: 16px;
            line-height: 1.6;
            margin: 0;
        }

        .right-section {
            display: flex; align-items: flex-start; justify-content: flex-end; padding: 60px 60px 40px 40px;
        }

        .auth-card {
            width: 100%;
            min-width: 420px;
            max-width: 480px;
            background: #FFFFFF;
            border-radius: 16px;
            padding: 48px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .form-input {
            width: 100%;
            height: 48px;
            padding: 0 16px;
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            border-radius: 8px;
            font-size: 15px;
            color: #0F0F0F;
            outline: none;
            transition: 0.2s;
            box-sizing: border-box;
        }
        .form-input:focus {
            border: 1px solid #0F0F0F;
        }
        .btn-submit {
            width: 100%;
            background: #FF0000;
            color: #FFFFFF;
            height: 48px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #CC0000;
        }

        @media (max-width: 1024px) {
            .left-section {
                display: none;
            }
            .right-section {
                flex: 1;
                justify-content: center;
                padding: 20px;
            }
            .auth-card {
                min-width: auto;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="bg-container">
    <div class="shape-1"></div>
    <div class="shape-2"></div>
    <div class="shape-3"></div>
</div>

<div class="main-content">
    <!-- Panel Kiri (Branding) -->
    <div class="left-section">
        <div class="logo-area">
            <div class="logo-icon">V</div>
            <div class="logo-text">ViberLink</div>
        </div>

        <div class="hero-text">
            <h1 class="hero-title">
                Pelajari Lebih Dalam.<br>Praktik Lebih Cepat.<br>Sertifikasi Kapan Saja.
            </h1>
            <p class="hero-subtitle">
                Dari materi jaringan dasar hingga perhitungan Link Power Budget, platform kami memungkinkan Anda belajar secara interaktif di mana saja.
            </p>
        </div>
    </div>

    <!-- Panel Kanan (Form) -->
    <div class="right-section">
        <!-- Box Form tetap mempertahankan struktur sebelumnya -->
        <div class="auth-card">
            <div style="margin-bottom: 40px;">
                <h2 style="margin: 0 0 8px 0; font-size: 32px; font-weight: 700; color: #0F0F0F;">Selamat Datang!</h2>
                <p style="margin: 0; font-size: 15px; font-weight: 400; color: #606060;">Masuk ke akun Anda untuk mulai belajar.</p>
            </div>
            
            @if($errors->any())
                <div style="background: rgba(255, 0, 0, 0.05); color: #FF0000; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; font-size: 14px; font-weight: 500; border-left: 4px solid #FF0000;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #0F0F0F; margin-bottom: 8px;">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus class="form-input">
                </div>

                <div style="margin-bottom: 32px;">
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #0F0F0F; margin-bottom: 8px;">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" required class="form-input">
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" id="remember" style="width: 16px; height: 16px; border-radius: 4px; border: 1px solid #E5E5E5; cursor: pointer;">
                        <label for="remember" style="font-size: 14px; color: #606060; cursor: pointer; user-select: none;">Ingat Saya</label>
                    </div>
                    <a href="#" style="color: #606060; font-size: 14px; text-decoration: none;">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>


