@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<style>
.catalog-shell {
    min-height: 100vh;
    background:
        radial-gradient(circle at top right, rgba(59, 130, 246, 0.16), transparent 28%),
        radial-gradient(circle at bottom left, rgba(14, 165, 233, 0.14), transparent 24%),
        linear-gradient(135deg, #f8fbff 0%, #eef4ff 50%, #f7fbff 100%);
    padding: 2rem 0;
    position: relative;
    overflow: hidden;
}
.catalog-shell::before,
.catalog-shell::after {
    content: '';
    position: absolute;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.45);
    filter: blur(18px);
    animation: catalogFloat 18s ease-in-out infinite;
}
.catalog-shell::before { width: 320px; height: 320px; top: -100px; right: -80px; }
.catalog-shell::after  { width: 260px; height: 260px; bottom: -90px; left: -70px; animation-direction: reverse; }
@keyframes catalogFloat {
    0%, 100% { transform: translate3d(0, 0, 0); }
    50% { transform: translate3d(0, 14px, 0); }
}
.catalog-hero,
.catalog-panel,
.book-card {
    position: relative;
    z-index: 1;
}
.catalog-hero {
    background: rgba(255, 255, 255, 0.74);
    border: 1px solid rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(16px);
    border-radius: 24px;
    padding: 1.75rem;
    box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    margin-bottom: 1.75rem;
}
.catalog-kicker {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.9rem;
    border-radius: 999px;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    color: #1d4ed8;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 1rem;
}
.hero-title {
    font-size: clamp(2rem, 4vw, 2.8rem);
    font-weight: 800;
    letter-spacing: -0.03em;
    color: #0f172a;
    margin-bottom: 0.6rem;
}
.hero-subtitle {
    color: #64748b;
    max-width: 680px;
    margin-bottom: 0;
}
.catalog-cta {
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, #2563eb, #0f766e);
    color: #fff;
    padding: 0.85rem 1.2rem;
    font-weight: 600;
    box-shadow: 0 16px 28px rgba(37, 99, 235, 0.22);
    transition: transform 0.28s ease, box-shadow 0.28s ease;
}
.catalog-cta:hover {
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 20px 34px rgba(37, 99, 235, 0.28);
}
.catalog-panel {
    background: rgba(255, 255, 255, 0.82);
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 24px;
    box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    overflow: hidden;
}
.catalog-toolbar {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 1rem;
    padding: 1.4rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(248,250,252,0.9));
}
.toolbar-title {
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.25rem;
}
.toolbar-copy {
    color: #64748b;
    margin: 0;
}
.toolbar-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    border-radius: 999px;
    padding: 0.7rem 1rem;
    background: #eff6ff;
    color: #1d4ed8;
    font-weight: 600;
}
.catalog-grid {
    padding: 1.5rem;
}
.book-card {
    height: 100%;
    border-radius: 22px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    border: 1px solid #e2e8f0;
    padding: 1.35rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    animation: fadeUp 0.65s ease both;
}
.book-card:hover {
    transform: translateY(-6px);
    border-color: #bfdbfe;
    box-shadow: 0 18px 35px rgba(37, 99, 235, 0.12);
}
.book-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.1rem;
}
.book-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: #1d4ed8;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
}
.book-index {
    color: #94a3b8;
    font-size: 0.9rem;
    font-weight: 700;
}
.book-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.35rem;
}
.book-author {
    color: #64748b;
    margin-bottom: 0;
}
.book-meta {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.85rem;
    margin-bottom: 1.15rem;
}
.meta-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 0.9rem;
}
.meta-label {
    display: block;
    font-size: 0.78rem;
    font-weight: 600;
    color: #94a3b8;
    margin-bottom: 0.35rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.meta-value {
    font-weight: 700;
    color: #1e293b;
}
.category-chip,
.stock-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.55rem 0.8rem;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.84rem;
}
.category-chip {
    background: #f1f5f9;
    color: #475569;
}
.stock-ok {
    background: #ecfdf5;
    color: #047857;
}
.stock-empty {
    background: #fef2f2;
    color: #b91c1c;
}
.empty-state {
    padding: 4rem 1.5rem;
    text-align: center;
    background: rgba(255, 255, 255, 0.82);
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 24px;
    box-shadow: 0 16px 36px rgba(15, 23, 42, 0.06);
}
.empty-icon {
    width: 88px;
    height: 88px;
    margin: 0 auto 1rem;
    border-radius: 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #1d4ed8;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
}
.fade-up {
    animation: fadeUp 0.65s ease both;
}
.delay-1 { animation-delay: 0.08s; }
.delay-2 { animation-delay: 0.16s; }
.delay-3 { animation-delay: 0.24s; }
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to { opacity: 1; transform: translateY(0); }
}
@media (max-width: 768px) {
    .catalog-hero {
        padding: 1.35rem;
    }
    .catalog-grid {
        padding: 1rem;
    }
    .book-meta {
        grid-template-columns: 1fr;
    }
    .catalog-cta {
        width: 100%;
        justify-content: center;
        display: inline-flex;
    }
}
</style>

