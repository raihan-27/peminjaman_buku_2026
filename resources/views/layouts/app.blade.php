<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peminjaman Buku') - Aii Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
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
            --shell-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            min-height: 100vh;
            color: var(--text-dark);
            background-color: var(--bg-body);
            background-image:
                radial-gradient(circle at 15% 50%, rgba(79, 70, 229, 0.04), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(5, 150, 105, 0.04), transparent 25%);
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--text-dark);
            font-weight: 700;
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 290px minmax(0, 1fr);
        }

        .app-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.96);
            border-right: 1px solid var(--border-soft);
            box-shadow: 8px 0 30px rgba(15, 23, 42, 0.04);
            z-index: 20;
        }

        .sidebar-top {
            padding: 1.4rem 1.35rem 1rem;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            border-bottom: 1px solid var(--border-soft);
        }

        .sidebar-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--text-dark);
            text-decoration: none;
            margin-bottom: 0.9rem;
        }

        .sidebar-brand:hover {
            color: var(--text-dark);
        }

        .sidebar-brand-badge {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: linear-gradient(135deg, var(--primary), #2563eb);
            box-shadow: 0 10px 18px rgba(79, 70, 229, 0.18);
            flex-shrink: 0;
        }

        .sidebar-subtitle {
            color: var(--text-muted);
            margin-bottom: 0;
            font-size: 0.92rem;
        }

        .sidebar-nav {
            padding: 1rem;
            display: grid;
            gap: 0.65rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.9rem 1rem;
            border-radius: 14px;
            text-decoration: none;
            color: var(--text-dark);
            background: #f8fafc;
            border: 1px solid transparent;
            font-weight: 600;
            transition: transform 0.2s ease, border-color 0.2s ease, background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar-link:hover {
            transform: translateX(2px);
            border-color: #cbd5e1;
            background: #fff;
            color: var(--primary);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: var(--primary);
            border-color: rgba(79, 70, 229, 0.18);
        }

        .sidebar-link-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: var(--primary);
            border: 1px solid var(--border-soft);
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem 1.25rem;
            border-top: 1px solid var(--border-soft);
        }

        .sidebar-meta {
            display: grid;
            gap: 0.35rem;
            padding: 0.95rem 1rem;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid var(--border-soft);
            margin-bottom: 0.9rem;
        }

        .sidebar-meta-label {
            color: var(--text-muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 700;
        }

        .sidebar-meta-value {
            font-weight: 700;
            color: var(--text-dark);
        }

        .sidebar-logout {
            width: 100%;
            border-radius: 14px;
            padding: 0.8rem 1rem;
            font-weight: 700;
        }

        .app-main {
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .app-topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            padding: 0.95rem 1.6rem;
            margin: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border-soft);
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }

        .app-title-block {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .app-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0;
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .app-title {
            margin-bottom: 0;
            font-size: 1.1rem;
            letter-spacing: -0.03em;
            line-height: 1;
        }

        .app-subtitle {
            margin-bottom: 0;
            color: var(--text-muted);
            font-size: 0.8rem;
            line-height: 1;
        }

        .app-topbar-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: nowrap;
            justify-content: flex-end;
            margin-left: auto;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .role-admin {
            background: var(--primary-bg);
            color: var(--primary);
            border: 1px solid rgba(79, 70, 229, 0.2);
        }

        .role-user {
            background: var(--info-bg);
            color: var(--info);
            border: 1px solid rgba(2, 132, 199, 0.2);
        }

        .account-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.35rem 0.25rem 0.2rem;
            border-radius: 999px;
            background: transparent;
            border: 1px solid transparent;
            transition: background-color 0.2s ease, border-color 0.2s ease;
            cursor: pointer;
        }

        .account-pill:hover,
        .account-pill:focus-visible {
            background: rgba(239, 246, 255, 0.75);
            border-color: rgba(191, 219, 254, 0.7);
        }

        .account-avatar {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4f46e5, #2563eb);
            color: #fff;
            font-weight: 800;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .app-content {
            padding: 1.25rem;
            flex: 1;
        }

        .app-content-shell {
            min-height: calc(100vh - 180px);
        }

        .page-hero {
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid var(--border-soft);
            border-radius: 22px;
            box-shadow: var(--shell-shadow);
            padding: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .page-hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            background: #eef2ff;
            color: var(--primary);
            font-size: 0.84rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.9rem;
        }

        .page-hero-title {
            margin-bottom: 0.35rem;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            letter-spacing: -0.03em;
        }

        .page-hero-subtitle {
            color: var(--text-muted);
            margin-bottom: 0;
            max-width: 760px;
        }

        .page-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .surface-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border-soft);
            border-radius: 20px;
            box-shadow: var(--shell-shadow);
            overflow: hidden;
        }

        .surface-card-header {
            padding: 1.15rem 1.35rem;
            border-bottom: 1px solid var(--border-soft);
            background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.94));
        }

        .surface-card-body {
            padding: 1.35rem;
        }

        .metric-grid {
            display: grid;
            gap: 1rem;
        }

        .metric-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            padding: 1.15rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            height: 100%;
        }

        .metric-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.35rem;
        }

        .metric-value {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
            color: var(--text-dark);
        }

        .soft-text {
            color: var(--text-muted);
        }

        .book-cover-thumb {
            width: 54px;
            height: 74px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid var(--border-soft);
            background: #f8fafc;
        }

        .soft-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border-radius: 999px;
            padding: 0.5rem 0.8rem;
            font-weight: 700;
            font-size: 0.84rem;
        }

        .soft-badge-info { background: var(--info-bg); color: var(--info); }
        .soft-badge-success { background: var(--success-bg); color: var(--success); }
        .soft-badge-warning { background: var(--warning-bg); color: var(--warning); }
        .soft-badge-danger { background: #fee2e2; color: var(--danger); }

        .table-shell {
            overflow: hidden;
        }

        .table-toolbar {
            padding: 1.15rem 1.35rem;
            border-bottom: 1px solid var(--border-soft);
            background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.94));
        }

        .table-toolbar-title {
            margin-bottom: 0.2rem;
            font-weight: 800;
        }

        .table-toolbar-copy {
            margin-bottom: 0;
            color: var(--text-muted);
        }

        .empty-state {
            padding: 3.5rem 1.5rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border-soft);
            border-radius: 22px;
            box-shadow: var(--shell-shadow);
        }

        .empty-state-icon {
            width: 84px;
            height: 84px;
            border-radius: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: var(--primary);
            background: var(--primary-bg);
        }

        .form-shell {
            max-width: 920px;
            margin: 0 auto;
        }

        .form-panel {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border-soft);
            border-radius: 22px;
            box-shadow: var(--shell-shadow);
            overflow: hidden;
        }

        .form-panel-header {
            padding: 1.15rem 1.35rem;
            border-bottom: 1px solid var(--border-soft);
            background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.94));
        }

        .form-panel-body {
            padding: 1.35rem;
        }

        .soft-input,
        .soft-select,
        .soft-textarea {
            border-radius: 14px;
            border-color: #dbe4f0;
            background: #fff;
            box-shadow: none;
        }

        .soft-input:focus,
        .soft-select:focus,
        .soft-textarea:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.14);
        }

        .app-alert {
            border-radius: 16px;
            border: 1px solid transparent;
            box-shadow: 0 12px 28px rgba(56, 42, 26, 0.06);
        }

        .app-alert-success {
            background: #edf7ef;
            border-color: #cfe3d3;
            color: #31553b;
        }

        .app-alert-danger {
            background: #fcf0ee;
            border-color: #ecd1cc;
            color: #874340;
        }

        .dropdown-menu {
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            padding: 0.55rem;
            box-shadow: 0 18px 36px rgba(36, 49, 45, 0.12);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(14px);
            z-index: 2000;
        }

        .dropdown-item {
            border-radius: 12px;
            padding: 0.7rem 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .dropdown-item:hover {
            background: #eef2ff;
            color: var(--primary);
        }

        .action-icon-badge,
        .nav-icon-badge {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(191, 219, 254, 0.16));
            color: var(--primary);
            margin-right: 0.55rem;
            flex-shrink: 0;
        }

        .app-footer {
            padding: 1rem 1.25rem 1.35rem;
        }

        .app-footer-inner {
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid var(--border-soft);
            color: var(--text-muted);
            text-align: center;
            padding: 0.9rem 1rem;
        }

        .page-shell {
            min-height: 100%;
            animation: pageReveal 0.45s ease;
        }

        .fade-in-up { animation: fadeInUp 0.5s ease-out both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn {
            border-radius: 14px;
            font-weight: 700;
            transition: all 0.25s ease;
            padding: 0.7rem 1rem;
            letter-spacing: 0.01em;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #2563eb);
            border-color: transparent;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #10b981);
            border-color: transparent;
        }

        .btn-outline-primary {
            border-color: rgba(79, 70, 229, 0.28);
            color: var(--primary);
            background: rgba(255, 255, 255, 0.78);
        }

        .btn-outline-secondary {
            border-color: rgba(100, 116, 139, 0.22);
            color: #475569;
            background: rgba(255, 255, 255, 0.72);
        }

        .table {
            border-radius: 18px;
            overflow: hidden;
        }

        .table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            border-top: none;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fbff;
        }

        @keyframes pageReveal {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 991.98px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .app-sidebar {
                position: relative;
                height: auto;
            }

            .app-topbar {
                margin: 0;
            }

            .app-content {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .app-topbar {
                flex-direction: row;
                align-items: center;
                top: 0;
                padding: 0.85rem 1rem;
                gap: 1rem;
            }

            .app-topbar-meta {
                width: auto;
                justify-content: flex-end;
                margin-left: auto;
            }
        }
    </style>
</head>
<body>
@php
    $sessionUser = session('user');
    $role = session('user.role', 'guest');
    $isLoggedIn = (bool) $sessionUser;
    $isAdmin = $role === 'admin';
    $pageTitle = trim($__env->yieldContent('title', 'Dashboard'));
    $pageSubtitle = $__env->yieldContent('subtitle', $isAdmin ? 'Panel administrasi perpustakaan' : 'Panel pengguna perpustakaan');
@endphp

@if($isLoggedIn)
    <div class="app-shell">
        <aside class="app-sidebar">
            <div class="sidebar-top">
                <a class="sidebar-brand" href="{{ route('dashboard') }}">
                    <span class="sidebar-brand-badge"><i class="bi bi-journal-richtext"></i></span>
                    <span>Aii Library</span>
                </a>
                <p class="sidebar-subtitle">aii.nugrahaa
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="sidebar-link-icon"><i class="bi bi-house-door"></i></span>
                    Dashboard
                </a>

                @if($isAdmin)
                    <a href="{{ route('admin.books') }}" class="sidebar-link {{ request()->routeIs('admin.books*') ? 'active' : '' }}">
                        <span class="sidebar-link-icon"><i class="bi bi-journals"></i></span>
                        Kelola Buku
                    </a>
                    <a href="{{ route('admin.loans') }}" class="sidebar-link {{ request()->routeIs('admin.loans*') ? 'active' : '' }}">
                        <span class="sidebar-link-icon"><i class="bi bi-clipboard-check"></i></span>
                        Kelola Peminjaman
                    </a>
                @else
                    <a href="{{ route('books') }}" class="sidebar-link {{ request()->routeIs('books') ? 'active' : '' }}">
                        <span class="sidebar-link-icon"><i class="bi bi-journals"></i></span>
                        Buku
                    </a>
                    <a href="{{ route('peminjaman') }}" class="sidebar-link {{ request()->routeIs('peminjaman*') ? 'active' : '' }}">
                        <span class="sidebar-link-icon"><i class="bi bi-journal-arrow-up"></i></span>
                        Daftar Buku
                    </a>
                    <a href="{{ route('pengembalian') }}" class="sidebar-link {{ request()->routeIs('pengembalian*') ? 'active' : '' }}">
                        <span class="sidebar-link-icon"><i class="bi bi-arrow-counterclockwise"></i></span>
                        Pengembalian
                    </a>
                @endif

            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-meta">
                    <span class="sidebar-meta-label">Role</span>
                    <span class="sidebar-meta-value">{{ $isAdmin ? 'Administrator' : 'Pengguna' }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger sidebar-logout" onclick="return confirm('Keluar dari akun ini?')">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="app-main">
            <header class="app-topbar">
                <div class="app-title-block">
                    <div class="app-kicker">
                        <i class="bi bi-stars"></i>
                        Aii Library
                    </div>
                    <h1 class="app-title mb-0">@yield('title', 'Dashboard')</h1>
                    <p class="app-subtitle">@yield('subtitle', $isAdmin ? 'Panel administrasi perpustakaan' : 'Panel pengguna perpustakaan')</p>
                </div>
                <div class="app-topbar-meta">
                    <span class="role-badge {{ $isAdmin ? 'role-admin' : 'role-user' }} d-none d-md-inline-flex">
                        <i class="bi {{ $isAdmin ? 'bi-shield-check' : 'bi-person-check' }}"></i>
                        {{ $isAdmin ? 'Admin' : 'User' }}
                    </span>
                    <div class="dropdown">
                        <a class="account-pill text-decoration-none text-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if($sessionUser['profile_picture'] ?? false)
                                <img src="{{ asset('storage/profile-pictures/' . $sessionUser['profile_picture']) }}?t={{ time() }}" 
                                     alt="{{ $sessionUser['name'] }}" 
                                     class="rounded-2"
                                     style="width: 32px; height: 32px; object-fit: cover; border: 1px solid rgba(79, 70, 229, 0.2);">
                            @else
                                <span class="account-avatar">{{ strtoupper(substr($sessionUser['name'] ?? 'U', 0, 1)) }}</span>
                            @endif
                            <span class="d-none d-lg-inline" style="font-size: 0.85rem;">{{ $sessionUser['name'] ?? 'User' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><span class="action-icon-badge"><i class="bi bi-person-vcard"></i></span>Profil Saya</a></li>
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
                    </div>
                </div>
            </header>

            <main class="app-content">
                <div class="app-content-shell">
                    @if ($errors->any())
                        <div class="alert app-alert app-alert-danger">
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
                        <div class="alert app-alert app-alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert app-alert app-alert-danger alert-dismissible fade show">
                            <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer class="app-footer">
                <div class="app-footer-inner small">
                    &copy; 2026 Aii Library. Dirancang untuk pengalaman perpustakaan yang hangat dan modern.
                </div>
            </footer>
        </div>
    </div>
@else
    <div class="app-main">
        <header class="app-topbar" style="margin-bottom: 0;">
            <div class="app-title-block">
                <div class="app-kicker">
                    <i class="bi bi-journal-richtext"></i>
                    Aii Library
                </div>
                <h1 class="app-title mb-0">@yield('title', 'Peminjaman Buku')</h1>
                <p class="app-subtitle">@yield('subtitle', 'Sistem perpustakaan digital')</p>
            </div>
            <div class="app-topbar-meta">
                <a href="/" class="btn btn-primary">Login</a>
            </div>
        </header>

        <main class="app-content">
            <div class="app-content-shell">
                @if ($errors->any())
                    <div class="alert app-alert app-alert-danger">
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
                    <div class="alert app-alert app-alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert app-alert app-alert-danger alert-dismissible fade show">
                        <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="app-footer">
            <div class="app-footer-inner small">
                &copy; 2026 Aii Library. Dirancang untuk pengalaman perpustakaan yang hangat dan modern.
            </div>
        </footer>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
