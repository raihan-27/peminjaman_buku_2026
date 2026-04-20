@extends('layouts.app')

@section('title', 'Pengembalian Buku')
@section('subtitle', 'Kelola buku yang sedang dipinjam dan proses pengembalian')

@section('content')
<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-arrow-return-left"></i>
                Pengembalian
            </div>
            <h1 class="page-hero-title">Pengembalian Buku</h1>
            <p class="page-hero-subtitle">Daftar buku yang masih aktif dipinjam dan siap dikembalikan dari akun Anda.</p>
        </div>
        <a href="{{ route('books') }}" class="btn btn-outline-secondary">
            <i class="bi bi-journals me-2"></i>Lihat Buku
        </a>
    </div>
</div>

@if($activeLoans->isEmpty())
    <div class="empty-state fade-in-up delay-1">
        <div class="empty-state-icon">
            <i class="bi bi-inbox"></i>
        </div>
        <h4 class="mb-2">Tidak ada buku yang dipinjam</h4>
        <p class="soft-text mb-4">Saat Anda memiliki peminjaman aktif, daftar pengembalian akan muncul di sini.</p>
        <a href="{{ route('books') }}" class="btn btn-primary">
            <i class="bi bi-book me-2"></i>Lihat Buku
        </a>
    </div>
@else
    <div class="surface-card fade-in-up delay-1">
        <div class="table-toolbar">
            <h4 class="table-toolbar-title">Buku Aktif ({{ $activeLoans->count() }})</h4>
            <p class="table-toolbar-copy">Proses pengembalian dilakukan langsung dari daftar ini</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Jatuh Tempo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeLoans as $loan)
                        <tr>
                            <td>
                                <strong>{{ $loan->book->title }}</strong>
                                <small class="d-block soft-text">{{ $loan->book->author }}</small>
                            </td>
                            <td>{{ $loan->loaned_at_local?->format('d M Y, H:i') ?? '-' }} WIB</td>
                            <td>
                                @if($loan->due_at_local && $loan->due_at_local->lt(now()))
                                    <span class="soft-badge soft-badge-danger">
                                        {{ $loan->due_at_local->format('d M Y, H:i') }} WIB
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </span>
                                @else
                                    <span class="soft-badge soft-badge-info">{{ $loan->due_at_local?->format('d M Y, H:i') ?? '-' }} WIB</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('pengembalian.process', $loan->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Kembalikan buku {{ $loan->book->title }} sekarang?')">
                                        <i class="bi bi-check-circle me-1"></i>Kembalikan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
