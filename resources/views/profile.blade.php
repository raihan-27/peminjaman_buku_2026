@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
@php
    $roleLabel = $user->role === 'admin' ? 'Administrator' : 'Pengguna';
    $roleClass = $user->role === 'admin' ? 'role-admin-badge' : 'role-user-badge';
@endphp

<style>
.profile-shell {
    min-height: 100vh;
    background:
        radial-gradient(circle at top left, rgba(179, 139, 89, 0.14), transparent 24%),
        radial-gradient(circle at bottom right, rgba(53, 95, 82, 0.14), transparent 22%),
        linear-gradient(135deg, #f8f2e8 0%, #f4ede1 48%, #f8f5ee 100%);
    padding: 1rem 0;
}
.profile-card,
.profile-stats .card,
.history-card {
    border-radius: 24px;
    border: 1px solid #e7dac7;
    background: rgba(255, 252, 247, 0.9);
    box-shadow: 0 18px 36px rgba(65, 48, 31, 0.08);
    animation: profileUp 0.6s ease both;
}
.profile-avatar {
    width: 96px;
    height: 96px;
    border-radius: 28px;
    background: linear-gradient(135deg, #b38b59, #7b5a35);
    box-shadow: 0 14px 28px rgba(179, 139, 89, 0.26);
}
.role-admin-badge {
    background: linear-gradient(135deg, #f0e2ca, #e4c08e);
    color: #7a4e1f;
}
.role-user-badge {
    background: linear-gradient(135deg, #dbe9df, #c9ddd1);
    color: #2f5a4e;
}
.history-card .card-header {
    background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(247,241,231,0.95));
    border-bottom: 1px solid #eadfce;
}
@keyframes profileUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="profile-shell">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card profile-card h-100">
                <div class="card-body text-center p-4">
                    <div class="profile-avatar text-white d-inline-flex align-items-center justify-content-center mb-3" style="font-size: 2rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 class="mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <span class="badge rounded-pill {{ $roleClass }} px-3 py-2">{{ $roleLabel }}</span>
                    <div class="mt-4 text-start">
                        <div class="mb-3">
                            <small class="text-muted d-block">Role</small>
                            <strong>{{ $user->role }}</strong>
                        </div>
                        <div>
                            <small class="text-muted d-block">Bergabung</small>
                            <strong>{{ $user->created_at?->format('d M Y, H:i') ?? '-' }} WIB</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row g-3 mb-4 profile-stats">
                <div class="col-md-3 col-6">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="fs-3 fw-bold" style="color:#355f52;">{{ $profileStats['total_loans'] }}</div>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="fs-3 fw-bold" style="color:#9a6a2d;">{{ $profileStats['pending_loans'] }}</div>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="fs-3 fw-bold" style="color:#4a7c59;">{{ $profileStats['active_loans'] }}</div>
                            <small class="text-muted">Aktif</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="fs-3 fw-bold" style="color:#7b5a35;">{{ $profileStats['returned_loans'] }}</div>
                            <small class="text-muted">Selesai</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card history-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>Riwayat Terakhir</h5>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Kembali ke Dashboard</a>
                </div>
                <div class="card-body p-0">
                    @if($recentLoans->isEmpty())
                        <div class="p-4 text-center text-muted">
                            Belum ada aktivitas peminjaman.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Pinjam</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentLoans as $loan)
                                        <tr>
                                            <td>
                                                <strong>{{ $loan->book->title ?? '-' }}</strong>
                                                <br><small class="text-muted">{{ $loan->book->author ?? '-' }}</small>
                                            </td>
                                            <td>{{ $loan->loaned_at_local?->format('d M Y, H:i') ?? '-' }} WIB</td>
                                            <td>{{ $loan->due_at_local?->format('d M Y, H:i') ?? '-' }} WIB</td>
                                            <td>
                                                @if($loan->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($loan->return_date)
                                                    <span class="badge bg-secondary">Dikembalikan</span>
                                                @elseif($loan->status === 'approved')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
