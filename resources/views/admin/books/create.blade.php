@extends('layouts.app')

@section('title', 'Tambah Buku Admin')
@section('subtitle', 'Tambahkan buku baru beserta cover untuk admin')

@section('content')
<div class="form-shell fade-in-up">
    <div class="page-hero">
        <div class="page-hero-kicker">
            <i class="bi bi-plus-circle"></i>
            Form Buku Admin
        </div>
        <h1 class="page-hero-title">Tambah Buku Baru</h1>
        <p class="page-hero-subtitle">Isi data buku, unggah cover, lalu simpan agar langsung muncul di katalog dan daftar admin.</p>
    </div>

    <div class="form-panel">
        <div class="form-panel-header d-flex justify-content-between align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-journal-plus me-2 text-success"></i>Data Buku</h5>
            <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="form-panel-body">
            <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pengarang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('author') is-invalid @enderror" name="author" value="{{ old('author') }}" required>
                        @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('publisher') is-invalid @enderror" name="publisher" value="{{ old('publisher') }}" required>
                        @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                        <input type="number" class="form-control soft-input @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}" min="1900" max="2100" required>
                        @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" class="form-control soft-input @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', 1) }}" min="1" max="100" required>
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required>
                        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Cover Buku <span class="text-danger">*</span></label>
                        <input type="file" class="form-control soft-input @error('cover') is-invalid @enderror" name="cover" accept="image/*" required>
                        <div class="form-text">JPG, PNG, GIF (maks 2 MB) - akan tersimpan di storage/book-covers/</div>
                        @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
