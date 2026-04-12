@extends('layouts.Main')

@section('content')

<div class="card card-soft p-5">

    <h5 class="fw-bold mb-4">Detail Transaksi</h5>

    <div class="row">

        {{-- INFO TRANSAKSI --}}
        <div class="col-md-6 border-end border-3 pe-4">
            <table class="table table-borderless">
                <tr>
                    <th>Jenis Transaksi</th>
                    <td>{{ ucfirst($transaksi->jenis_transaksi) }}</td>
                </tr>

                <tr>
                    <th>Tanggal</th>
                    <td>{{ $transaksi->tanggal_transaksi }}</td>
                </tr>

                <tr>
                    <th>Total Bayar</th>
                    <td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Tarif</th>
                    <td>{{ $transaksi->tarif->jenis_tarif }}</td>
                </tr>
            </table>
        </div>

        {{-- INFO PEMINJAMAN --}}
        <div class="col-md-6 ps-4">
            <table class="table table-borderless">
                <tr>
                    <th>Nama User</th>
                    <td>{{ $transaksi->peminjaman->user->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Buku</th>
                    <td>{{ $transaksi->peminjaman->buku->judul_buku }}</td>
                </tr>

                <tr>
                    <th>Tanggal Pinjam</th>
                    <td>{{ $transaksi->peminjaman->tanggal_peminjaman }}</td>
                </tr>

                <tr>
                    <th>Pengembalian</th>
                    <td>{{ $transaksi->peminjaman->tanggal_pengembalian }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge 
                            @if($transaksi->peminjaman->status == 'dipinjam') bg-warning text-dark
                            @elseif($transaksi->peminjaman->status == 'terlambat') bg-danger
                            @else bg-success
                            @endif
                        ">
                            {{ ucfirst($transaksi->peminjaman->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        
    </div>
    
</div>
<a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary mt-3 "><i class="bi bi-arrow-left"></i> Kembali</a>

@endsection