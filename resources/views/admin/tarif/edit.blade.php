@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold">Edit Tarif</h3>
        <small class="text-muted">Isi data tarif dengan benar</small>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.tarif.update', $tarif->id_tarif) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Tarif</label>
                        <select name="jenis_tarif" class="form-select">
                            <option value="peminjaman">Peminjaman</option>
                            <option value="kerusakan">Kerusakan</option>
                            <option value="terlambat">Terlambat</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tarif Per Kategori</label>
                        <input type="number" name="tarif" class="form-control" step="0.01" value="{{ $tarif->tarif }}">
                    </div>


                </div>

                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.tarif.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-success ">
                        Update Tarif
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection