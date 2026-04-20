@extends('layouts.app')

@section('title', $book->title)
@section('subtitle', 'Detail buku, cover, dan riwayat peminjaman')

@section('content')
<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-book-half"></i>
                Detail Buku
            </div>
            <h1 class="page-hero-title">{{ $book->title }}</h1>
            <p class="page-hero-subtitle">{{ $book->author }} - {{ $book->publisher }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="surface-card fade-in-up delay-1 h-100">
            <div class="surface-card-body">
@if($book->cover_url)
                    <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}" class="img-fluid rounded-4 border shadow-sm" style="height: 400px; width: 100%; object-fit: cover;">
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-image"></i>
                        </div>
                        <h5 class="mb-2">Belum ada cover</h5>
                        <p class="soft-text mb-0">Cover buku akan tampil di sini setelah diunggah.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="surface-card fade-in-up delay-2">
            <div class="surface-card-header">
                <h5 class="mb-0">Informasi Buku</h5>
            </div>
            <div class="surface-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Judul</div>
                            <div class="fw-semibold">{{ $book->title }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Pengarang</div>
                            <div class="fw-semibold">{{ $book->author }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Penerbit</div>
                            <div class="fw-semibold">{{ $book->publisher }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-card h-100">
                            <div class="metric-label">Tahun</div>
                            <div class="metric-value" style="font-size: 1.3rem;">{{ $book->year }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-card h-100">
                            <div class="metric-label">Stok</div>
                            <div class="metric-value" style="font-size: 1.3rem;">
                                {{ $book->stock > 0 ? $book->stock : 'Habis' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Kategori</div>
                            <span class="soft-badge soft-badge-info">
                                <i class="bi bi-bookmark-star"></i>
                                {{ $book->category ?? 'Umum' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Status Stok</div>
                            <span class="soft-badge {{ $book->stock > 0 ? 'soft-badge-success' : 'soft-badge-danger' }}">
                                <i class="bi {{ $book->stock > 0 ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($book->loans()->exists())
            <div class="surface-card fade-in-up delay-3 mt-4">
                <div class="surface-card-header">
                    <h5 class="mb-0">Riwayat Peminjaman</h5>
                </div>
                <div class="surface-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Anggota</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($book->loans()->latest()->take(10)->get() as $loan)
                                    <tr>
                                        <td>{{ $loan->member->name ?? 'N/A' }}</td>
                                        <td>{{ $loan->loan_date->format('d M Y') }}</td>
                                        <td>{{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}</td>
                                        <td>
                                            @if($loan->return_date)
                                                <span class="soft-badge soft-badge-success">Selesai</span>
                                            @else
                                                <span class="soft-badge soft-badge-info">Dipinjam</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
