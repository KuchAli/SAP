@extends('layouts.main')
@section('title', 'Daftar Transaksi')

@section('content')
<!-- Content here -->

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Data Transaksi</h3>
            <small class="text-muted">Kelola data transaksi peminjaman dan pengembalian buku</small>
        </div>

       
       
        <a href="{{ route('admin.transaksi.create') }}" class="btn btn-sm btn-primary">
            + Tambah Transaksi
        </a>
        
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Peminjaman</th>
                            <th>Tarif</th>
                            <th>Total Bayar</th>
                            <th>Jenis Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transaksi as $t)
                        <tr>
                            <td>TRX-{{ str_pad($t->id_transaksi, 3, '0', STR_PAD_LEFT) }}</td>

                            <td class="fw-semibold">
                                {{ $t->peminjaman->user->name ?? '-' }} 
                                - 
                                {{ $t->peminjaman->buku->judul_buku ?? '-' }}
                            </td>

                            <td>{{ $t->tarif->tarif ?? '-' }}</td>

                            <td>{{ $t->total_bayar }}</td>

                            <td>{{ $t->jenis_transaksi }}</td>

                            <td>{{ $t->tanggal_transaksi }}</td>

                            <td>
                                {{ $t->peminjaman->status ?? '-' }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.transaksi.show', $t->id_transaksi) }}" 
                                class="btn btn-sm btn-info">
                                    Detail
                                </a>

                                <form action="{{ route('admin.transaksi.denda.terlambat', $p->id_peminjaman) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-warning btn-sm fw-bold">Denda Terlambat</button>
                                </form>
                                <form action="{{ route('admin.transaksi.denda.kerusakan', $p->id_peminjaman) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-warning btn-sm fw-bold">Denda Kerusakan</button>
                                </form>

                                <form action="{{ route('admin.transaksi.destroy', $t->id_transaksi) }}" 
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus transaksi?')" 
                                            class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Tidak ada data transaksi
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