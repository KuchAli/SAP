@extends('layouts.main')
@section('title', 'Dashboard Admin')
@section('content')

    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

    <p>Selamat datang di dashboard admin perpustakaan!</p>

    <div class="row">

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
            <h6>Total Buku</h6>
            <h3>{{ $totalBuku }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
            <h6>Buku Dipinjam</h6>
            <h3>{{ $bukuDipinjam }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
            <h6>Pengembalian Hari Ini</h6>
            <h3>{{ $kembaliHariIni }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
            <h6>Terlambat</h6>
            <h3>{{ $terlambat }}</h3>
        </div>
            
        

    </div>

    <div class="card mt-4 shadow-sm rounded-5">
        <div class="card-header">
            <strong>Buku Paling Sering Dipinjam</strong>
        </div>

        <ul class="list-group list-group-flush">
            @foreach ($dataBuku as $b )
                <span>{{ $b->judul }}</span>
                <img src="{{ asset('storage/' . $b->gambar_buku) }}" alt="Gambar Buku" class="img-thumbnail" style="width: 50px; height: 50px;">
            @endforeach
            @foreach($bukuPopuler as $buku)
            <li class="list-group-item d-flex justify-content-between">
            <span class="badge bg-primary">
                {{ $buku }}x
            </span>
            </li>
            @endforeach
        </ul>
    </div>
@endsection