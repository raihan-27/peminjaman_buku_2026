@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<style>
.books-shell {
    min-height: 100vh;
    background:
        radial-gradient(circle at top left, rgba(56, 189, 248, 0.14), transparent 25%),
        radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.14), transparent 28%),
        linear-gradient(140deg, #f8fbff 0%, #f0f6ff 45%, #f8fafc 100%);
    padding: 2rem 0;
}
.books-hero,
.books-table-card,
.stat-tile {
    animation: softRise 0.65s ease both;
}
.books-hero {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(16px);
    border-radius: 24px;
    padding: 1.75rem;
    box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    margin-bottom: 1.5rem;
}
.hero-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.95rem;
    border-radius: 999px;
    background: linear-gradient(135deg, #dcfce7, #ecfdf5);
    color: #047857;
    font-size: 0.84rem;
    font-weight: 700;
    margin-bottom: 1rem;
}
.books-title {
    font-size: clamp(2rem, 4vw, 2.7rem);
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.03em;
    margin-bottom: 0.5rem;
}
.books-subtitle {
    color: #64748b;
    max-width: 700px;
    margin-bottom: 0;
}
.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.85rem;
}
.hero-btn {
    border: none;
    border-radius: 16px;
    padding: 0.85rem 1.15rem;
    font-weight: 600;
    transition: transform 0.28s ease, box-shadow 0.28s ease;
}
.hero-btn-primary {
    color: #fff;
    background: linear-gradient(135deg, #16a34a, #0f766e);
    box-shadow: 0 16px 30px rgba(22, 163, 74, 0.2);
}
.hero-btn-secondary {
    color: #1d4ed8;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
}
.hero-btn:hover {
    transform: translateY(-2px);
}
.hero-btn-primary:hover {
    color: #fff;
    box-shadow: 0 20px 35px rgba(22, 163, 74, 0.26);
}
.hero-btn-secondary:hover {
    color: #1e40af;
    background: #dbeafe;
}
.stat-tile {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 1.2rem 1.3rem;
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.06);
}
.stat-label {
    color: #64748b;
    font-weight: 600;
    margin-bottom: 0.35rem;
}
.stat-number {
    font-size: 1.9rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}
.books-table-card {
    background: rgba(255, 255, 255, 0.88);
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
    overflow: hidden;
}
.table-toolbar {
    padding: 1.35rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.95));
}
.table-title {
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.25rem;
}
.table-copy {
    color: #64748b;
    margin: 0;
}
.books-table {
    margin-bottom: 0;
}
.books-table thead th {
    background: #f8fafc;
    color: #475569;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.1rem;
    white-space: nowrap;
}
.books-table tbody td {
    vertical-align: middle;
    padding: 1rem 1.1rem;
    border-color: #eef2f7;
}
.books-table tbody tr:hover {
    background: #f8fbff;
}
.book-title-cell {
    font-weight: 700;
    color: #0f172a;
}
.book-subtext {
    display: block;
    margin-top: 0.25rem;
    color: #94a3b8;
    font-size: 0.82rem;
}
.stock-badge,
.category-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    border-radius: 999px;
    padding: 0.5rem 0.8rem;
    font-weight: 600;
    font-size: 0.82rem;
}
.stock-badge.in-stock {
    background: #ecfdf5;
    color: #047857;
}
.stock-badge.out-stock {
    background: #fef2f2;
    color: #b91c1c;
}
.category-badge {
    background: #f1f5f9;
    color: #475569;
}
.action-stack {
    display: flex;
    gap: 0.55rem;
}
.icon-action {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.icon-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(15, 23, 42, 0.12);
}
.empty-panel {
    padding: 4rem 1.5rem;
    text-align: center;
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    box-shadow: 0 16px 32px rgba(15, 23, 42, 0.06);
}
@keyframes softRise {
    from { opacity: 0; transform: translateY(18px); }
    to { opacity: 1; transform: translateY(0); }
}
@media (max-width: 768px) {
    .books-hero {
        padding: 1.35rem;
    }
    .hero-actions {
        width: 100%;
    }
    .hero-btn {
        width: 100%;
        text-align: center;
    }
}
</style>

@php
    $totalBooks = $books->count();
    $availableBooks = $books->where('stock', '>', 0)->count();
    $emptyBooks = $books->where('stock', '<=', 0)->count();
@endphp

<div class="books-shell">
    <div class="container">
        <div class="books-hero">
            <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center gap-4">
                <div>
                    <div class="hero-pill">
                        <i class="bi bi-grid-1x2-fill"></i>
                        Koleksi Tertata
                    </div>
                    <h1 class="books-title"></h1>Aii.Liblary
                    <p class="books-subtitle">Perpustakaan online yang membantu user untuk meminjam buku dengan platform digital</p>
                </div>
                <div class="hero-actions">
                    @if(session('user.role') == 'admin')
                        <a href="{{ route('admin.books.create') }}" class="hero-btn hero-btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Buku
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="hero-btn hero-btn-secondary">
                        <i class="bi bi-house-door me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-tile" style="animation-delay: 0.08s;">
                    <div class="stat-label">Total Buku</div>
                    <div class="stat-number">{{ $totalBooks }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-tile" style="animation-delay: 0.16s;">
                    <div class="stat-label">Stok Tersedia</div>
                    <div class="stat-number text-success">{{ $availableBooks }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-tile" style="animation-delay: 0.24s;">
                    <div class="stat-label">Stok Habis</div>
                    <div class="stat-number text-danger">{{ $emptyBooks }}</div>
                </div>
            </div>
        </div>

        @if($books->isEmpty())
            <div class="empty-panel">
                <i class="bi bi-book display-4 text-primary mb-3"></i>
                <h3 class="fw-bold text-dark mb-2">Belum ada buku</h3>
                <p class="text-muted mb-4">Saat koleksi ditambahkan, daftar buku akan langsung muncul dengan tampilan baru ini.</p>
                @if(session('user.role') == 'admin')
                    <a href="{{ route('admin.books.create') }}" class="hero-btn hero-btn-primary">
                        <i class="bi bi-journal-plus me-2"></i>Tambah Buku Pertama
                    </a>
                @endif
            </div>
        @else
            <div class="books-table-card">
                <div class="table-toolbar">
                    <h4 class="table-title">Koleksi Buku Perpustakaan</h4>
                    <p class="table-copy">aii.colection</p>
                </div>

                <div class="table-responsive">
                    <table class="table books-table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                @if(session('user.role') == 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $index => $book)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>
                                        <span class="book-title-cell">{{ Str::limit($book->title, 42) }}</span>
                                        <span class="book-subtext">ID Buku #{{ $book->id }}</span>
                                    </td>
                                    <td>{{ Str::limit($book->author, 24) }}</td>
                                    <td>{{ Str::limit($book->publisher, 24) }}</td>
                                    <td>{{ $book->year }}</td>
                                    <td>
                                        <span class="stock-badge {{ $book->stock > 0 ? 'in-stock' : 'out-stock' }}">
                                            <i class="bi {{ $book->stock > 0 ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                            {{ $book->stock > 0 ? $book->stock . ' tersedia' : 'Habis' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="category-badge">
                                            <i class="bi bi-bookmark-star"></i>
                                            {{ $book->category ?? 'Umum' }}
                                        </span>
                                    </td>
                                    @if(session('user.role') == 'admin')
                                        <td>
                                            <div class="action-stack">
                                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-outline-primary icon-action" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="d-inline" onsubmit="return confirm('Hapus {{ $book->title }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger icon-action" title="Hapus">
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
    </div>
</div>
@endsection

