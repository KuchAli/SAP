@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Edit Anggota</h3>
            <small class="text-muted">Perbarui data anggota</small>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.user.update', $user->user_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ $user->name }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ $user->email }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a type="button" class=" btn   btn-secondary mt-4 "href="{{ route('admin.user.index') }}">
                        Kembali
                    </a>
                    <button class="btn btn-success  mt-4 ">
                        Update Data
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection