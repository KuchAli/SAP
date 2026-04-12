@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-0">Daftar Buku</h3>
            <small class="text-muted">Berikut adalah daftar buku yang tersedia di perpustakaan</small>
        </div>

        <a href="{{ route('admin.buku.create') }}" class="btn btn-primary btn-sm">
            + Tambah Buku
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
                <div class="card border-0 rounded mb-4 outline-none justify-content-between d-flex">
                    <!-- Search & Sort -->
                    <form method="GET" action="{{ route('admin.buku.index') }}" 
                        class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label for="search" class="form-label mb-1">Search</label>
                            <input 
                                type="text" 
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="cari judul atau kategori..."
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-2">
                            <label for="sort" class="form-label mb-1">Sort By</label>
                            <select name="sort" onchange="this.form.submit()"
                                    class="form-select">
                                <option value="newest" {{ request('sort')=='newest'?'selected':'' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort')=='oldest'?'selected':'' }}>Terlama</option>
                                <option value="az" {{ request('sort')=='az'?'selected':'' }}>A - Z</option>
                                <option value="za" {{ request('sort')=='za'?'selected':'' }}>Z - A</option>
                            </select>
                        </div>

                        <div class="col-md-2 ms-auto d-flex justify-content-end">
                            <button class="btn btn-primary">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>

                    </form>

                </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($buku as $item)
                        <tr>
                            <td>BKU-{{ str_pad($item->id_buku, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="fw-semibold">{{ $item->judul_buku }}</td>
                            <td>{{ $item->penulis }}</td>
                            <td>{{ $item->kategori->name }}</td>
                            <td>
                                <span >
                                    {{ $item->stok }}
                                </span>
                            </td>
                            
                            <td>
                                <span>{{ $item->slug_buku }}</span>
                            </td>
                            <td>
                                @if($item->stok > 0)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-warning">Di Pinjam</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.buku.edit', $item->id_buku) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Tidak ada data buku
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection