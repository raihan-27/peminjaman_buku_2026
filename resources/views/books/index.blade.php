@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('subtitle', 'Koleksi buku dengan cover, stok, dan kategori')

@section('content')
@php
    $totalBooks = $books->count();
    $availableBooks = $books->where('stock', '>', 0)->count();
    $emptyBooks = $books->where('stock', '<=', 0)->count();
    $isAdmin = session('user.role') === 'admin';
@endphp

<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center gap-4">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-journals"></i>
                Koleksi
            </div>
            <h1 class="page-hero-title">Daftar Buku</h1>
            <p class="page-hero-subtitle">daftar buku aii.liblary dengan informasi lengkap untuk peminjaman</p>
        </div>
        <div class="page-actions">
            @if($isAdmin)
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Buku
                </a>
            @endif
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-house-door me-2"></i>Dashboard
            </a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="metric-card fade-in-up delay-1">
            <div class="metric-label">Total Buku</div>
            <div class="metric-value">{{ $totalBooks }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card fade-in-up delay-2">
            <div class="metric-label">Stok Tersedia</div>
            <div class="metric-value text-success">{{ $availableBooks }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card fade-in-up delay-3">
            <div class="metric-label">Stok Habis</div>
            <div class="metric-value text-danger">{{ $emptyBooks }}</div>
        </div>
    </div>
</div>

@if($books->isEmpty())
    <div class="empty-state fade-in-up delay-1">
        <div class="empty-state-icon">
            <i class="bi bi-book"></i>
        </div>
        <h3 class="fw-bold mb-2">Belum ada buku</h3>
        <p class="soft-text mb-4">Saat koleksi ditambahkan, daftar buku akan langsung muncul di sini.</p>
        @if($isAdmin)
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                <i class="bi bi-journal-plus me-2"></i>Tambah Buku Pertama
            </a>
        @endif
    </div>
@else
    <div class="surface-card table-shell fade-in-up delay-1">
        <div class="table-toolbar">
            <h4 class="table-toolbar-title">Koleksi Buku Perpustakaan</h4>
            <p class="table-toolbar-copy">Informasi cover, pengarang, tahun, stok, dan kategori</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cover</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        @if($isAdmin)
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $index => $book)
                        <tr>
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td>
@if($book->cover_url)
                                    <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}" class="book-cover-thumb" loading="lazy">
                                @else
                                    <div class="book-cover-thumb d-flex align-items-center justify-content-center soft-text" style="background: rgba(248, 250, 252, 0.58); backdrop-filter: blur(10px);">
                                        <i class="bi bi-book"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ Str::limit($book->title, 42) }}</strong>
                                <small class="d-block soft-text">ID Buku #{{ $book->id }}</small>
                            </td>
                            <td>{{ Str::limit($book->author, 24) }}</td>
                            <td>{{ Str::limit($book->publisher, 24) }}</td>
                            <td>{{ $book->year }}</td>
                            <td>
                                <span class="soft-badge {{ $book->stock > 0 ? 'soft-badge-success' : 'soft-badge-danger' }}">
                                    <i class="bi {{ $book->stock > 0 ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                    {{ $book->stock > 0 ? $book->stock . ' tersedia' : 'Habis' }}
                                </span>
                            </td>
                            <td>
                                <span class="soft-badge soft-badge-info">
                                    <i class="bi bi-bookmark-star"></i>
                                    {{ $book->category ?? 'Umum' }}
                                </span>
                            </td>
                            @if($isAdmin)
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="d-inline" onsubmit="return confirm('Hapus {{ $book->title }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
