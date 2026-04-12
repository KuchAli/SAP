@extends('layouts.main')

@section('title', 'Detail Buku')

@section('content')

<div class="row g-4">

    {{-- GAMBAR BUKU --}}
    <div class="col-md-4">
        <div class="card card-soft p-3 text-center">

            @if($buku->gambar_buku)
                <img src="{{ asset('storage/'.$buku->gambar_buku) }}"
                     class="img-fluid rounded"
                     style="max-height: 400px; object-fit: cover;">
            @else
                <div class="text-muted py-5">
                    Tidak ada gambar
                </div>
            @endif

        </div>
    </div>

    {{-- DETAIL INFO --}}
    <div class="col-md-8">
        <div class="card card-soft p-4">

            <h3 class="fw-bold mb-1">{{ $buku->judul_buku }}</h3>
            <p class="text-muted mb-4">oleh {{ $buku->penulis }}</p>

            <hr>

            <div class="row mb-2">
                <div class="col-4 text-muted">Penerbit</div>
                <div class="col-8">{{ $buku->penerbit ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-4 text-muted">Tahun Terbit</div>
                <div class="col-8">{{ $buku->tahun_terbit ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-4 text-muted">Stok</div>
                <div class="col-8">
                    <span class="badge bg-primary">
                        {{ $buku->stok }} tersedia
                    </span>
                </div>
            </div>

            <hr>

            {{-- ACTION --}}
            <div class="d-flex gap-2">

                <a href="{{ route('anggota.buku.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                @if($buku->stok > 0)
                    <a class="btn btn-primary" href="{{ route('anggota.peminjaman.index') }}">
                        <i class="bi bi-journal-plus"></i> Pinjam Buku
                    </a>
                @else
                    <button class="btn btn-danger" disabled>
                        Stok Habis
                    </button>
                @endif

            </div>

        </div>
    </div>

</div>

@endsection