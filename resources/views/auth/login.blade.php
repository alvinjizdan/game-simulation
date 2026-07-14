@extends('layouts.app')
@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
    <div class="card" style="width: 100%; max-width: 400px; padding: 2rem;">
        <h2 style="text-align: center; margin-top: 0;">Portal Login</h2>
        <p style="text-align: center; color: #94a3b8; margin-bottom: 2rem;">Masuk ke Ruang Kendali Admin</p>
        
        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #ef4444;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">Login</button>
        </form>
    </div>
</div>
@endsection
