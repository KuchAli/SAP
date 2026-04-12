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

   <div class="card mt-4 shadow-sm rounded-5 border-0">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 fw-bold">📚 Buku Paling Sering Dipinjam</h6>
        </div>

        <ul class="list-group list-group-flush">

            @foreach ($dataBuku as $b)
            <li class="list-group-item d-flex align-items-center justify-content-between">

                {{-- LEFT SIDE --}}
                <div class="d-flex align-items-center gap-4">

                    <img src="{{ asset('storage/' . $b->gambar_buku) }}"
                        alt="Gambar Buku"
                        class=" shadow-sm"
                        style="width:45px; height:45px; object-fit:cover;">

                    <div>
                        <div class="fw-semibold">
                            {{ $b->judul_buku }}
                        </div>
                        <div>
                         Penulis :  <small class="text-muted">{{ $b->penulis ?? '-' }}</small>
                        </div>
                        <div>
                            Penerbit: <small class="text-muted">{{ $b->penerbit ?? '-' }}</small>
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDE --}}
                <span class="badge bg-primary rounded-pill">
                    Total Peminjaman: 
                    {{ $b->peminjaman_count }}x
                </span>

            </li>
            @endforeach

        </ul>
        <div class="mt-4">
            {{ $dataBuku -> links() }}
        </div>
    </div>
@endsection