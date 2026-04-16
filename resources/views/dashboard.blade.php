@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<style>
.dashboard-wrapper {
    min-height: 100vh;
    background:
        radial-gradient(circle at top right, rgba(179, 139, 89, 0.15), transparent 24%),
        radial-gradient(circle at bottom left, rgba(53, 95, 82, 0.15), transparent 22%),
        linear-gradient(135deg, #f8f2e8 0%, #f4ede1 48%, #f8f5ee 100%);
    padding: 2rem 0;
    position: relative;
    overflow: hidden;
}
.dashboard-wrapper::before,
.dashboard-wrapper::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(179, 139, 89, 0.1) 0%, transparent 70%);
    animation: float 20s infinite ease-in-out;
}
.dashboard-wrapper::before { width: 500px; height: 500px; top: -10%; right: -5%; }
.dashboard-wrapper::after  { width: 400px; height: 400px; bottom: -5%; left: -5%; background: radial-gradient(circle, rgba(53, 95, 82, 0.08) 0%, transparent 70%); animation-direction: reverse; animation-duration: 25s; }
@keyframes float { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(-15px,15px) scale(1.03)} }
.header-section {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(14px);
    border-radius: 20px;
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(231, 218, 199, 0.9);
    box-shadow: 0 14px 34px rgba(66, 49, 30, 0.08);
}
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
}
.role-admin { background: linear-gradient(135deg, #f0e2ca, #e4c08e); color: #7a4e1f; }
.role-user  { background: linear-gradient(135deg, #dbe9df, #c9ddd1); color: #2f5a4e; }
.stat-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 1.5rem;
    border: 1px solid #e7dac7;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    position: relative;
    overflow: hidden;
    display: block;
}
.stat-card:hover { transform: translateY(-6px); box-shadow: 0 12px 28px rgba(92,72,47,0.08); border-color: #d8c2a2; }
.stat-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    border-radius: 0 4px 4px 0;
}
.stat-card.books::after   { background: linear-gradient(180deg, #355f52, #25463c); }
.stat-card.pending::after { background: linear-gradient(180deg, #b38b59, #8d6735); }
.stat-card.active::after  { background: linear-gradient(180deg, #4a7c59, #355f52); }
.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    margin-bottom: 1rem;
}
.icon-blue  { background: #e7efe9; color: #355f52; }
.icon-amber { background: #f8efde; color: #9a6a2d; }
.icon-green { background: #e9f3ed; color: #3f6a4c; }
.stat-value { font-size: 2.25rem; font-weight: 800; color: #0f172a; line-height: 1; margin-bottom: 0.3rem; letter-spacing: -0.5px; }
.stat-label { color: #64748b; font-weight: 500; font-size: 0.95rem; }
.action-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    text-decoration: none;
    color: inherit;
    border: 1px solid #e7dac7;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(92,72,47,0.06);
    border-color: #d8c2a2;
    background: linear-gradient(135deg, #ffffff 0%, #fbf6ee 100%);
}
.action-card .icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
.icon-purple { background: #f1e7d7; color: #8b6233; }
.icon-sky    { background: #e8f0eb; color: #355f52; }
.section-title { font-weight: 700; color: #0f172a; margin-bottom: 1rem; }
.fade-in-up { animation: fadeInUp 0.6s ease-out both; }
.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="dashboard-wrapper">
    <div class="container">
        <div class="header-section d-flex flex-wrap justify-content-between align-items-center fade-in-up">
            <div>
                <h2 class="fw-bold mb-1 text-dark">Selamat Datang di <span style="color:#7b5a35;">Aii Library</span></h2>
                <p class="text-muted mb-0">Dashboard utama untuk mengelola perpustakaan</p>
            </div>
            <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                @php $role = session('user.role', 'user'); @endphp
                <span class="role-badge {{ $role == 'admin' ? 'role-admin' : 'role-user' }}">
                    <i class="bi {{ $role == 'admin' ? 'bi-shield-lock' : 'bi-person' }}"></i>
                    {{ $role == 'admin' ? 'Administrator' : 'Pengguna' }}
                </span>
                <span class="text-muted fw-medium">{{ now()->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4 fade-in-up delay-1">
                <div class="stat-card books h-100">
                    <div class="icon-box icon-blue"><i class="bi bi-journals"></i></div>
                    <div class="stat-value">{{ number_format($books ?? 0) }}</div>
                    <div class="stat-label">Total Koleksi Buku</div>
                </div>
            </div>
            @if($role == 'user')
            <div class="col-md-4 fade-in-up delay-2">
                <a href="{{ route('peminjaman') }}" class="stat-card pending h-100">
                    <div class="icon-box icon-amber"><i class="bi bi-bookmark-check"></i></div>
                    <div class="stat-value" style="color:#9a6a2d;">{{ $pendingLoans ?? 0 }}</div>
                    <div class="stat-label">Peminjaman Pending</div>
                </a>
            </div>
            <div class="col-md-4 fade-in-up delay-3">
                <a href="{{ route('pengembalian') }}" class="stat-card active h-100">
                    <div class="icon-box icon-green"><i class="bi bi-arrow-repeat"></i></div>
                    <div class="stat-value" style="color:#3f6a4c;">{{ $activeLoans ?? 0 }}</div>
                    <div class="stat-label">Peminjaman Aktif</div>
                </a>
            </div>
            @endif
            @if($role == 'admin')
            <div class="col-md-4 fade-in-up delay-2">
                <a href="{{ route('admin.loans') }}" class="stat-card pending h-100">
                    <div class="icon-box icon-amber"><i class="bi bi-journal-check"></i></div>
                    <div class="stat-value" style="color:#9a6a2d;">{{ $pendingApprovals ?? 0 }}</div>
                    <div class="stat-label">Menunggu Persetujuan</div>
                </a>
            </div>
            @endif
        </div>

        <h4 class="section-title fade-in-up delay-2">Aksi Cepat</h4>
        <div class="row g-3 mb-4">
            @if($role == 'user')
            <div class="col-lg-4 col-md-6 fade-in-up delay-3">
                <a href="{{ route('peminjaman') }}" class="action-card">
                    <div class="icon-circle icon-purple"><i class="bi bi-journal-arrow-up"></i></div>
                    <div>
                        <div class="fw-bold text-dark">Ajukan Peminjaman</div>
                        <small class="text-muted">Lihat katalog dan pinjam buku</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 fade-in-up delay-3">
                <a href="{{ route('pengembalian') }}" class="action-card">
                    <div class="icon-circle icon-green"><i class="bi bi-arrow-counterclockwise"></i></div>
                    <div>
                        <div class="fw-bold text-dark">Pengembalian</div>
                        <small class="text-muted">Kembalikan buku tepat waktu</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>
            @endif
            <div class="col-lg-4 col-md-6 fade-in-up delay-2">
                <a href="{{ route('profile') }}" class="action-card">
                    <div class="icon-circle icon-sky"><i class="bi bi-person-badge"></i></div>
                    <div>
                        <div class="fw-bold text-dark">Profil Saya</div>
                        <small class="text-muted">Lihat data akun dan role</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>
            @if($role == 'admin')
            <div class="col-lg-4 col-md-6 fade-in-up delay-2">
                <a href="{{ route('admin.books') }}" class="action-card">
                    <div class="icon-circle icon-purple"><i class="bi bi-journals"></i></div>
                    <div>
                        <div class="fw-bold text-dark">Kelola Buku</div>
                        <small class="text-muted">Tambah, edit dan hapus koleksi</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 fade-in-up delay-3">
                <a href="{{ route('admin.loans') }}" class="action-card">
                    <div class="icon-circle icon-sky"><i class="bi bi-clipboard-data"></i></div>
                    <div>
                        <div class="fw-bold text-dark">Verifikasi Peminjaman</div>
                        <small class="text-muted">Setujui dan tolak request user</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
