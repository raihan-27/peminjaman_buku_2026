@extends('layouts.app')

@section('title', 'Kembalikan Buku')
@section('subtitle', 'Proses pengembalian dan estimasi denda')

@section('content')
<div class="form-shell fade-in-up">
    <div class="page-hero">
        <div class="page-hero-kicker">
            <i class="bi bi-arrow-return-left"></i>
            Pengembalian
        </div>
        <h1 class="page-hero-title">Kembalikan Buku #{{ $loan->id }}</h1>
        <p class="page-hero-subtitle">Lengkapi tanggal pengembalian, lihat estimasi denda, lalu proses pengembalian.</p>
    </div>

    <div class="form-panel">
        <div class="form-panel-header d-flex justify-content-between align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-arrow-return-left me-2 text-success"></i>Data Pengembalian</h5>
            <a href="{{ route('loans.show', $loan) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Detail
            </a>
        </div>
        <div class="form-panel-body">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="metric-card h-100">
                        <div class="metric-label">Buku</div>
                        <div class="fw-semibold">{{ Str::limit($loan->book->title, 30) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="metric-card h-100">
                        <div class="metric-label">Anggota</div>
                        <div class="fw-semibold">{{ $loan->member->name }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="metric-card h-100">
                        <div class="metric-label">Batas Kembali</div>
                        <div class="fw-semibold {{ $loan->due_date < now()->format('Y-m-d') ? 'text-danger' : 'text-success' }}">
                            {{ $loan->due_date->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('loans.processReturn', $loan) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Pengembalian <span class="text-danger">*</span></label>
                    <input type="date" class="form-control soft-input @error('return_date') is-invalid @enderror"
                           name="return_date" value="{{ old('return_date', now()->format('Y-m-d')) }}"
                           max="{{ now()->format('Y-m-d') }}" required min="{{ $loan->loan_date->format('Y-m-d') }}">
                    @error('return_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Denda Rp 1.000/hari jika terlambat</div>
                </div>

                <div id="denda-preview" class="alert alert-warning" style="display: none;">
                    <h6 class="mb-2"><i class="bi bi-exclamation-triangle me-1"></i>Estimasi Denda</h6>
                    <div id="denda-amount" class="fs-4 fw-bold text-danger">Rp 0</div>
                    <small>Rp 1.000 per hari keterlambatan</small>
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-end">
                    <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Proses Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const dueDate = new Date('{{ $loan->due_date->format('Y-m-d') }}');
const returnInput = document.querySelector('input[name="return_date"]');
const preview = document.getElementById('denda-preview');
const amount = document.getElementById('denda-amount');

function calcDenda() {
    const returnDate = new Date(returnInput.value);
    if (returnDate > dueDate) {
        const daysLate = Math.ceil((returnDate - dueDate) / (1000 * 60 * 60 * 24));
        const denda = daysLate * 1000;
        amount.textContent = 'Rp ' + denda.toLocaleString('id-ID');
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

returnInput.addEventListener('change', calcDenda);
returnInput.addEventListener('input', calcDenda);
calcDenda();
</script>
@endsection
