<aside class="bg-white border-end shadow-sm vh-50 p-3 rounded-4" style="width: 260px;">

    {{-- HEADER --}}
    <div class="mb-4">
      
        <small class="text-muted ">Panel: Admin Panel</small>
    </div>
    <hr class="border-dark">

    {{-- MENU --}}
    <div class="nav flex-column gap-1">

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg">

            <span>🏠</span> Dashboard
        </a>

        <a href="{{ route('admin.buku.index') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg">

            <span>📖</span> Buku
        </a>

        <a href="{{ route('admin.user.index') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg">

            <span>👤</span> Anggota
        </a>

        <a href="#"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg">

            <span>💰</span> Tarif
        </a>

        <a href="#"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg">

            <span>📥</span> Peminjaman
        </a>

        <a href="#"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg">

            <span>📤</span> Pengembalian
        </a>

        <a href="#"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg">

            <span>🔄</span> Transaksi
        </a>

        <a href="#"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg">

            <span>📊</span> Laporan
        </a>

        <hr>

        <a href="" class="nav-link d-flex align-items-center mt-2 gap-2 px-3 py-2 rounded-3 text-dark hover-bg">
            <span>🚪</span> Logout
        </a>

    </div>

</aside>