@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('subtitle', 'Katalog buku yang siap dilihat dan dipinjam')

@section('content')
@php
    $availableCount = $books->where('stock', '>', 0)->count();
@endphp

<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-stars"></i>
                Katalog
            </div>
            <h1 class="page-hero-title">Daftar Buku</h1>
            <p class="page-hero-subtitle">Tampilan katalog yang konsisten dengan dashboard, lengkap dengan cover buku dan status stok.</p>
        </div>
        <div class="page-actions">
            <span class="soft-badge soft-badge-success">
                <i class="bi bi-collection"></i>
                {{ $books->count() }} buku
            </span>
            <span class="soft-badge soft-badge-info">
                <i class="bi bi-check-circle"></i>
                {{ $availableCount }} tersedia
            </span>
            <a href="{{ route('peminjaman') }}" class="btn btn-primary">
                <i class="bi bi-journal-arrow-up me-2"></i>Ajukan Peminjaman
            </a>
        </div>
    </div>
</div>

@if($books->isEmpty())
    <div class="empty-state fade-in-up delay-1">
        <div class="empty-state-icon">
            <i class="bi bi-book"></i>
        </div>
        <h3 class="fw-bold mb-2">Belum ada buku tersedia</h3>
        <p class="soft-text mb-4">Koleksi masih kosong untuk saat ini. Saat buku tersedia, katalog akan langsung tampil di sini.</p>
        <a href="{{ route('peminjaman') }}" class="btn btn-primary">
            <i class="bi bi-journal-plus me-2"></i>Ke Halaman Peminjaman
        </a>
    </div>
@else
    <div class="surface-card fade-in-up delay-1">
        <div class="table-toolbar d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h4 class="table-toolbar-title">Semua Koleksi Buku</h4>
                <p class="table-toolbar-copy">Cover, pengarang, stok, dan kategori ditampilkan dalam kartu</p>
            </div>
            <span class="soft-badge soft-badge-info">
                <i class="bi bi-journals"></i>
                {{ $books->count() }} item
            </span>
        </div>

        <div class="p-3 p-md-4">
            <div class="row g-4">
                @foreach($books as $index => $book)
                    <div class="col-lg-4 col-md-6">
                        <div class="metric-card h-100 fade-in-up delay-{{ ($index % 3) + 1 }}">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                @if($book->cover_url)
                                    <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}" class="book-cover-thumb" style="width: 72px; height: 98px;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded-4 border" style="width: 72px; height: 98px; background: #f8fafc; color: var(--text-muted);">
                                        <i class="bi bi-book-half"></i>
                                    </div>
                                @endif
                                <span class="soft-badge soft-badge-info">#{{ $index + 1 }}</span>
                            </div>

                            <h5 class="mb-2">{{ Str::limit($book->title, 48) }}</h5>
                            <p class="soft-text mb-3">
                                <i class="bi bi-pen me-1"></i>{{ Str::limit($book->author, 36) }}
                            </p>

                            <div class="d-grid gap-2 mb-3">
                                <div class="metric-card p-3">
                                    <div class="metric-label">Stok</div>
                                    <div class="fw-semibold">
                                        {{ $book->stock > 0 ? $book->stock . ' Buku' : 'Habis' }}
                                    </div>
                                </div>
                                <div class="metric-card p-3">
                                    <div class="metric-label">Kategori</div>
                                    <div class="fw-semibold">{{ $book->category ?? 'Umum' }}</div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <span class="soft-badge {{ $book->stock > 0 ? 'soft-badge-success' : 'soft-badge-danger' }}">
                                    <i class="bi {{ $book->stock > 0 ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                    {{ $book->stock > 0 ? 'Siap Dipinjam' : 'Stok Habis' }}
                                </span>
                                <span class="soft-badge soft-badge-info">
                                    <i class="bi bi-bookmark-star"></i>
                                    {{ $book->category ?? 'Umum' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection
