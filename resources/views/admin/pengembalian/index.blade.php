@extends('layouts.main')
@section('title', 'Daftar Peminjaman')

@section('content')
<!-- Content here -->

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Data Pengembalian</h3>
            <small class="text-muted">Kelola data pengembalian buku</small>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pengembalian as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">
                                {{ $p->peminjaman->user->name }} - {{ $p->peminjaman->buku->judul_buku }}
                            </td>
                            <td>{{ $p->tanggal_pengembalian }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pengembalian.show', $p->id_pengembalian) }}" class="btn btn-sm btn-info">
                                    Detail
                                </a>
                                <form action="{{ route('admin.pengembalian.destroy', $p->id_pengembalian) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus pengembalian?')" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data pengembalian
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