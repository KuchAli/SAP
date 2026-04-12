<aside class="bg-white border-end shadow-sm vh-50 p-3 rounded-4" style="width: 260px;">

    {{-- HEADER --}}
    <div class="mb-4">
      
        <small class="text-muted ">Panel: Admin Panel</small>
    </div>
    <hr class="border-dark">

    {{-- MENU --}}
    <div class="nav flex-column gap-1">

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

            <span><i class="bi bi-house"></i></span> Dashboard
        </a>

        <a href="{{ route('admin.buku.index') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg   {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">

            <span><i class="bi bi-book"></i></span> Buku
        </a>

        <a href="{{ route('admin.user.index') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">

            <span><i class="bi bi-person"></i></span> Anggota
        </a>

        <a href="{{ route('admin.tarif.index') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg {{ request()->routeIs('admin.tarif.*') ? 'active' : '' }}">

            <span><i class="bi bi-cash"></i></span> Tarif
        </a>

        <a href="{{ route('admin.peminjaman.index') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">

            <span><i class="bi bi-box-seam"></i></span> Peminjaman
        </a>

        <a href="{{ route('admin.pengembalian.index') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg {{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">

            <span><i class="bi bi-card-text"></i></span> Pengembalian
        </a>

        <a href="{{ route('admin.transaksi.index') }}"
           class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-dark hover-bg {{ request()->routeIs('admin.transaksi.*') ? 'active' : ''}}">

            <span><i class="bi bi-wallet"></i></span> Transaksi
        </a>

        <hr>
         <div class="nav-link d-flex align-items-center mt-2 gap-2 px-3 py-2 rounded-3 text-dark hover-bg">
            
             <form method="POST" action="{{ route('logout') }}">
                 @csrf
                 <button type="submit" class="dropdown-item rounded-2 text-danger"><span><i class="bi bi-box-arrow-left"></i></span> Logout</button>
             </form>
        </div>
        
    </div>

</aside>