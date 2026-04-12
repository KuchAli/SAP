@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Tambah Buku</h3>
            <small class="text-muted">Isi data buku dengan lengkap</small>
        </div>
    </div>

    <div class="row">

        {{-- FORM --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul_buku" class="form-control" placeholder="Masukkan judul buku" value="{{ old('judul_buku') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control" placeholder="Nama penulis"  value="{{ old('penulis') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" placeholder="Nama penerbit"  value="{{ old('penerbit') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control" placeholder="Tahun terbit buku"  value="{{ old('tahun_terbit') }}"required>
                        </div>

                        
                        <div class="mb-3">
                            <label class="from-label">Kategori</label>
                            <select name="id_kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" placeholder="Jumlah stok"  value="{{ old('stok') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cover Buku</label>
                            <input type="file" name="gambar_buku" class="form-control" accept="image/*"
                                onchange="previewImage(event)" required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Simpan Buku
                        </button>

                    </form>

                </div>
            </div>
        </div>

        {{-- PREVIEW GAMBAR --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <strong>Preview Cover</strong>
                </div>

                <div class="card-body text-center">

                    <img id="preview" src="https://via.placeholder.com/300x400?text=No+Image"
                        class="img-fluid rounded shadow-sm"
                        style="max-height: 420px; object-fit: cover;">

                </div>
            </div>
        </div>

    </div>

</div>

{{-- SCRIPT PREVIEW IMAGE --}}
<script>
function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function(){
        const img = document.getElementById('preview');
        img.src = reader.result;
    }

    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection