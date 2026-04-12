@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Detail Pengembalian</h4>
    <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-secondary btn-sm">Back</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>Info Pengembalian</h5>
    </div>

    <div class="card-body">

        <div class="row mb-2">
            <div class="col-md-4 fw-bold">Peminjaman</div>
            <div class="col-md-8">
                {{ $pengembalian->peminjaman->user->name }}
                - {{ $pengembalian->peminjaman->buku->judul_buku }}
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-bold">Tanggal Pengembalian</div>
            <div class="col-md-8">
                {{ $pengembalian->tanggal_pengembalian }}
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-bold">Tanggal Pinjam</div>
            <div class="col-md-8">
                {{ $pengembalian->peminjaman->tanggal_peminjaman }}
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-bold">Status:</div>
            <div class="col-md-8">
                @if($pengembalian->peminjaman->status == 'dipinjam')
                    <span class="badge bg-warning text-dark">Di Pinjam</span>
                @else
                    <span class="badge bg-success">Di Kembalikan</span>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection