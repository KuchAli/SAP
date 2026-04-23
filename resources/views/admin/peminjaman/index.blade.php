@extends('layouts.main')
@section('title', 'Daftar Peminjaman')

@section('content')
<!-- Content here -->

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Data Peminjaman</h3>
            <small class="text-muted">Kelola data peminjaman buku</small>
        </div>

        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-sm btn-primary">
            + Tambah Peminjaman
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('info'))
                <div class="alert alert-warning">{{ session('info') }}</div>
            @endif
            <div class="card border-0 rounded mb-4 outline-none justify-content-between d-flex">
                    <!-- Search & Sort -->
                    <form method="GET" action="{{ route('admin.peminjaman.index') }}" 
                        class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label for="search" class="form-label mb-1">Search</label>
                            <input 
                                type="text" 
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama atau status..."
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-2">
                            <label for="status" class="form-label mb-1">Filter Status</label>
                            <select name="status" onchange="this.form.submit()" class="form-select">
                                <option value="">Semua</option>
                                <option value="dipinjam" {{ request('status')=='dipinjam'?'selected':'' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ request('status')=='dikembalikan'?'selected':'' }}>Dikembalikan</option>
                            </select>
                        </div>

                        <div class="col-md-2 ms-auto d-flex justify-content-end">
                            <button class="btn btn-sm btn-primary">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>

                    </form>

                </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($peminjaman as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $p->user->name }}
                            </td>

                            <td class="fw-semibold">
                                {{ $p->buku->judul_buku }}
                            </td>

                            <td>{{ $p->tanggal_peminjaman }}</td>
                            <td>{{ $p->tanggal_pengembalian }}</td>

                            <td>
                                @if($p->status == 'dipinjam')
                                    <span class="badge bg-warning">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.peminjaman.edit', $p->id_peminjaman) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.peminjaman.destroy', $p->id_peminjaman) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus peminjaman?')" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data peminjaman
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="mt-4">
                    {{ $peminjaman->links() }}
                </div>
            </div>

        </div>
    </div>

</div>

@endsection