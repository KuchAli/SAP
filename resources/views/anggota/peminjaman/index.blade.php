@extends('layouts.main')

@section('title', 'Peminjaman Buku')

@section('content')

{{-- FORM PINJAM --}}
<div class="container me-4 ">
    
    <div class="card card-soft p-4 mb-5">
    
        <h5 class="fw-bold mb-3">Pinjam Buku</h5>
    
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <form action="{{ route('anggota.peminjaman.store') }}" method="POST">
            @csrf
    
            <div class="mb-3">
                <label class="form-label">Pilih Buku</label>
                <select name="id_buku" class="form-select" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($buku as $b)
                        <option value="{{ $b->id_buku }}">
                            {{ $b->judul_buku }} (Stok: {{ $b->stok }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Tanggal Pengembalian</label>
                <input type="date" name="tanggal_pengembalian" class="form-control" required>
            </div>
    
            <button class="btn btn-success mt-3">
                <i class="bi bi-journal-plus"></i> Pinjam
            </button>
    
        </form>
    </div>
    
    {{-- LIST PEMINJAMAN --}}
    <div class="card card-soft p-4">
    
        <h5 class="fw-bold mb-3">Peminjaman Saya</h5>
    
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
    
            <tbody>
                @forelse($peminjaman as $p)
                    <tr>
                        <td>{{ $p->buku->judul_buku }}</td>
                        <td>{{ $p->tanggal_pinjam }}</td>
                        <td>
                            @php
                                $statusClass = match($p->status) {
                                    'dipinjam' => 'bg-success',
                                    'dikembalikan' => 'bg-secondary',
                                    'terlambat' => 'bg-warning',
                                    default => 'bg-danger'
                                };
                            @endphp

                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Belum ada peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $peminjaman->links() }}
        </div>
    
    </div>
</div>

@endsection