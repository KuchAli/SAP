<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;


class BukuController extends Controller
{
     /**
     * Tampilkan daftar buku untuk anggota
     */
    public function index()
    {
        $buku = Buku::latest()->paginate(5);

        return view('anggota.buku.index', compact('buku'));
    }

    /**
     * (opsional) detail buku
     */
    public function show($id)
    {
        $buku = Buku::findOrFail($id);

        return view('anggota.buku.show', compact('buku'));
    }
}
