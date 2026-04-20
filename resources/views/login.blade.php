@extends('layouts.app')
@section('title', 'Masuk')
@section('subtitle', 'Akses ke perpustakaan digital')
@section('content')

<style>
.auth-wrap {
    position: relative;
    max-width: 680px;
    margin: 0 auto;
    padding: 0.75rem 0 1rem;
    min-height: calc(100vh - 220px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 1rem;
}

.auth-panel {
    width: min(100%, 540px);
    aspect-ratio: 1 / 1;
    margin: 0 auto;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    overflow: hidden;
    background:
        radial-gradient(circle at 28% 24%, rgba(91, 93, 246, 0.16), transparent 30%),
        radial-gradient(circle at 72% 78%, rgba(6, 182, 212, 0.14), transparent 26%),
        rgba(255, 255, 255, 0.48);
    backdrop-filter: blur(24px) saturate(1.08);
    border: 1px solid rgba(226, 232, 240, 0.84);
    box-shadow: 0 26px 72px rgba(15, 23, 42, 0.11);
}

.auth-panel::before,
.auth-panel::after {
    content: '';
    position: absolute;
    inset: 10%;
    border-radius: 50%;
    pointer-events: none;
}

.auth-panel::before {
    border: 1px solid rgba(255, 255, 255, 0.36);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.10);
}

.auth-panel::after {
    inset: 18%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.20), transparent 68%);
    filter: blur(14px);
}

.auth-panel-body {
    width: min(100%, 360px);
    padding: 0;
    position: relative;
    z-index: 1;
}

.auth-icon {
    width: 78px;
    height: 78px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #5b5df6, #2563eb);
    color: #fff;
    font-size: 1.7rem;
    box-shadow: 0 16px 32px rgba(91, 93, 246, 0.22);
}

.auth-panel .btn {
    border-radius: 999px;
}

.auth-panel .input-group {
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid rgba(226, 232, 240, 0.88);
    background: rgba(255, 255, 255, 0.72);
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04);
}

.auth-panel .input-group-text {
    background: transparent;
    border: none;
    color: var(--primary);
}

.auth-panel .soft-input {
    border: none;
    background: transparent;
}

.auth-panel .soft-input:focus {
    box-shadow: none;
}

.auth-panel .toggle-password {
    cursor: pointer;
    color: var(--text-muted);
}

.auth-panel .alert {
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.68);
    backdrop-filter: blur(12px);
}

@media (max-width: 991.98px) {
    .auth-panel {
        width: 100%;
        aspect-ratio: auto;
        border-radius: 34px;
        padding: 1.25rem 1rem;
    }

    .auth-panel::before,
    .auth-panel::after {
        border-radius: 34px;
    }

    .auth-panel-body {
        width: 100%;
        padding: 0.25rem 0.15rem;
    }
}

@media (max-width: 575.98px) {
    .auth-wrap {
        padding-inline: 0.25rem;
        min-height: auto;
    }

    .auth-icon {
        width: 72px;
        height: 72px;
        font-size: 1.55rem;
    }
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
