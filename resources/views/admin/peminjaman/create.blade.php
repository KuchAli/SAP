@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold">Tambah Peminjaman</h3>
        <small class="text-muted">Isi data peminjaman dengan benar</small>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="mb-3">
                        <label>User</label>
                        <select name="user_id" class="form-control" required>
                            @foreach($user as $u)
                                <option value="{{ $u->user_id }}">{{ $u->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Buku</label>
                        <select name="buku_id" class="form-control" required>
                            @foreach($buku as $b)
                                <option value="{{ $b->id_buku }}">{{ $b->judul_buku }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="dipinjam">Pinjam</option>
                            <option value="dikembalikan">Kembalikan</option> 
                        </select>
                    </div>

                </div>

                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary ">
                        Simpan Peminjaman
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection