@extends('layouts.main')
@section('title', 'Tambah Transaksi')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold">Tambah Transaksi</h3>
        <small class="text-muted">Input data transaksi peminjaman atau denda</small>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.transaksi.store') }}" method="POST">
                @csrf

                {{-- PEMINJAMAN --}}
                <div class="mb-3">
                    <label class="form-label">Peminjaman</label>
                    <select name="id_peminjaman" class="form-control" required>
                        <option value="">-- Pilih Peminjaman --</option>
                        @foreach($peminjaman as $p)
                            <option value="{{ $p->id_peminjaman }}">
                                {{ $p->user->name }} - {{ $p->buku->judul_buku }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TARIF --}}
                <div class="mb-3">
                    <label class="form-label">Tarif</label>
                    <select name="id_tarif" class="form-control" required>
                        <option value="">-- Pilih Tarif --</option>
                        @foreach($tarif as $t)
                            <option value="{{ $t->id_tarif }}">
                                Rp {{ number_format($t->tarif,0,',','.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TOTAL --}}
                <div class="mb-3">
                    <label class="form-label">Total Bayar</label>
                    <input type="number" name="total_bayar" class="form-control" required>
                </div>

                {{-- JENIS --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Transaksi</label>
                    <select name="jenis_transaksi" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="peminjaman">Peminjaman</option>
                        <option value="denda">Denda</option>
                    </select>
                </div>

                {{-- TANGGAL --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="form-control" required>
                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Simpan Transaksi
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection