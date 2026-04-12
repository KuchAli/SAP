@extends('layouts.main')

@section('content')
<div class="container me-4">

    

    {{-- STATISTIK --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-body text-center">
                    <h5>Total Buku</h5>
                    <h3 class="text-primary">{{ $totalBuku }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-body text-center">
                    <h5>Buku Dipinjam</h5>
                    <h3 class="text-warning">{{ $bukuDipinjam }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-body text-center">
                    <h5>Riwayat Pinjam</h5>
                    <h3 class="text-success">{{ $riwayatPinjam }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="card mb-4 shadow-sm rounded-4 gap-3">
        <div class="card-body">
            <form action="{{ route('anggota.dashboard') }}" method="GET">
                <div class="input-group">
                       <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Cari judul atau penulis buku...">
                        <button class="btn btn-success "><i class="bi bi-search"></i></button>
                    </div>
            </form>
        </div>
    </div>

    {{-- BUKU POPULER / TERBARU --}}
    <h5 class="mb-3">Buku Terbaru</h5>

    <div class="row">
        @foreach($bukuTerbaru as $b)
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm rounded-4">
                
                <img src="{{ asset('storage/' . $b->gambar_buku) }}"
                     class="card-img-top"
                     style="height: 200px; object-fit: cover;">

                <div class="card-body">
                    <h6 class="fw-bold">{{ $b->judul_buku }}</h6>
                    <small class="text-muted">Penulis : {{ $b->penulis }}</small>
                </div>

                <div class="card-footer bg-white border-0">
                    <a href=""
                       class="btn btn-sm btn-outline-success w-100">
                        Lihat Detail
                    </a>
                </div>

            </div>
        </div>
        @endforeach
        
    </div>

</div>
@endsection