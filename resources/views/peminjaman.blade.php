@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('subtitle', 'Pilih buku yang ingin dipinjam dan ajukan permohonan ke admin')

@section('content')
<style>
.book-card {
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.58), rgba(255, 255, 255, 0.40));
    backdrop-filter: blur(22px) saturate(1.05);
    border: 1px solid rgba(226, 232, 240, 0.84);
    border-radius: 28px;
    padding: 1.5rem;
    transition: transform 0.26s ease, box-shadow 0.26s ease, border-color 0.26s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
    position: relative;
    overflow: hidden;
}

.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 28px 60px rgba(15, 23, 42, 0.12);
    border-color: rgba(91, 93, 246, 0.22);
}

.book-card::before {
    content: '';
    position: absolute;
    inset: 0 auto auto 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #5b5df6, #06b6d4);
}

.book-cover {
    width: 100%;
    height: 220px;
    background:
        radial-gradient(circle at 50% 10%, rgba(91, 93, 246, 0.10), transparent 35%),
        linear-gradient(135deg, rgba(240, 244, 248, 0.92) 0%, rgba(217, 226, 236, 0.84) 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 1rem;
    object-fit: cover;
}

.book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
}

.book-cover-placeholder i {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    opacity: 0.5;
}

.book-header {
    margin-bottom: 1rem;
}

.book-title {
    font-size: 1.08rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.3rem;
    line-height: 1.3;
}

.book-author {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
}

.book-info {
    display: grid;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding: 0.95rem;
    background: rgba(248, 250, 252, 0.40);
    backdrop-filter: blur(14px);
    border-radius: 18px;
    font-size: 0.85rem;
    border: 1px solid rgba(226, 232, 240, 0.72);
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    flex-wrap: wrap;
}

.info-label {
    color: var(--text-muted);
    font-weight: 500;
}

.info-value {
    color: var(--text-dark);
    font-weight: 600;
}

.stock-badge {
    display: inline-block;
    padding: 0.34rem 0.75rem;
    background: rgba(209, 250, 229, 0.66);
    color: var(--success);
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid rgba(167, 243, 208, 0.72);
    backdrop-filter: blur(12px);
}

.stock-badge.out {
    background: rgba(254, 226, 226, 0.66);
    color: var(--danger);
    border-color: rgba(252, 165, 165, 0.72);
}

.book-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: auto;
}

.btn-pinjam {
    flex: 1;
    padding: 0.6rem 1rem;
    background: linear-gradient(135deg, #5b5df6, #2563eb);
    color: white;
    border: none;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: transform 0.22s ease, box-shadow 0.22s ease, filter 0.22s ease;
    box-shadow: 0 14px 28px rgba(91, 93, 246, 0.18);
}

.btn-pinjam:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 36px rgba(91, 93, 246, 0.24);
}

.btn-pinjam:disabled {
    background: rgba(203, 213, 225, 0.82);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.empty-state {
    grid-column: 1 / -1;
    padding: 3rem;
    text-align: center;
    background: rgba(255, 255, 255, 0.46);
    backdrop-filter: blur(22px) saturate(1.05);
    border: 1px solid rgba(226, 232, 240, 0.84);
    border-radius: 28px;
    box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
}

.empty-icon {
    font-size: 3.25rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

@media (max-width: 767.98px) {
    .book-card {
        padding: 1.25rem;
        border-radius: 24px;
    }

    .book-cover {
        height: 200px;
    }
}
</style>

<div class="page-hero fade-in-up">
    <h1 class="page-hero-title"><i class="bi bi-journals me-2"></i>Daftar Buku</h1>
    <p class="page-hero-subtitle">Pilih buku yang ingin dipinjam dan ajukan permohonan peminjaman ke admin</p>
</div>

<div class="container-fluid">
    @if($books->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-inbox"></i></div>
            <h5 class="fw-bold">Tidak Ada Buku Tersedia</h5>
            <p class="text-muted mb-0">Semua buku sedang tidak tersedia atau kosong. Silahkan cek lagi nanti.</p>
        </div>
    @else
        <div class="row g-3">
            @foreach($books as $book)
                <div class="col-sm-6 col-lg-4">
                    <div class="book-card">
                        <div class="book-cover">
                            @if($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" loading="lazy">
                            @else
                                <div class="book-cover-placeholder">
                                    <i class="bi bi-book"></i>
                                    <small>Tidak ada cover</small>
                                </div>
                            @endif
                        </div>

                        <div class="book-header">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author"><i class="bi bi-person me-1"></i>{{ $book->author ?? 'Penulis Tidak Diketahui' }}</div>
                        </div>

                        <div class="book-info">
                            <div class="info-item">
                                <i class="bi bi-bookmark text-primary"></i>
                                <span class="info-label">Kategori:</span>
                                <span class="info-value">{{ $book->category ?? 'Umum' }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-stack text-success"></i>
                                <span class="info-label">Stok:</span>
                                <span class="info-value stock-badge {{ $book->stock <= 0 ? 'out' : '' }}">
                                    {{ $book->stock }} buku
                                </span>
                            </div>
                        </div>

                        <div class="book-actions">
                            <button type="button" 
                                    class="btn-pinjam" 
                                    onclick="openBorrowModal({{ $book->id }}, '{{ $book->title }}')"
                                    {{ $book->stock <= 0 ? 'disabled' : '' }}>
                                <i class="bi bi-bookmark-check me-1"></i>{{ $book->stock <= 0 ? 'Tidak Tersedia' : 'Pinjam' }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Peminjaman -->
<div class="modal fade" id="borrowModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-soft);">
            <div class="modal-header border-bottom" style="padding: 1.5rem;">
                <h5 class="modal-title fw-bold"><i class="bi bi-bookmark-check me-2 text-primary"></i>Ajukan Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <form method="POST" action="{{ route('peminjaman.store') }}" id="borrowForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Buku: <span id="bookTitle" class="text-primary"></span></label>
                        <input type="hidden" name="book_id" id="bookId">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" class="form-control soft-input @error('loan_date') is-invalid @enderror" 
                               name="loan_date" 
                               id="loanDate"
                               value="{{ old('loan_date', now()->format('Y-m-d')) }}" 
                               required>
                        <small class="form-text text-muted">Jam pinjam: {{ now()->format('H:i') }} WIB</small>
                        @error('loan_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                        <input type="date" class="form-control soft-input @error('due_date') is-invalid @enderror" 
                               name="due_date" 
                               id="dueDate"
                               value="{{ old('due_date') }}" 
                               required>
                        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-send-check me-1"></i>Ajukan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openBorrowModal(bookId, bookTitle) {
    document.getElementById('bookId').value = bookId;
    document.getElementById('bookTitle').textContent = bookTitle;
    document.getElementById('loanDate').value = new Date().toISOString().split('T')[0];
    document.getElementById('dueDate').value = '';
    new bootstrap.Modal(document.getElementById('borrowModal')).show();
}
</script>
@endsection
