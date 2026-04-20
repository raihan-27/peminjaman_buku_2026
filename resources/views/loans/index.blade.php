@extends('layouts.app')

@section('title', 'Peminjaman')
@section('subtitle', 'Monitoring seluruh transaksi peminjaman')

@section('content')
<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-journal-text"></i>
                Transaksi
            </div>
            <h1 class="page-hero-title">Daftar Peminjaman</h1>
            <p class="page-hero-subtitle">Pantau semua transaksi dalam tampilan yang bersih, dengan status yang mudah dibaca.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('loans.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Pinjam Baru
            </a>
        </div>
    </div>
</div>

@if($loans->isEmpty())
    <div class="empty-state fade-in-up delay-1">
        <div class="empty-state-icon">
            <i class="bi bi-journal-text"></i>
        </div>
        <h4 class="mb-2">Belum ada peminjaman</h4>
        <p class="soft-text mb-4">Mulai dari peminjaman pertama agar data transaksi muncul di sini.</p>
        <a href="{{ route('loans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Pinjam Buku
        </a>
    </div>
@else
    <div class="surface-card table-shell fade-in-up delay-1">
        <div class="table-toolbar">
            <h4 class="table-toolbar-title">Semua Transaksi Peminjaman</h4>
            <p class="table-toolbar-copy">Status, tanggal pinjam, dan denda ditampilkan dalam satu tabel</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Buku</th>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $index => $loan)
                        <tr class="{{ $loan->return_date ? '' : ($loan->due_date < now() ? 'table-danger' : 'table-warning') }}">
                            <td><strong>{{ ($loans->firstItem() ?? 0) + $index + 1 }}</strong></td>
                            <td>
                                <strong>{{ Str::limit($loan->book->title, 25) }}</strong>
                                <small class="d-block soft-text">{{ $loan->book->author }}</small>
                            </td>
                            <td>{{ Str::limit($loan->member->name, 20) }}</td>
                            <td>{{ $loan->loan_date->format('d M Y') }}</td>
                            <td>
                                <span class="soft-badge {{ $loan->due_date < now() ? 'soft-badge-danger' : 'soft-badge-info' }}">
                                    {{ $loan->due_date->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                @if($loan->return_date)
                                    <span class="soft-badge soft-badge-success">Selesai</span>
                                @elseif($loan->due_date < now())
                                    <span class="soft-badge soft-badge-danger">Terlambat</span>
                                @else
                                    <span class="soft-badge soft-badge-warning">Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if($loan->fine > 0)
                                    <span class="soft-badge soft-badge-danger">Rp {{ number_format($loan->fine) }}</span>
                                @else
                                    <span class="soft-text">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(!$loan->return_date)
                                        <a href="{{ route('loans.returnForm', $loan) }}" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-arrow-return-left"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($loans->hasPages())
            <div class="surface-card-body border-top">
                {{ $loans->links() }}
            </div>
        @endif
    </div>

    <div class="row g-3 mt-4">
        <div class="col-md-3 col-6">
            <div class="metric-card text-center">
                <div class="metric-label">Total</div>
                <div class="metric-value">{{ $loans->total() }}</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-card text-center">
                <div class="metric-label">Aktif</div>
                <div class="metric-value" style="color: var(--info);">{{ $loans->whereNull('return_date')->count() }}</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-card text-center">
                <div class="metric-label">Terlambat</div>
                <div class="metric-value" style="color: var(--danger);">{{ $loans->whereNull('return_date')->where('due_date', '<', now())->count() }}</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-card text-center">
                <div class="metric-label">Denda</div>
                <div class="metric-value" style="color: var(--success);">Rp {{ number_format($loans->sum('fine')) }}</div>
            </div>
        </div>
    </div>
@endif
@endsection
