<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * INDEX = FORM CREATE + LIST DATA
     */
    public function index()
    {
        $buku = Buku::where('stok', '>', 0)->get();

        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(5);

        return view('anggota.peminjaman.index', compact('buku', 'peminjaman'));
    }

    /**
     * STORE PEMINJAMAN
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:bukus,id_buku',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
        ]);

        Peminjaman::create([
            'user_id' => Auth::id(),
            'id_buku' => $request->id_buku,
            'tanggal_peminjaman' => now(),
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'dipinjam',
        ]);

        // kurangi stok
        $buku = Buku::findOrFail($request->id_buku);
        $buku->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjam');
    }
}
