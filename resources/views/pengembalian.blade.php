@extends('layouts.app')

@section('title', 'Pengembalian Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-arrow-return-left me-2 text-warning"></i>Pengembalian Buku
    </h2>
</div>

@if($activeLoans->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-inbox display-1 text-muted mb-4"></i>
        <h4 class="text-muted mb-4">Tidak ada buku yang dipinjam</h4>
        <a href="{{ route('books') }}" class="btn btn-primary">
            <i class="bi bi-book me-2"></i>Lihat Buku
        </a>
    </div>
@else
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Buku Aktif ({{ $activeLoans->count() }})</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Jatuh Tempo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeLoans as $loan)
                        <tr>
                            <td>
                                <strong>{{ $loan->book->title }}</strong>
                                <br><small class="text-muted">{{ $loan->book->author }}</small>
                            </td>
                            <td>{{ $loan->loaned_at_local?->format('d M Y, H:i') ?? '-' }} WIB</td>
                            <td>
                                @if($loan->due_at_local && $loan->due_at_local->lt(now()))
                                    <span class="badge bg-danger fs-6">
                                        {{ $loan->due_at_local->format('d M Y, H:i') }} WIB 
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </span>
                                @else
                                    <span class="badge bg-info">{{ $loan->due_at_local?->format('d M Y, H:i') ?? '-' }} WIB</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('pengembalian.process', $loan->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Kembalikan buku {{ $loan->book->title }} sekarang?')">
                                        <i class="bi bi-check-circle"></i> Kembalikan Sekarang
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

