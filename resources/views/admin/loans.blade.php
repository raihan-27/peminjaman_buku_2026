@extends('layouts.app')

@section('title', 'Kelola Peminjaman')
@section('subtitle', 'Persetujuan dan monitoring seluruh request pinjaman')

@section('content')
<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-clipboard-check"></i>
                Admin
            </div>
            <h1 class="page-hero-title">Kelola Peminjaman</h1>
            <p class="page-hero-subtitle">Setujui atau tolak.</p>
        </div>
        <span class="soft-badge soft-badge-info">
            <i class="bi bi-list-check"></i>
            {{ $loans->count() }} data
        </span>
    </div>
</div>

<div class="surface-card table-shell fade-in-up delay-1">
    <div class="table-toolbar">
        <h4 class="table-toolbar-title">Semua Peminjaman</h4>
        <p class="table-toolbar-copy">Pending, disetujui, dan ditolak ditampilkan dalam satu tabel</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                    <tr>
                        <td><strong>#{{ $loan->id }}</strong></td>
                        <td>
                            <strong>{{ $loan->user->name }}</strong>
                            <small class="d-block soft-text">{{ $loan->user->email }}</small>
                        </td>
                        <td>
                            <strong>{{ Str::limit($loan->book->title, 30) }}</strong>
                            <small class="d-block soft-text">{{ $loan->book->author }}</small>
                        </td>
                        <td>{{ $loan->loaned_at_local?->format('d M Y, H:i') ?? '-' }} WIB</td>
                        <td>
                            {{ $loan->due_at_local?->format('d M Y, H:i') ?? '-' }} WIB
                        </td>
                        <td>
                            @switch($loan->status)
                                @case('pending')
                                    <span class="soft-badge soft-badge-warning">Pending</span>
                                    @break
                                @case('approved')
                                    <span class="soft-badge soft-badge-success">Disetujui</span>
                                    @break
                                @case('rejected')
                                    <span class="soft-badge soft-badge-danger">Ditolak</span>
                                    @break
                                @default
                                    <span class="soft-badge soft-badge-info">{{ ucfirst($loan->status) }}</span>
                            @endswitch
                        </td>
                        <td>
                            @if($loan->status === 'pending')
                                <div class="d-flex gap-2">
                                    <form method="POST" action="{{ route('admin.loans.approve', $loan) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui peminjaman ini? Stok buku akan berkurang.')">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.loans.reject', $loan) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Tolak peminjaman ini?')">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="soft-badge soft-badge-info">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state border-0 shadow-none p-0">
                                <div class="empty-state-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>
                                <h5 class="mb-2">Belum ada peminjaman</h5>
                                <p class="soft-text mb-0">Data peminjaman akan muncul di sini ketika user mulai mengajukan permintaan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
