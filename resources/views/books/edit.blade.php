 @extends('layouts.app')

@section('title', 'Edit Buku')
@section('subtitle', 'Perbarui detail buku dan cover yang tersimpan')

@section('content')
<div class="form-shell fade-in-up">
    <div class="page-hero">
        <div class="page-hero-kicker">
            <i class="bi bi-pencil-square"></i>
            Form Buku
        </div>
        <h1 class="page-hero-title">Edit Buku</h1>
        <p class="page-hero-subtitle">Ubah data buku tanpa kehilangan cover lama jika file baru tidak dipilih.</p>
    </div>

    <div class="form-panel">
        <div class="form-panel-header d-flex justify-content-between align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-journal-bookmark me-2 text-primary"></i>{{ $book->title }}</h5>
            <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="form-panel-body">
            <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('title') is-invalid @enderror" name="title" value="{{ old('title', $book->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pengarang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('author') is-invalid @enderror" name="author" value="{{ old('author', $book->author) }}" required>
                        @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('publisher') is-invalid @enderror" name="publisher" value="{{ old('publisher', $book->publisher) }}" required>
                        @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                        <input type="number" class="form-control soft-input @error('year') is-invalid @enderror" name="year" value="{{ old('year', $book->year) }}" min="1900" max="2100" required>
                        @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control soft-input @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $book->stock) }}" min="0" max="100" required>
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('category') is-invalid @enderror" name="category" value="{{ old('category', $book->category) }}" required>
                        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Ganti Cover</label>
                        <input type="file" class="form-control soft-input @error('cover') is-invalid @enderror" name="cover" accept="image/*">
                        <div class="form-text">Kosongkan untuk keep cover lama. JPG/PNG/GIF, max 2MB.</div>
                        @if($book->cover_url)
                            <div class="mt-3 p-3 bg-light rounded-3">
                                <small class="text-muted mb-1 d-block">Cover saat ini:</small>
                                <img src="{{ $book->cover_url }}" alt="Current" class="rounded img-thumbnail" style="max-height: 120px; object-fit: cover;">
                            </div>
                        @endif
                        @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    {{-- Legacy cover_url fallback removed - use cover_path only --}}
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle me-2"></i>Update Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
