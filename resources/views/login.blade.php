@extends('layouts.app')
@section('title', 'Masuk')
@section('subtitle', 'Akses ke perpustakaan digital')
@section('content')

<style>
.auth-wrap {
    max-width: 480px;
    margin: 0 auto;
}

.auth-panel {
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid var(--border-soft);
    border-radius: 24px;
    box-shadow: var(--shell-shadow);
    overflow: hidden;
}

.auth-panel-body {
    padding: 1.75rem;
}

.auth-icon {
    width: 76px;
    height: 76px;
    border-radius: 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4f46e5, #2563eb);
    color: #fff;
    font-size: 2rem;
    box-shadow: 0 12px 24px rgba(79, 70, 229, 0.24);
}
</style>

<div class="auth-wrap fade-in-up">
    <div class="page-hero text-center">
        <div class="page-hero-kicker mx-auto">
            <i class="bi bi-door-open"></i>
            Login
        </div>
        <h1 class="page-hero-title">Masuk ke Aii Library</h1>
        <p class="page-hero-subtitle mx-auto">Gunakan akun Anda untuk masuk ke dashboard perpustakaan digital.</p>
    </div>

    <div class="auth-panel">
        <div class="auth-panel-body">
            <div class="text-center mb-4">
                <div class="auth-icon mx-auto mb-3">
                    <i class="bi bi-journal-richtext"></i>
                </div>
                <h2 class="fw-bold mb-1">Selamat Datang</h2>
                <p class="soft-text mb-0">Masuk untuk melanjutkan ke dashboard Anda.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-3">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-4 mb-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-paper"></i></span>
                        <input type="email" class="form-control soft-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control soft-input @error('password') is-invalid @enderror" name="password" id="loginPassword" placeholder="Masukkan password" required>
                        <span class="input-group-text toggle-password" onclick="togglePassword('loginPassword', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-door-open me-2"></i>Masuk
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    icon.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
}
</script>
@endsection
