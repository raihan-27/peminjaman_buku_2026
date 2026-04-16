<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peminjaman Buku') - Aii Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #355f52;
            --primary-deep: #25463c;
            --accent: #b38b59;
            --success: #4a7c59;
            --warning: #b98538;
            --danger: #b04a4a;
            --ink: #24312d;
            --muted: #6e766f;
            --line: #e7dac7;
            --shadow: 0 16px 34px rgba(65, 48, 31, 0.08);
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, .brand-title { font-family: 'Cormorant Garamond', serif; }
        body {
            background:
                radial-gradient(circle at top left, rgba(179, 139, 89, 0.14), transparent 22%),
                radial-gradient(circle at bottom right, rgba(53, 95, 82, 0.12), transparent 20%),
                linear-gradient(135deg, #f8f3ea 0%, #f4eee2 50%, #f8f5ef 100%);
            color: var(--ink);
        }
        .page-shell { min-height: calc(100vh - 152px); animation: pageReveal 0.45s ease; }
        .navbar {
            background:
                linear-gradient(135deg, rgba(37, 70, 60, 0.97), rgba(53, 95, 82, 0.95)),
                repeating-linear-gradient(90deg, rgba(255,255,255,0.03) 0 12px, transparent 12px 24px) !important;
            box-shadow: var(--shadow);
            padding: 0.9rem 1rem;
            border-bottom: 1px solid rgba(236, 217, 184, 0.22);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.35rem;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
        }
        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(236, 217, 184, 0.24), rgba(179, 139, 89, 0.3));
            border: 1px solid rgba(255, 244, 224, 0.2);
            color: #f9ebcf;
        }
        .nav-link {
            font-weight: 600;
            border-radius: 999px;
            padding: 0.55rem 0.9rem !important;
            color: rgba(255, 250, 241, 0.88) !important;
            transition: background-color 0.25s ease, transform 0.25s ease, color 0.25s ease;
        }
        .nav-link:hover, .nav-link:focus {
            color: #fff !important;
            background: rgba(255, 244, 224, 0.12);
            transform: translateY(-1px);
        }
        .nav-icon-badge, .action-icon-badge {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(179, 139, 89, 0.18), rgba(236, 217, 184, 0.16));
            color: var(--accent);
            margin-right: 0.55rem;
            flex-shrink: 0;
        }
        .account-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.45rem 0.6rem 0.45rem 0.5rem;
            border-radius: 999px;
            background: rgba(255, 249, 240, 0.12);
            border: 1px solid rgba(255, 244, 224, 0.14);
        }
        .account-avatar {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #c39a66, #8a6a43);
            color: #fff7ea;
            font-weight: 800;
            font-size: 0.92rem;
        }
        .dropdown-menu {
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 0.55rem;
            box-shadow: 0 18px 36px rgba(36, 49, 45, 0.12);
            background: rgba(255, 252, 247, 0.98);
            backdrop-filter: blur(14px);
        }
        .dropdown-item {
            border-radius: 12px;
            padding: 0.7rem 0.9rem;
            font-weight: 600;
            color: var(--ink);
        }
        .dropdown-item:hover { background: #f4ecdf; color: var(--primary-deep); }
        .card {
            border: 1px solid rgba(231, 218, 199, 0.9);
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: all 0.28s ease;
            background: rgba(255, 252, 247, 0.92);
            backdrop-filter: blur(10px);
        }
        .card:hover { box-shadow: 0 22px 40px rgba(56, 42, 26, 0.1); transform: translateY(-3px); }
        .btn {
            border-radius: 14px;
            font-weight: 700;
            transition: all 0.25s ease;
            padding: 0.7rem 1rem;
            letter-spacing: 0.01em;
        }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-deep)); border-color: transparent; }
        .btn-success { background: linear-gradient(135deg, var(--success), var(--primary)); border-color: transparent; }
        .btn-outline-primary { border-color: rgba(53, 95, 82, 0.28); color: var(--primary-deep); background: rgba(255, 252, 247, 0.78); }
        .btn-outline-secondary { border-color: rgba(110, 118, 111, 0.25); color: #5a615a; background: rgba(255,255,255,0.72); }
        .btn:hover { transform: translateY(-2px); }
        .table { border-radius: 18px; overflow: hidden; }
        .table th { background: #f3ebde; color: #5c554a; font-weight: 700; border-top: none; }
        .table-hover tbody tr:hover { background-color: #fbf6ee; }
        .alert {
            border-radius: 16px;
            border: 1px solid transparent;
            box-shadow: 0 12px 28px rgba(56, 42, 26, 0.06);
        }
        .alert-success { background: #edf7ef; border-color: #cfe3d3; color: #31553b; }
        .alert-danger { background: #fcf0ee; border-color: #ecd1cc; color: #874340; }
        .badge { font-weight: 500; padding: .375em .75em; }
        .footer {
            background: linear-gradient(135deg, #223b34, #2c5146);
            color: #ece3d2;
            padding: 1.5rem 0;
            margin-top: 3rem;
            border-top: 1px solid rgba(236, 217, 184, 0.16);
        }
        @keyframes pageReveal {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .navbar-nav { text-align: center; }
            .card-body { padding: 1rem; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span class="brand-mark"><i class="bi bi-journal-richtext"></i></span>
                <span class="brand-title">Aii Library</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(session('user'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <span class="account-pill">
                                    <span class="account-avatar">{{ strtoupper(substr(session('user.name'), 0, 1)) }}</span>
                                    <span>{{ session('user.name') }} ({{ session('user.role') }})</span>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><span class="action-icon-badge"><i class="bi bi-house-door"></i></span>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><span class="action-icon-badge"><i class="bi bi-person-vcard"></i></span>Profil Saya</a></li>
                                @if(session('user.role') == 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.books') }}"><span class="action-icon-badge"><i class="bi bi-journals"></i></span>Kelola Buku</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.loans') }}"><span class="action-icon-badge"><i class="bi bi-clipboard-data"></i></span>Kelola Peminjaman</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Keluar?')">
                                            <span class="action-icon-badge"><i class="bi bi-door-open"></i></span>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @if(session('user.role') == 'user')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('books') }}"><span class="nav-icon-badge"><i class="bi bi-journals"></i></span>Buku</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('peminjaman') }}"><span class="nav-icon-badge"><i class="bi bi-journal-arrow-up"></i></span>Peminjaman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengembalian') }}"><span class="nav-icon-badge"><i class="bi bi-arrow-counterclockwise"></i></span>Pengembalian</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/"><span class="nav-icon-badge"><i class="bi bi-door-open"></i></span>Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4 page-shell">
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Error!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer text-center mt-auto py-2 small" style="font-size: 0.8rem; opacity: 0.9;">
        <div class="container">
            <p class="mb-0">&copy; 2026 Aii Library. Dirancang untuk pengalaman perpustakaan yang hangat dan modern.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
