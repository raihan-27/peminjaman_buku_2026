@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-list-check me-2 text-primary"></i>Kelola Peminjaman
    </h2>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            Semua Peminjaman ({{ $loans->count() }})
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
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
                                <div>{{ $loan->user->name }}</div>
                                <small class="text-muted">{{ $loan->user->email }}</small>
                            </td>
                            <td>
                                <strong>{{ Str::limit($loan->book->title, 30) }}</strong>
                                <br><small>{{ $loan->book->author }}</small>
                            </td>
                            <td>{{ $loan->loaned_at_local?->format('d M Y, H:i') ?? '-' }} WIB</td>
                            <td>
                                @if($loan->due_at_local && $loan->due_at_local->lt(now()) && !$loan->return_date)
                                    <span class="badge bg-danger">{{ $loan->due_at_local->format('d M Y, H:i') }} WIB <i class="bi bi-clock-history"></i></span>
                                @else
                                    {{ $loan->due_at_local?->format('d M Y, H:i') ?? '-' }} WIB
                                @endif
                            </td>
                            <td>
                                @switch($loan->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">Disetujui</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-secondary">Ditolak</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($loan->status == 'pending')
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="{{ route('admin.loans.approve', $loan) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui peminjaman ini? Stok buku akan berkurang.')" title="Setujui">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.loans.reject', $loan) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak peminjaman ini?')" title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="badge bg-light text-dark">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                                <p class="text-muted">Belum ada peminjaman</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

