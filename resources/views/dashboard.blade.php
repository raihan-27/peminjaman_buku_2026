@extends('layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan aktivitas perpustakaan')
@section('content')

<style>
.dashboard-grid {
    display: grid;
    gap: 1.45rem;
}

.stat-card {
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.56), rgba(255, 255, 255, 0.40));
    backdrop-filter: blur(22px) saturate(1.06);
    border-radius: 28px;
    padding: 1.5rem;
    border: 1px solid rgba(226, 232, 240, 0.84);
    box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
    transition: transform 0.26s ease, box-shadow 0.26s ease, border-color 0.26s ease;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 28px 60px rgba(15, 23, 42, 0.12);
    border-color: rgba(191, 219, 254, 0.80);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    opacity: 0.95;
}

.stat-card.books::before { background: linear-gradient(90deg, #2563eb, #06b6d4); }
.stat-card.pending::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
.stat-card.active::before { background: linear-gradient(90deg, #0f9d68, #10b981); }

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.icon-box {
    width: 54px;
    height: 54px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.45rem;
    backdrop-filter: blur(12px);
}

.icon-info { background: rgba(224, 242, 254, 0.82); color: #0284c7; }
.icon-warning { background: rgba(254, 243, 199, 0.82); color: #d97706; }
.icon-success { background: rgba(209, 250, 229, 0.82); color: #0f9d68; }

.stat-value {
    font-size: 2.7rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
    letter-spacing: -0.06em;
}

.stat-label {
    color: #64748b;
    font-weight: 600;
    font-size: 0.95rem;
    margin-top: 0.55rem;
}

.info-panel {
    background:
        linear-gradient(135deg, rgba(255, 255, 255, 0.54), rgba(255, 255, 255, 0.40));
    backdrop-filter: blur(22px) saturate(1.04);
    border-radius: 28px;
    padding: 1.45rem 1.6rem;
    border: 1px solid rgba(226, 232, 240, 0.84);
    box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
}

.info-panel h5 {
    color: #0f172a;
    font-weight: 700;
}

.info-panel p {
    color: #64748b;
    margin-bottom: 0;
}

.fade-in-up { animation: fadeInUp 0.5s ease-out both; }
.delay-1 { animation-delay: 0.04s; }
.delay-2 { animation-delay: 0.08s; }
.delay-3 { animation-delay: 0.12s; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .stat-value {
        font-size: 2.35rem;
    }

    .info-panel {
        padding: 1.25rem 1.25rem;
    }
}
</style>

@php
    $role = session('user.role', 'user');
    $isAdmin = $role === 'admin';
@endphp

<div class="dashboard-grid">
    <div class="row g-4">
        <div class="{{ $isAdmin ? 'col-md-6' : 'col-md-4' }} fade-in-up delay-1">
            <div class="stat-card books">
                <div class="stat-header">
                    <div class="icon-box icon-info"><i class="bi bi-journals"></i></div>
                </div>
                <div>
                    <div class="stat-value">{{ number_format($books ?? 0) }}</div>
                    <div class="stat-label">Total Koleksi Buku</div>
                </div>
            </div>
        </div>

        @if($isAdmin)
            <div class="col-md-6 fade-in-up delay-2">
                <div class="stat-card pending">
                    <div class="stat-header">
                        <div class="icon-box icon-warning"><i class="bi bi-clipboard-check"></i></div>
                    </div>
                    <div>
                        <div class="stat-value">{{ $pendingApprovals ?? 0 }}</div>
                        <div class="stat-label">Menunggu Persetujuan</div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-4 fade-in-up delay-2">
                <div class="stat-card pending">
                    <div class="stat-header">
                        <div class="icon-box icon-warning"><i class="bi bi-hourglass-split"></i></div>
                    </div>
                    <div>
                        <div class="stat-value">{{ $pendingLoans ?? 0 }}</div>
                        <div class="stat-label">Peminjaman Pending</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 fade-in-up delay-3">
                <div class="stat-card active">
                    <div class="stat-header">
                        <div class="icon-box icon-success"><i class="bi bi-book"></i></div>
                    </div>
                    <div>
                        <div class="stat-value">{{ $activeLoans ?? 0 }}</div>
                        <div class="stat-label">Peminjaman Aktif</div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="info-panel fade-in-up delay-2">
        @if($isAdmin)
            <h5 class="mb-2">Akses cepat untuk admin</h5>
            <p>Gunakan sidebar kiri untuk membuka kelola buku, memproses peminjaman, atau kembali ke dashboard kapan saja.</p>
        @else
            <h5 class="mb-2">Akses cepat untuk pengguna</h5>
            <p>Gunakan sidebar kiri untuk melihat buku, mengajukan peminjaman, dan mengembalikan buku yang sudah dipinjam.</p>
        @endif
    </div>
</div>
@endsection
