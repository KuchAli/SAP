@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Edit Buku</h3>
            <small class="text-muted">Perbarui data buku dengan benar</small>
        </div>
    </div>

    <div class="row">

        {{-- FORM --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="{{ route('admin.buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul_buku" class="form-control"
                                   value="{{ $buku->judul_buku }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control"
                                   value="{{ $buku->penulis }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control"
                                   value="{{ $buku->penerbit }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control"
                                   value="{{ $buku->tahun_terbit }}">
                        </div>
                         <div class="mb-3">
                            <label for="">Kategori</label>
                            <select name="id_kategori" class="form-control">
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}"
                                        {{ $buku->id_kategori == $k->id ? 'selected' : '' }}>
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                         </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control"
                                   value="{{ $buku->stok }}">
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Ganti Cover (opsional)</label>
                            <input type="file" name="gambar_buku" class="form-control" accept="image/*"
                                   onchange="previewImage(event)">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                        </div>

                        <button class="btn btn-primary w-100">
                            Update Buku
                        </button>

                    </form>

                </div>
            </div>
        </div>

        {{-- PREVIEW --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <strong>Preview Cover</strong>
                </div>

                <div class="card-body text-center">

                    <img id="preview"
                         src="{{ $buku->gambar_buku ? asset('storage/'.$buku->gambar_buku) : 'https://via.placeholder.com/300x400?text=No+Image' }}"
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 420px; object-fit: cover;">

                    <p class="mt-3 text-muted">Cover saat ini</p>

                </div>
            </div>
        </div>

    </div>

</div>

{{-- SCRIPT PREVIEW --}}
<script>
function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
    }

    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection