@extends('layouts.app')

@section('title', 'Daftar Anggota')
@section('subtitle', 'Kelola data anggota perpustakaan')

@section('content')
<div class="page-hero fade-in-up">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <div class="page-hero-kicker">
                <i class="bi bi-people"></i>
                Anggota
            </div>
            <h1 class="page-hero-title">Daftar Anggota</h1>
            <p class="page-hero-subtitle">Data anggota ditampilkan dalam panel yang bersih agar mudah dikelola oleh admin.</p>
        </div>
        <a href="{{ route('members.create') }}" class="btn btn-success">
            <i class="bi bi-person-plus me-2"></i>Tambah Anggota
        </a>
    </div>
</div>

@if($members->isEmpty())
    <div class="empty-state fade-in-up delay-1">
        <div class="empty-state-icon">
            <i class="bi bi-people"></i>
        </div>
        <h4 class="mb-2">Belum ada anggota</h4>
        <p class="soft-text mb-4">Tambahkan anggota pertama untuk mulai mengelola data perpustakaan.</p>
        <a href="{{ route('members.create') }}" class="btn btn-success">
            <i class="bi bi-person-plus me-2"></i>Tambah Anggota
        </a>
    </div>
@else
    <div class="surface-card table-shell fade-in-up delay-1">
        <div class="table-toolbar">
            <h4 class="table-toolbar-title">Data Anggota</h4>
            <p class="table-toolbar-copy">Nama, kontak, alamat, dan status peminjaman aktif</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Peminjaman Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $index => $member)
                        <tr>
                            <td><strong>{{ ($members->firstItem() ?? 0) + $index + 1 }}</strong></td>
                            <td>
                                <strong>{{ $member->name }}</strong>
                                <small class="d-block soft-text">ID: {{ $member->id }}</small>
                            </td>
                            <td>
                                <i class="bi bi-telephone soft-text me-1"></i>{{ $member->phone }}
                                <small class="d-block soft-text">{{ Str::limit($member->address, 30) }}</small>
                            </td>
                            <td>{{ Str::limit($member->address, 40) }}</td>
                            <td>
                                @php $active = $member->loans()->whereNull('return_date')->count(); @endphp
                                @if($active > 0)
                                    <span class="soft-badge soft-badge-warning">{{ $active }} Aktif</span>
                                @else
                                    <span class="soft-badge soft-badge-success">Tersedia</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('members.show', $member) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('members.edit', $member) }}" class="btn btn-outline-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus {{ $member->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
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
        @if($members->hasPages())
            <div class="surface-card-body border-top">
                {{ $members->links() }}
            </div>
        @endif
    </div>
@endif
@endsection
