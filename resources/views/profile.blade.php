@extends('layouts.app')

@section('title', 'Profil Saya')
@section('subtitle', 'Kelola data profil akun Anda')

@section('content')

<style>
.profile-wrapper {
    min-height: 100vh;
    background-color: transparent;
    padding: 1rem 0 2rem;
}

/* Surface Cards */
.surface-card {
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.56), rgba(255, 255, 255, 0.42));
    border-radius: 28px;
    border: 1px solid rgba(226, 232, 240, 0.84);
    box-shadow: 0 24px 54px rgba(15, 23, 42, 0.08);
    overflow: hidden;
    backdrop-filter: blur(22px) saturate(1.05);
    position: relative;
}

@media (min-width: 992px) {
    .profile-wrapper .col-lg-6.mx-auto {
        max-width: 760px;
    }
}


/* Animations */
.fade-in-up { animation: fadeInUp 0.24s ease-out both; }
.delay-1 { animation-delay: 0.04s; }
.delay-2 { animation-delay: 0.08s; }
.delay-3 { animation-delay: 0.12s; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

/* Utility */
.profile-img-box {
    width: 116px;
    height: 116px;
    object-fit: cover;
    border-radius: 50%; /* Lingkaran penuh lebih profesional untuk profil */
    border: 5px solid rgba(255, 255, 255, 0.78);
    box-shadow: 0 16px 30px rgba(15, 23, 42, 0.12);
}
.profile-initial-box {
    width: 116px;
    height: 116px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5b5df6, #2563eb);
    color: #fff;
    font-size: 2.6rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 18px 34px rgba(91, 93, 246, 0.22);
    border: 5px solid rgba(255, 255, 255, 0.78);
}
.detail-item {
    padding: 0.9rem 1rem;
    border-bottom: 1px solid rgba(226, 232, 240, 0.76);
    background: rgba(248, 250, 252, 0.34);
    border-radius: 18px;
    margin-bottom: 0.65rem;
}
.detail-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.surface-card .btn {
    border-radius: 999px;
}

.surface-card .form-control,
.surface-card .form-control-sm {
    border-radius: 16px;
    border: 1px solid rgba(219, 228, 240, 0.92);
    background: rgba(255, 255, 255, 0.72);
    backdrop-filter: blur(10px);
}

.surface-card .form-control:focus,
.surface-card .form-control-sm:focus {
    border-color: rgba(91, 93, 246, 0.38);
    box-shadow: 0 0 0 4px rgba(91, 93, 246, 0.12);
}

.surface-card .border-top {
    border-color: rgba(226, 232, 240, 0.76) !important;
}
</style>

<div class="profile-wrapper">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 mx-auto">
                <div class="surface-card fade-in-up delay-1 h-100 p-4">
                    <div class="text-center mb-4">
                        @if($user->profile_picture)
                            <img src="{{ $user->profile_picture_url }}?t={{ time() }}" 
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

                            <!-- Success/Error Alerts -->
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="mb-3">
                                <label for="profile_picture" class="form-label fw-medium text-dark fs-6">
                                    <i class="bi bi-camera me-1"></i> Ganti Foto Profil
                                </label>
                                <!-- Preview Image -->
                                <div id="imagePreview" class="text-center mb-2 d-none">
                                    <img id="previewImg" src="" class="profile-img-box mx-auto mb-2 border" alt="Preview">
                                    <small class="text-muted">Preview (klik untuk ganti)</small>
                                </div>
                                <input type="file" 
                                       class="form-control form-control-sm @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" 
                                       name="profile_picture" 
                                       accept="image/*">
                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Maksimal 2MB (JPEG, PNG, JPG, GIF)</small>
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
        const file = input.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        // Check file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File terlalu besar! Maksimal 2MB.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('d-none');
            previewImg.onclick = () => input.click(); // Click preview to change
        };
        reader.readAsDataURL(file);
        
        console.log('Preview: ' + file.name + ' (' + (file.size/1024).toFixed(0) + 'KB)');
    } else {
        document.getElementById('imagePreview').classList.add('d-none');
    }
}

// Auto-dismiss alerts after 5s
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>

@endsection
