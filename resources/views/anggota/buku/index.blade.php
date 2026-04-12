@extends('layouts.main')

@section('title', 'Daftar Buku')

@section('content')

<div class="container me-3">

    <div class="row g-3">
        <h3> Daftar Buku</h3>
    
        @foreach($buku as $b)
            <div class="col-md-3">
                <div class="card card-soft h-100">
    
                    @if($b->gambar_buku)
                        <img src="{{ asset('storage/'.$b->gambar_buku) }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    @endif
    
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $b->judul_buku }}</h6>
                        <small class="text-muted">{{ $b->penulis }}</small>
                    </div>
    
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('anggota.buku.show', $b->id_buku) }}"
                           class="btn btn-sm btn-success w-100">
                            Detail
                        </a>
                    </div>
    
                </div>
            </div>
        @endforeach
        <div class="mt-3">
            {{ $buku -> links() }}
        </div>
    
    </div>
</div>

@endsection