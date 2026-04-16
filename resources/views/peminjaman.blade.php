@extends('layouts.app')

@section('title', 'Permintaan Peminjaman')

@section('content')
<style>
.borrow-shell {
    min-height: 100vh;
    background:
        radial-gradient(circle at top right, rgba(16, 185, 129, 0.12), transparent 24%),
        radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.13), transparent 28%),
        linear-gradient(135deg, #f8fbff 0%, #eefaf5 46%, #f8fafc 100%);
    padding: 2rem 0;
}
.borrow-hero,
.borrow-card,
.borrow-note {
    animation: borrowRise 0.65s ease both;
}
.borrow-hero {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(16px);
    border-radius: 24px;
    padding: 1.75rem;
    box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
    margin-bottom: 1.5rem;
}
.borrow-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.9rem;
    border-radius: 999px;
    background: linear-gradient(135deg, #dcfce7, #ecfdf5);
    color: #047857;
    font-size: 0.85rem;
    font-weight: 700;
    margin-bottom: 1rem;
}
.borrow-title {
    font-size: clamp(2rem, 4vw, 2.65rem);
    font-weight: 800;
    letter-spacing: -0.03em;
    color: #0f172a;
    margin-bottom: 0.5rem;
}
.borrow-subtitle {
    color: #64748b;
    max-width: 720px;
    margin-bottom: 0;
}
.borrow-card {
    background: rgba(255, 255, 255, 0.88);
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
}
.borrow-card-header {
    padding: 1.4rem 1.6rem;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(248,250,252,0.9));
}
.borrow-card-body {
    padding: 1.6rem;
}
.form-label {
    color: #0f172a;
    margin-bottom: 0.55rem;
}
.form-select,
.form-control {
    border-radius: 16px;
    border-color: #dbe4f0;
    padding: 0.9rem 1rem;
    box-shadow: none;
    transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
}
.form-select:focus,
.form-control:focus {
    border-color: #60a5fa;
    box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.14);
    transform: translateY(-1px);
}
.field-panel {
    height: 100%;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    background: linear-gradient(180deg, #ffffff, #f8fbff);
    padding: 1.1rem;
}
.field-hint {
    color: #64748b;
    font-size: 0.9rem;
}
.borrow-note {
    margin-top: 1.3rem;
    border: 1px solid #dbeafe;
    background: linear-gradient(135deg, #eff6ff, #f8fbff);
    color: #1d4ed8;
    border-radius: 18px;
    padding: 1rem 1.1rem;
}
.borrow-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.85rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
}
.borrow-btn {
    border-radius: 16px;
    padding: 0.9rem 1.2rem;
    font-weight: 600;
    transition: transform 0.28s ease, box-shadow 0.28s ease;
}
.borrow-btn:hover {
    transform: translateY(-2px);
}
.borrow-btn-primary {
    background: linear-gradient(135deg, #2563eb, #0f766e);
    border: none;
    color: #fff;
    box-shadow: 0 16px 28px rgba(37, 99, 235, 0.2);
}
.borrow-btn-primary:hover {
    color: #fff;
    box-shadow: 0 20px 34px rgba(37, 99, 235, 0.26);
}
.borrow-btn-secondary {
    background: #fff;
    border: 1px solid #cbd5e1;
    color: #475569;
}
@keyframes borrowRise {
    from { opacity: 0; transform: translateY(18px); }
    to { opacity: 1; transform: translateY(0); }
}
@media (max-width: 768px) {
    .borrow-hero,
    .borrow-card-body {
        padding: 1.25rem;
    }
    .borrow-actions .borrow-btn {
        width: 100%;
    }
}
</style>

<div class="borrow-shell">
    <div class="container">
        <div class="borrow-hero">
            <div class="borrow-chip">
                <i class="bi bi-lightning-charge"></i>
                Form Peminjaman Cepat
            </div>
            <h1 class="borrow-title">Ajukan Peminjaman</h1>
            <p class="borrow-subtitle">pinjam dengan pintar.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="borrow-card">
                    <div class="borrow-card-header">
                        <h4 class="card-title mb-0">
                            <i class="bi bi-plus-circle me-2 text-success"></i>Pinjam Buku Baru
                        </h4>
                    </div>
                    <div class="borrow-card-body">
                        <form method="POST" action="{{ route('peminjaman.store') }}">
                            @csrf
                            <div class="field-panel mb-4">
                                <label class="form-label fw-semibold">Pilih Buku <span class="text-danger">*</span></label>
                                <select class="form-select @error('book_id') is-invalid @enderror" name="book_id" required>
                                    <option value="">Pilih Buku Tersedia</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }} - {{ $book->author }} (Stok: {{ $book->stock }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('book_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="field-hint mt-2">Pilih buku yang masih tersedia untuk langsung mengirim permintaan peminjaman.</div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="field-panel">
                                        <label class="form-label fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('loan_date') is-invalid @enderror" name="loan_date" value="{{ old('loan_date', now()->format('Y-m-d')) }}" required>
                                        @error('loan_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <div class="field-hint mt-2">Jam pinjam otomatis mengikuti waktu saat ini: {{ now()->format('H:i') }} WIB</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-panel">
                                        <label class="form-label fw-semibold">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" value="{{ old('due_date') }}" required>
                                        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <div class="field-hint mt-2">Jam jatuh tempo akan mengikuti jam peminjaman otomatis.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="borrow-note">
                                <i class="bi bi-info-circle me-2"></i>Pastikan tanggal jatuh tempo sesuai kebutuhan. Permintaan akan dikirim ke admin untuk diverifikasi.
                            </div>

                            <div class="borrow-actions">
                                <a href="{{ route('books') }}" class="btn borrow-btn borrow-btn-secondary">Batal</a>
                                <button type="submit" class="btn borrow-btn borrow-btn-primary">
                                    <i class="bi bi-send-check me-2"></i>Kirim Permintaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

