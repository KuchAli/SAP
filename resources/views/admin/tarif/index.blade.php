@extends('layouts.main')
@section('title', 'Daftar Tarif')

@section('content')
<!-- Content here -->

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Data Tarif</h3>
            <small class="text-muted">Kelola data tarif perpustakaan</small>
        </div>
        @if ($bolehTambah)
        
        <a href="{{ route('admin.tarif.create') }}" class="btn btn-sm  btn-primary">
            + Tambah Tarif
        </a>
        @endif
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
             @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if(session('info'))
                    <div class="alert alert-warning">{{ session('info') }}</div>
                @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Tarif</th>
                            <th>Tarif Per Kategori</th>
                            <th>Dibuat Pada</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($tarif as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $t->jenis_tarif }}
                            </td>

                            <td>Rp {{ number_format($t->tarif, 0, ',', '.') }}</td>
                          

                            <td>{{ $t->created_at->format('d M Y') }}</td>

                            <td class="text-center">

                                <form action="{{ route('admin.tarif.destroy', $t->id_tarif) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus tarif?')" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection