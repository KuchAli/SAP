@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Tambah Anggota</h3>
            <small class="text-muted">Isi data anggota dengan benar</small>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama lengkap"  value="{{ old('name') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email aktif" value="{{ old('email') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password minimal 8 karakter"> 
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="anggota" {{ old('role') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                </div>
                <div class="d-flex justify-content-end gap-2">

                    <a type="button" class=" btn  btn-secondary mt-4 " href="{{ route('admin.user.index') }}">
                        Kembali
                    </a>
                    <button class="btn btn-primary  mt-4 ">
                        Simpan Anggota
                    </button>
                </div>

    


            </form>

        </div>
    </div>

</div>

@endsection