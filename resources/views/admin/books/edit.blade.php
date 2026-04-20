@extends('layouts.app')

@section('title', 'Edit Buku - ' . $book->title)
@section('subtitle', 'Perbarui data dan cover buku admin')

@section('content')
<div class="form-shell">
    <div class="page-hero">
        <div class="page-hero-kicker">
            <i class="bi bi-pencil-square text-warning"></i>
            Edit Buku Admin
        </div>
        <h1 class="page-hero-title">{{ $book->title }}</h1>
        <p class="page-hero-subtitle">Edit detail, ganti cover (kosongkan jika tetap pakai lama).</p>
    </div>

    <div class="form-panel">
        <div class="form-panel-header">
            <h5><i class="bi bi-journal-text me-2"></i>{{ $book->title }} (ID: {{ $book->id }})</h5>
        </div>
        <div class="form-panel-body">
            <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('title') is-invalid @enderror" name="title" value="{{ old('title', $book->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">Pengarang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('author') is-invalid @enderror" name="author" value="{{ old('author', $book->author) }}" required>
                        @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('publisher') is-invalid @enderror" name="publisher" value="{{ old('publisher', $book->publisher) }}" required>
                        @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                        <input type="number" class="form-control soft-input @error('year') is-invalid @enderror" name="year" value="{{ old('year', $book->year) }}" min="1900" max="2100" required>
                        @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control soft-input @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $book->stock) }}" min="0" max="100" required>
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control soft-input @error('category') is-invalid @enderror" name="category" value="{{ old('category', $book->category) }}" required>
                        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Ganti Cover</label>
                        <input type="file" class="form-control soft-input @error('cover') is-invalid @enderror" name="cover" accept="image/*" id="coverInput">
                        <div class="form-text">Kosongkan = keep lama. JPG/PNG/GIF max 2MB.</div>
                        <div id="coverPreviewWrap" class="mt-3 p-3 bg-light rounded-3 border d-none">
                            <small class="text-muted mb-2 d-block">Preview cover baru:</small>
                            <img id="coverPreview" src="" alt="Preview cover baru" class="rounded img-thumbnail shadow-sm" style="max-height: 180px; object-fit: cover;">
                        </div>
                        @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @if($book->cover_url)
                        <div class="col-12">
                            <label class="form-label fw-semibold">Cover Saat Ini</label>
                            <div class="p-3 bg-light rounded-3 border">
                                <img src="{{ $book->cover_url }}" alt="Current" class="rounded img-thumbnail shadow-sm" style="max-height: 150px; object-fit: cover;">
                                <div class="mt-2">
                                    <small class="text-muted">Path: {{ $book->cover_path }}</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="bi bi-image"></i> Belum ada cover
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2"></i> Update Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('coverInput');
    const previewWrap = document.getElementById('coverPreviewWrap');
    const previewImg = document.getElementById('coverPreview');

    if (!input || !previewWrap || !previewImg) {
        return;
    }

    input.addEventListener('change', function () {
        const file = this.files && this.files[0];

        if (!file) {
            previewWrap.classList.add('d-none');
            previewImg.removeAttribute('src');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            previewImg.src = event.target.result;
            previewWrap.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection

