@extends('layouts.main');
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
        @forelse($pengembalian as $p)
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">Peminjaman</div>
            <div class="col-md-8"> {{ $p->peminjaman->user->name }} - {{ $p->peminjaman->buku->judul_buku }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">Tanggal Pengembalian</div>
            <div class="col-md-8">{{ $p->tanggal_pengembalian }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">Tanggal Pinjam</div>
            <div class="col-md-8">{{ $p->peminjaman->tanggal_pinjam }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">Status:</div>
            <div class="col-md-8">
                @if($p->peminjaman->status == 'dipinjam')
                    <span class="badge bg-warning text-dark">Di Pinjam</span>
                @elseif($p->peminjaman->status == 'dikembalikan')
                    <span class="badge bg-success">Di Kembalikan</span>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection