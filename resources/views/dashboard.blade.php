@extends('layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan aktivitas perpustakaan')
@section('content')

<style>
.dashboard-grid {
    display: grid;
    gap: 1.5rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 18px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
    border-color: #cbd5e1;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.stat-card.books::before { background: #0284c7; }
.stat-card.pending::before { background: #d97706; }
.stat-card.active::before { background: #059669; }

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.25rem;
}

.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.icon-info { background: #e0f2fe; color: #0284c7; }
.icon-warning { background: #fef3c7; color: #d97706; }
.icon-success { background: #d1fae5; color: #059669; }

.stat-value {
    font-size: 2.25rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
    letter-spacing: -1px;
}

.stat-label {
    color: #64748b;
    font-weight: 500;
    font-size: 0.95rem;
    margin-top: 0.5rem;
}

.info-panel {
    background: rgba(255, 255, 255, 0.92);
    border-radius: 18px;
    padding: 1.35rem 1.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
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
.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
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
