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

            <div class="table-responsive" >
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
                                @if($t->peminjaman->status  == 'dipinjam' )
                                    <span class="badge bg-success">Di Pinjam</span>
                                @elseif($t->peminjaman->status  == 'dikembalikan')
                                    <span class="badge bg-secondary">Di Kembalikan</span>
                                @elseif($t->peminjaman->status  == 'rusak')
                                    <span class="badge bg-danger">Rusak</span>
                                @elseif($t->peminjaman->status  == 'terlambat')
                                    <span class="badge bg-warning">Terlambat</span>
                                @endif 
                            </td>
                            <td class="text-center">
                                <div class="dropdown  position-static">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown"  >
                                        Aksi
                                    </button>

                                    <ul class="dropdown-menu position-absolute">

                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.transaksi.show', $t->id_transaksi) }}">
                                                Detail
                                            </a>
                                        </li>

                                        <li>
                                            <form action="{{ route('admin.transaksi.denda.terlambat', $t->id_peminjaman) }}" method="POST">
                                                @csrf
                                                <button class="dropdown-item">Denda Terlambat</button>
                                            </form>
                                        </li>

                                        <li>
                                            <form action="{{ route('admin.transaksi.denda.kerusakan', $t->id_peminjaman) }}" method="POST">
                                                @csrf
                                                <button class="dropdown-item">Denda Kerusakan</button>
                                            </form>
                                        </li>

                                        <li><hr class="dropdown-divider"></li>

                                        <li>
                                            <form action="{{ route('admin.transaksi.destroy', $t->id_transaksi) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </li>

                                    </ul>
                                </div>
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