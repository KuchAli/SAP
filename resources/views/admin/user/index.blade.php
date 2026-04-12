@extends('layouts.main')
@section('title','Daftar Anggota')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-0">Daftar Anggota</h3>
            <small class="text-muted">Data seluruh anggota perpustakaan</small>
            <h4 class=" fw-semibold text-danger">Untuk <i>Admin</i> Gabisa diedit!</h4>
        </div>

        <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm">
            + Tambah Anggota
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
                <div class="card border-0 rounded mb-4 outline-none justify-content-between d-flex">
                    <!-- Search & Sort -->
                    <form method="GET" action="{{ route('admin.user.index') }}" 
                        class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label for="search" class="form-label mb-1">Search</label>
                            <input 
                                type="text" 
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search name or email..."
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
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($anggota as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $item->name }}
                            </td>

                            <td>{{ $item->email }}</td>

                            <td>
                                @if($item->role == 'admin')
                                    <span class="badge bg-primary">Admin</span>
                                @else
                                    <span class="badge bg-secondary">Anggota</span>
                                @endif
                            </td>


                            <td class="text-center">
                                <a href="{{ route('admin.user.edit', $item->user_id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('admin.user.destroy', $item->user_id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data anggota
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