@extends('layouts.app')
@section('title', 'Daftar')
@section('subtitle', 'Buat akun baru untuk akses perpustakaan')
@section('content')

<style>
.auth-wrap {
    max-width: 520px;
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
            <i class="bi bi-person-plus"></i>
            Registrasi
        </div>
        <h1 class="page-hero-title">Daftar Akun Baru</h1>
        <p class="page-hero-subtitle mx-auto">Buat akun untuk mulai menggunakan katalog dan fitur peminjaman buku.</p>
    </div>

    <div class="auth-panel">
        <div class="auth-panel-body">
            <div class="text-center mb-4">
                <div class="auth-icon mx-auto mb-3">
                    <i class="bi bi-person-vcard"></i>
                </div>
                <h2 class="fw-bold mb-1">Buat Akun</h2>
                <p class="soft-text mb-0">Daftar untuk masuk ke ruang baca digital perpustakaan.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success rounded-4 mb-3">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-4 mb-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control soft-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-paper"></i></span>
                        <input type="email" class="form-control soft-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control soft-input @error('password') is-invalid @enderror" name="password" id="regPassword" placeholder="Minimal 4 karakter" required minlength="4">
                        <span class="input-group-text toggle-password" onclick="togglePassword('regPassword', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" class="form-control soft-input @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="regConfirmPassword" placeholder="Ulangi password" required>
                        <span class="input-group-text toggle-password" onclick="togglePassword('regConfirmPassword', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="text-center pt-3 mt-3 border-top">
                <p class="soft-text mb-0">Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Masuk di sini</a>
                </p>
            </div>
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
