@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('subtitle', 'Tambahkan data anggota baru')

@section('content')
<div class="form-shell fade-in-up">
    <div class="page-hero">
        <div class="page-hero-kicker">
            <i class="bi bi-person-plus"></i>
            Form Anggota
        </div>
        <h1 class="page-hero-title">Tambah Anggota Baru</h1>
        <p class="page-hero-subtitle">Isi data identitas anggota agar langsung masuk ke daftar dan siap dipinjamkan buku.</p>
    </div>

    <div class="form-panel">
        <div class="form-panel-header d-flex justify-content-between align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-people me-2 text-success"></i>Data Anggota</h5>
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="form-panel-body">
            <form action="{{ route('members.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No HP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control soft-textarea @error('address') is-invalid @enderror" id="address" name="address" rows="4" required>{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-end mt-4">
                    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
