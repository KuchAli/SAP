
<nav class="navbar navbar-dark shadow-sm" style="background:#009688;">
    <div class="container px-2">

        {{-- BARIS ATAS --}}
        <div class="d-flex w-100 align-items-center">

            {{-- BRAND --}}
            <a class="navbar-brand fw-semibold"
               href="{{ route('anggota.dashboard') }}">
                Aplikasi Perpustakaan
            </a>

          {{-- User Dropdown --}}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown">

                        <div class="rounded-circle bg-white text-dark d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <span>{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                        </div>

                        <span class="ms-2 text-white">
                            {{ Auth::user()->name ?? 'User' }}
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>

        {{-- BARIS BAWAH (MENU) --}}
        <div class="w-100 mt-2">
            <ul class="navbar-nav d-flex flex-row gap-3">

                <li class="nav-item">
                    <a class="nav-link nav-strip d-flex align-items-center gap-2 {{ request()->routeIs('anggota.dashboard') ? 'active fw-semibold' : '' }}"
                       href="{{ route('anggota.dashboard') }}">
                        <i class="bi bi-house-door"></i>
                        <span class="nav-text">Home</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-strip d-flex align-items-center gap-2 {{ request()->routeIs('anggota.buku.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('anggota.buku.index') }}">
                        <i class="bi bi-book"></i>
                        <span class="nav-text">Daftar Buku</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link nav-strip d-flex align-items-center gap-2 {{ request()->routeIs('anggota.peminjaman.index') ? 'active fw-semibold' : '' }}"
                       href="{{ route('anggota.peminjaman.index') }}">
                        <i class="bi bi-calendar-check"></i>
                        <span class="nav-text">Peminjaman</span>
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>