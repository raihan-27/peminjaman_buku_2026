 @extends('layouts.app')

@section('title', 'Kelola Buku')
@section('subtitle', 'Daftar lengkap buku dengan aksi admin')

@section('content')
<div class="page-hero">
    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center gap-4">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-gear"></i>
                Admin Buku
            </div>
            <h1 class="page-hero-title">Kelola Buku</h1>
            <p class="page-hero-subtitle">Tambah, edit, hapus buku lengkap dengan cover dan status stok.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Buku
            </a>
            <a href="{{ route('books') }}" class="btn btn-outline-primary">
                <i class="bi bi-eye me-2"></i>Lihat Publik
            </a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-label">Total Buku</div>
            <div class="metric-value">{{ $books->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-label">Dengan Cover</div>
            <div class="metric-value">{{ $books->whereNotNull('cover_path')->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-label">Stok Tersedia</div>
            <div class="metric-value text-success">{{ $books->where('stock', '>', 0)->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-label">Stok Kosong</div>
            <div class="metric-value text-danger">{{ $books->where('stock', 0)->count() }}</div>
        </div>
    </div>
</div>

<div class="surface-card table-shell">
    <div class="table-toolbar">
        <h4 class="table-toolbar-title">Kelola Koleksi Buku</h4>
        <p class="table-toolbar-copy">Lihat cover, edit data, kelola stok, hapus buku</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books->sortBy('title') as $index => $book)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td>
                            @if($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="book-cover-thumb rounded" loading="lazy">
                            @else
                                <div class="book-cover-thumb d-flex align-items-center justify-content-center text-muted rounded" style="background: rgba(248, 250, 252, 0.58); backdrop-filter: blur(10px);">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ Str::limit($book->title, 30) }}</strong>
                            <small>ID #{{ $book->id }}</small>
                        </td>
                        <td>{{ Str::limit($book->author, 20) }}</td>
                        <td>{{ $book->year }}</td>
                        <td>
                            <span class="soft-badge {{ $book->stock > 0 ? 'soft-badge-success' : 'soft-badge-danger' }}">
                                <i class="bi {{ $book->stock > 0 ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                {{ $book->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="soft-badge soft-badge-info">
                                <i class="bi bi-bookmark-star"></i>
                                {{ $book->category ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Hapus {{ $book->title }}?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

