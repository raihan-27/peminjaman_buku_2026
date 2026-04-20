@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('subtitle', 'Pilih buku yang ingin dipinjam dan ajukan permohonan ke admin')

@section('content')
<style>
.book-card {
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid var(--border-soft);
    border-radius: 16px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.book-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    border-color: var(--primary);
}

.book-cover {
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
    border-radius: 12px;
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
    font-size: 1.1rem;
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
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 12px;
    font-size: 0.85rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.3rem;
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
    padding: 0.3rem 0.7rem;
    background: var(--success-bg);
    color: var(--success);
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.stock-badge.out {
    background: #fee2e2;
    color: var(--danger);
}

.book-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: auto;
}

.btn-pinjam {
    flex: 1;
    padding: 0.6rem 1rem;
    background: linear-gradient(135deg, var(--primary), #2563eb);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-pinjam:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.btn-pinjam:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
    transform: none;
}

.empty-state {
    grid-column: 1 / -1;
    padding: 3rem;
    text-align: center;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid var(--border-soft);
    border-radius: 16px;
}

.empty-icon {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 1rem;
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
                            @if($book->cover_path)
                                <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" loading="lazy">
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