<div class="catalog-shell">
    <div class="container">
        <div class="catalog-hero fade-up">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
                <div>
                    <div class="catalog-kicker">
                        <i class="bi bi-stars"></i>
                        Katalog Perpustakaan Modern
                    </div>
                    <h1 class="hero-title">Daftar Buku</h1>
                    <p class="hero-subtitle"></p>
                </div>
                <a href="{{ route('peminjaman') }}" class="catalog-cta">
                    <i class="bi bi-plus-circle me-2"></i>Ajukan Peminjaman
                </a>
            </div>
        </div>

        @if($books->isEmpty())
            <div class="empty-state fade-up delay-1">
                <div class="empty-icon">
                    <i class="bi bi-book"></i>
                </div>
                <h3 class="fw-bold text-dark mb-2">Belum ada buku tersedia</h3>
                <p class="text-muted mb-4">Koleksi masih kosong untuk saat ini. Saat buku tersedia, daftar akan langsung tampil di sini.</p>
                <a href="{{ route('peminjaman') }}" class="catalog-cta">
                    <i class="bi bi-journal-plus me-2"></i>Ke Halaman Peminjaman
                </a>
            </div>
        @else
            <div class="catalog-panel fade-up delay-1">
                <div class="catalog-toolbar">
                    <div>
                        <h4 class="toolbar-title">Semua Koleksi Buku</h4>
                        <p class="toolbar-copy">Informasi judul, pengarang, stok, dan kategori ditampilkan</p>
                    </div>
                    <div class="toolbar-pill">
                        <i class="bi bi-collection"></i>
                        {{ $books->count() }} buku tersedia
                    </div>
                </div>

                <div class="catalog-grid">
                    <div class="row g-4">
                        @foreach($books as $index => $book)
                            <div class="col-lg-4 col-md-6">
                                <div class="book-card delay-{{ ($index % 3) + 1 }}">
                                    <div class="book-head">
                                        <div class="book-icon">
                                            <i class="bi bi-book-half"></i>
                                        </div>
                                        <div class="book-index">#{{ $index + 1 }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <h3 class="book-title">{{ Str::limit($book->title, 52) }}</h3>
                                        <p class="book-author">
                                            <i class="bi bi-pen me-1"></i>{{ Str::limit($book->author, 34) }}
                                        </p>
                                    </div>

                                    <div class="book-meta">
                                        <div class="meta-box">
                                            <span class="meta-label">Stok</span>
                                            <span class="meta-value">
                                                @if($book->stock > 0)
                                                    {{ $book->stock }} Buku
                                                @else
                                                    Habis
                                                @endif
                                            </span>
                                        </div>
                                        <div class="meta-box">
                                            <span class="meta-label">Kategori</span>
                                            <span class="meta-value">{{ $book->category ?? 'Umum' }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 align-items-center">
                                        <span class="stock-chip {{ $book->stock > 0 ? 'stock-ok' : 'stock-empty' }}">
                                            <i class="bi {{ $book->stock > 0 ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                            {{ $book->stock > 0 ? 'Siap Dipinjam' : 'Stok Habis' }}
                                        </span>
                                        <span class="category-chip">
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
    </div>
</div>
@endsection

