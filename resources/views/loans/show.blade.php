@extends('layouts.app')

@section('title', 'Detail Peminjaman')
@section('subtitle', 'Informasi lengkap satu transaksi peminjaman')

@section('content')
<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-journal-text"></i>
                Detail
            </div>
            <h1 class="page-hero-title">Peminjaman #{{ $loan->id }}</h1>
            <p class="page-hero-subtitle">Lihat detail buku, anggota, status, dan langkah lanjutan dari transaksi ini.</p>
        </div>
        <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="surface-card fade-in-up delay-1">
            <div class="surface-card-header">
                <h5 class="mb-0">Rincian Transaksi</h5>
            </div>
            <div class="surface-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Buku</div>
                            <div class="fw-semibold">{{ $loan->book->title }}</div>
                            <small class="soft-text">{{ $loan->book->author }}</small>
                            <div class="soft-text mt-2">{{ $loan->book->publisher }} • {{ $loan->book->year }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Anggota</div>
                            <div class="fw-semibold">{{ $loan->member->name }}</div>
                            <small class="soft-text d-block">{{ $loan->member->phone }}</small>
                            <div class="soft-text mt-2">{{ $loan->member->address }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-card h-100">
                            <div class="metric-label">Tgl Pinjam</div>
                            <div class="fw-semibold">{{ $loan->loan_date->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-card h-100">
                            <div class="metric-label">Batas Kembali</div>
                            <div class="fw-semibold {{ $loan->due_date < now()->format('Y-m-d') ? 'text-danger' : '' }}">
                                {{ $loan->due_date->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    @if($loan->return_date)
                        <div class="col-md-3">
                            <div class="metric-card h-100">
                                <div class="metric-label">Tgl Dikembalikan</div>
                                <div class="fw-semibold text-success">{{ $loan->return_date->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-card h-100">
                                <div class="metric-label">Denda</div>
                                <div class="fw-semibold {{ $loan->fine > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $loan->fine > 0 ? 'Rp ' . number_format($loan->fine) : 'Gratis' }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="surface-card fade-in-up delay-2 h-100">
            <div class="surface-card-header">
                <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="surface-card-body">
                <div class="d-grid gap-2">
                    @if(!$loan->return_date)
                        <a href="{{ route('loans.returnForm', $loan) }}" class="btn btn-success">
                            <i class="bi bi-arrow-return-left me-2"></i>Kembalikan
                        </a>
                    @endif
                    <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-grid" onsubmit="return confirm('Hapus peminjaman ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
