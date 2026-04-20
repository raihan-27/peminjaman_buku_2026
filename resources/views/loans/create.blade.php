@extends('layouts.app')

@section('title', 'Pinjam Buku')
@section('subtitle', 'Catat transaksi peminjaman baru')

@section('content')
<div class="form-shell fade-in-up">
    <div class="page-hero">
        <div class="page-hero-kicker">
            <i class="bi bi-plus-circle"></i>
            Pinjam
        </div>
        <h1 class="page-hero-title">Pinjam Buku Baru</h1>
        <p class="page-hero-subtitle">Pilih buku, anggota, dan tanggal peminjaman untuk mencatat transaksi dengan rapi.</p>
    </div>

    <div class="form-panel">
        <div class="form-panel-header d-flex justify-content-between align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-journal-arrow-up me-2 text-warning"></i>Data Peminjaman</h5>
            <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="form-panel-body">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Buku <span class="text-danger">*</span></label>
                        <select class="form-select soft-select @error('book_id') is-invalid @enderror" name="book_id" required>
                            <option value="">Pilih Buku</option>
                            @foreach($books->where('stock', '>', 0) as $book)
                                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} - {{ $book->author }} (Stok: {{ $book->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('book_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Anggota <span class="text-danger">*</span></label>
                        <select class="form-select soft-select @error('member_id') is-invalid @enderror" name="member_id" required>
                            <option value="">Pilih Anggota</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" class="form-control soft-input @error('loan_date') is-invalid @enderror" name="loan_date" value="{{ old('loan_date', now()->format('Y-m-d')) }}" required>
                        @error('loan_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Batas Kembali <span class="text-danger">*</span></label>
                        <input type="date" class="form-control soft-input @error('due_date') is-invalid @enderror" name="due_date" value="{{ old('due_date') }}" required min="{{ now()->format('Y-m-d') }}">
                        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="alert alert-info mt-4 mb-0">
                    <i class="bi bi-info-circle me-2"></i>Denda: Rp 1.000/hari setelah batas waktu
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-end mt-4">
                    <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-2"></i>Catat Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelector('input[name="loan_date"]').addEventListener('change', function() {
    const loanDate = new Date(this.value);
    const dueDate = new Date(loanDate.getTime() + 7 * 24 * 60 * 60 * 1000);
    document.querySelector('input[name="due_date"]').value = dueDate.toISOString().split('T')[0];
});
</script>
@endsection
