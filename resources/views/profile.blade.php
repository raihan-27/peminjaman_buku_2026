@extends('layouts.app')

@section('title', 'Profil Saya')
@section('subtitle', 'Kelola data profil akun Anda')

@section('content')

<style>
/* Modern Professional SaaS Theme - Profile Extension */
:root {
    --bg-body: #f8fafc;
    --text-dark: #0f172a;
    --text-muted: #64748b;
    --card-bg: #ffffff;
    --border-soft: #e2e8f0;
    
    --primary: #4f46e5;
    --primary-bg: #e0e7ff;
    --success: #059669;
    --success-bg: #d1fae5;
    --warning: #d97706;
    --warning-bg: #fef3c7;
    --info: #0284c7;
    --info-bg: #e0f2fe;
    --danger: #dc2626;
    --danger-bg: #fee2e2;
}

.profile-wrapper {
    min-height: 100vh;
    background-color: var(--bg-body);
    padding: 2rem 0;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Surface Cards */
.surface-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid var(--border-soft);
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    overflow: hidden;
}



/* Animations */
.fade-in-up { animation: fadeInUp 0.5s ease-out both; }
.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

/* Utility */
.profile-img-box {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%; /* Lingkaran penuh lebih profesional untuk profil */
    border: 3px solid var(--card-bg);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.profile-initial-box {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), #3b82f6);
    color: #fff;
    font-size: 2.5rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
}
.detail-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-soft);
}
.detail-item:last-child {
    border-bottom: none;
}
</style>

<div class="profile-wrapper">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 mx-auto">
                <div class="surface-card fade-in-up delay-1 h-100 p-4">
                    <div class="text-center mb-4">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/profile-pictures/' . $user->profile_picture) }}?t={{ time() }}" 
                                 alt="{{ $user->name }}" 
                                 class="profile-img-box mx-auto mb-3">
                        @else
                            <div class="profile-initial-box mx-auto mb-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <h3 class="mb-1 fw-bold fs-4 text-dark">{{ $user->name }}</h3>
                        <p class="text-muted mb-3">{{ $user->email }}</p>
                    </div>

                    <div class="text-start mt-4">
                        <div class="detail-item d-flex justify-content-between">
                            <span class="text-muted">Hak Akses</span>
                            <span class="fw-semibold text-dark text-capitalize">{{ $user->role }}</span>
                        </div>
                        <div class="detail-item d-flex justify-content-between">
                            <span class="text-muted">Bergabung</span>
                            <span class="fw-semibold text-dark">{{ $user->created_at?->format('d M Y') ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label fw-medium text-dark fs-6">
                                    <i class="bi bi-camera me-1"></i> Ganti Foto Profil
                                </label>
                                <input type="file" 
                                       class="form-control form-control-sm @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" 
                                       name="profile_picture" 
                                       accept="image/*"
                                       onchange="previewImage(this)">
                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Maksimal 2MB (JPEG, PNG, JPG)</small>
                                @error('profile_picture')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-medium">
                                <i class="bi bi-cloud-upload me-1"></i> Perbarui Foto
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log('Gambar dipilih:', input.files[0].name);
            // Tambahkan logika preview visual di sini jika ingin menampilkan gambar sebelum diupload
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection