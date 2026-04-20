@extends('layouts.app')

@section('title', 'Edit Anggota')
@section('subtitle', 'Perbarui data anggota yang sudah terdaftar')

@section('content')
<div class="form-shell fade-in-up">
    <div class="page-hero">
        <div class="page-hero-kicker">
            <i class="bi bi-pencil"></i>
            Form Anggota
        </div>
        <h1 class="page-hero-title">Edit Anggota</h1>
        <p class="page-hero-subtitle">Ubah identitas anggota tanpa mengganggu histori peminjaman yang sudah ada.</p>
    </div>

    <div class="form-panel">
        <div class="form-panel-header d-flex justify-content-between align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-person-badge me-2 text-warning"></i>{{ $member->name }}</h5>
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="form-panel-body">
            <form action="{{ route('members.update', $member) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('name') is-invalid @enderror" name="name" value="{{ old('name', $member->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No HP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $member->phone) }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control soft-textarea @error('address') is-invalid @enderror" name="address" rows="4" required>{{ old('address', $member->address) }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-end mt-4">
                    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check2-circle me-2"></i>Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
