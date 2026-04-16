@extends('layouts.app')
@section('title', 'Daftar')
@section('content')

<style>
.auth-wrapper {
    min-height: 100vh;
    background:
        radial-gradient(circle at top left, rgba(179, 139, 89, 0.18), transparent 24%),
        radial-gradient(circle at bottom right, rgba(53, 95, 82, 0.17), transparent 24%),
        linear-gradient(135deg, #f8f2e7 0%, #f3eadc 46%, #f9f6ef 100%);
    position: relative;
    overflow: hidden;
}
.auth-wrapper::before,
.auth-wrapper::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    animation: float 22s ease-in-out infinite;
}
.auth-wrapper::before {
    width: 520px;
    height: 520px;
    top: -10%;
    right: -10%;
    background: radial-gradient(circle, rgba(179, 139, 89, 0.15) 0%, transparent 70%);
}
.auth-wrapper::after {
    width: 420px;
    height: 420px;
    bottom: -6%;
    left: -6%;
    background: radial-gradient(circle, rgba(53, 95, 82, 0.16) 0%, transparent 70%);
    animation-direction: reverse;
}
@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(-16px, 16px) scale(1.04); }
}
.glass-card {
    background: rgba(255, 252, 247, 0.86);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(231, 218, 199, 0.9);
    box-shadow: 0 24px 50px rgba(63, 49, 32, 0.12);
    border-radius: 28px;
    animation: fadeInUp 0.6s ease-out;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(18px); }
    to { opacity: 1; transform: translateY(0); }
}
.auth-icon {
    width: 76px;
    height: 76px;
    border-radius: 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #355f52, #25463c);
    color: #fff8ec;
    font-size: 2rem;
    box-shadow: 0 10px 22px rgba(53, 95, 82, 0.28);
}
.form-control {
    background: #fffdf9;
    border: 1px solid #e7dac7;
    border-radius: 14px;
    padding: 0.75rem 1rem;
    transition: all 0.25s ease;
}
.form-control:focus {
    background: #ffffff;
    border-color: #355f52;
    box-shadow: 0 0 0 4px rgba(53, 95, 82, 0.12);
}
.input-group-text {
    background: transparent;
    border: 1px solid #e7dac7;
    border-right: none;
    border-radius: 14px 0 0 14px;
    color: #8b6d46;
}
.form-control { border-left: none; border-radius: 0 14px 14px 0; }
.input-group:focus-within .input-group-text { border-color: #355f52; }
.btn-auth {
    border: none;
    border-radius: 16px;
    padding: 0.95rem;
    font-weight: 700;
    transition: all 0.3s ease;
}
.btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(53, 95, 82, 0.24);
}
.toggle-password {
    cursor: pointer;
    color: #6d6f68;
    transition: color 0.2s ease;
}
.toggle-password:hover { color: #355f52; }
.auth-copy { color: #7b7468; }
</style>

<div class="auth-wrapper d-flex align-items-center justify-content-center p-3">
    <div class="card glass-card w-100" style="max-width: 480px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="auth-icon mx-auto mb-3">
                    <i class="bi bi-person-vcard"></i>
                </div>
                <h2 class="fw-bold mb-1 text-dark">Buat Akun Baru</h2>
                <p class="auth-copy mb-0">Daftar untuk masuk ke ruang baca digital perpustakaan.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success rounded-3 mb-3">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">
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
                    <label class="form-label fw-medium text-secondary">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-paper"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="regPassword" placeholder="Minimal 4 karakter" required minlength="4">
                        <span class="input-group-text toggle-password" onclick="togglePassword('regPassword', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium text-secondary">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="regConfirmPassword" placeholder="Ulangi password" required>
                        <span class="input-group-text toggle-password" onclick="togglePassword('regConfirmPassword', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success btn-auth text-white" style="background: linear-gradient(135deg, #b38b59, #7b5a35);">
                        <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="text-center pt-2 border-top">
                <p class="text-muted mb-0">Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#355f52;">Masuk di sini</a>
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
