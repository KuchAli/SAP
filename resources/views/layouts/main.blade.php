<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Perpustakaan</title>

    {{-- Bootstrap saja (hapus Tailwind biar clean) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
        background: #f4f6fb;
        font-family: 'Inter', sans-serif;
    }

    /* SIDEBAR */
    .sidebar {
        width: 270px;
        background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
        border-right: 1px solid #eef0f4;
        min-height: 100vh;
        box-shadow: 8px 0 20px rgba(0,0,0,0.03);
    }

    .sidebar h5 {
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #4f46e5;
    }

    /* NAV LINK */
    .nav-link {
        color: #374151 !important;
        transition: all 0.2s ease;
    }

    .nav-link:hover {
        background: #eef2ff;
        color: #4f46e5 !important;
        transform: translateX(3px);
    }

    /* ACTIVE MENU */
    .nav-link.active {
        background: #4f46e5;
        color: #fff !important;
    }
    /* NAVBAR */
    .navbar-top {
        height: 65px;
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid #eef0f4;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    /* CONTENT */
    .content-area {
        padding: 24px;
    }

    /* CARD STYLE (IMPORTANT) */
    .card-soft {
        border: none;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .card-soft:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 40px rgba(0,0,0,0.08);
    }
</style>
</head>

<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    @auth
        <div class="p-4 ">

            <h5 class="fw-bold mb-3 text-secondary text-center ">📚 Perpustakaan</h5>

            @php
                $role = auth()->user()->role;
            @endphp

            @if($role === 'admin')
                @include('layouts.sidebar.admin')

            @elseif($role === 'anggota')
                @include('layouts.sidebar.anggota');
            @endif

        </div>
    @endauth


    {{-- MAIN --}}
    <div class="flex-grow-1">

        {{-- NAVBAR --}}
        <div class="navbar-top d-flex align-items-center justify-content-between px-4 rounded-5 mt-3">

            <div class="text-muted text-md fw-semibold">
                @php
                    $route = Route::currentRouteName();
                    $title = explode('.', $route)[1];

                    $map = [
                        'dashboard' => 'Dashboard',
                        'buku' => 'Data Buku',
                        'peminjaman' => 'Data Peminjaman',
                        'pengembalian' => 'Data Pengembalian',
                        'user' => 'Data Anggota',
                        'tarif' => 'Data Tarif',
                        'transaksi' => 'Data Transaksi',
                    ];
                @endphp

                {{ $map[$title] ?? ucfirst($title) }}
            </div>

            <div class="fw-semibold">
                {{ auth()->user()->name ?? 'Guest' }}
            </div>

        </div>

        {{-- CONTENT --}}
        <div class="content-area">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>