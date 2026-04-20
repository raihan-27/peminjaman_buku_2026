@extends('layouts.app')

@section('title', $member->name)
@section('subtitle', 'Detail anggota dan histori peminjaman')

@section('content')
<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-person"></i>
                Detail Anggota
            </div>
            <h1 class="page-hero-title">{{ $member->name }}</h1>
            <p class="page-hero-subtitle">Lihat data kontak, tanggal terdaftar, dan riwayat peminjaman terbaru.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('members.edit', $member) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="surface-card fade-in-up delay-1">
            <div class="surface-card-header">
                <h5 class="mb-0">Informasi Anggota</h5>
            </div>
            <div class="surface-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Nama</div>
                            <div class="fw-semibold">{{ $member->name }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">No HP</div>
                            <div class="fw-semibold">{{ $member->phone }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Alamat</div>
                            <div class="fw-semibold">{{ $member->address }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric-card h-100">
                            <div class="metric-label">Terdaftar</div>
                            <div class="fw-semibold">{{ $member->created_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($member->loans()->exists())
            <div class="surface-card fade-in-up delay-2 mt-4">
                <div class="surface-card-header">
                    <h5 class="mb-0">Riwayat Peminjaman</h5>
                </div>
                <div class="surface-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Batas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($member->loans()->latest()->take(10)->get() as $loan)
                                    <tr>
                                        <td>{{ Str::limit($loan->book->title, 30) }}</td>
                                        <td>{{ $loan->loan_date->format('d M Y') }}</td>
                                        <td>{{ $loan->due_date->format('d M Y') }}</td>
                                        <td>
                                            @if($loan->return_date)
                                                <span class="soft-badge soft-badge-success">Selesai</span>
                                            @else
                                                <span class="soft-badge soft-badge-info">Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="surface-card fade-in-up delay-2 h-100">
            <div class="surface-card-header">
                <h5 class="mb-0">Aksi</h5>
            </div>
            <div class="surface-card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('members.edit', $member) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Edit
                    </a>
                    <a href="{{ route('loans.create') }}?member_id={{ $member->id }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Pinjam Buku
                    </a>
                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-grid" onsubmit="return confirm('Hapus {{ $member->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
