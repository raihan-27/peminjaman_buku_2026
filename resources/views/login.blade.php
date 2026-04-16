@extends('layouts.app')
@section('title', 'Masuk')
@section('content')

<style>
.auth-wrapper {
    min-height: 100vh;
    background:
        radial-gradient(circle at top right, rgba(179, 139, 89, 0.2), transparent 25%),
        radial-gradient(circle at bottom left, rgba(53, 95, 82, 0.18), transparent 22%),
        linear-gradient(135deg, #f8f2e7 0%, #f3eadc 46%, #f9f6ef 100%);
    position: relative;
    overflow: hidden;
}
.auth-wrapper::before {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(83, 121, 103, 0.18) 0%, transparent 70%);
    top: -10%;
    right: -10%;
    border-radius: 50%;
    animation: float 25s infinite ease-in-out;
}
.auth-wrapper::after {
    content: '';
    position: absolute;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(179, 139, 89, 0.16) 0%, transparent 70%);
    bottom: -5%;
    left: -5%;
    border-radius: 50%;
    animation: float 20s infinite ease-in-out reverse;
}
@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(-20px, 20px) scale(1.05); }
}
.glass-card {
    background: rgba(255, 252, 247, 0.84);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(231, 218, 199, 0.9);
    box-shadow: 0 24px 50px rgba(63, 49, 32, 0.12);
    border-radius: 28px;
    animation: fadeInUp 0.6s ease-out;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.auth-icon {
    width: 76px;
    height: 76px;
    border-radius: 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e8d2b1, #b38b59);
    color: #fff8ec;
    font-size: 2rem;
    box-shadow: 0 10px 22px rgba(179, 139, 89, 0.3);
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
.form-control {
    border-left: none;
    border-radius: 0 14px 14px 0;
}
.input-group:focus-within .input-group-text {
    border-color: #355f52;
}
.btn-auth {
    background: linear-gradient(135deg, #355f52, #25463c);
    border: none;
    border-radius: 16px;
    padding: 0.95rem;
    font-weight: 700;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(53, 95, 82, 0.28);
}
.toggle-password {
    cursor: pointer;
    color: #64748b;
    transition: color 0.2s;
}
.toggle-password:hover {
    color: #355f52;
}
.auth-copy {
    color: #7b7468;
}
</style>

<div class="auth-wrapper d-flex align-items-center justify-content-center p-3">
    <div class="card glass-card w-100" style="max-width: 440px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="auth-icon mx-auto mb-3">
                    <i class="bi bi-journal-richtext"></i>
                </div>
                <h2 class="fw-bold mb-1 text-dark">Masuk ke Aii Library</h2>
                <p class="auth-copy mb-0">Masuk untuk menjelajahi koleksi dan aktivitas perpustakaan.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-medium text-secondary">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-paper"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="loginPassword" placeholder="Masukkan password" required>
                        <span class="input-group-text toggle-password" onclick="togglePassword('loginPassword', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-auth text-white">
                        <i class="bi bi-door-open me-2"></i>Masuk
                    </button>
                </div>
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
