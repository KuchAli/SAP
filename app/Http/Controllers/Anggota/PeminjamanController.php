<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tarif;
use App\Models\Transaksi;

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

        DB::transaction(function () use ($request) {
            $buku = Buku::findOrFail($request->id_buku);

            if ($buku->stok <= 0) {
                return back()->with('error', 'Stok buku habis');
            }

            $buku->decrement('stok');

            $peminjaman = Peminjaman::create([
                'user_id' => Auth::id(),
                'id_buku' => $request->id_buku,
                'tanggal_peminjaman' => now(),
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'status' => 'dipinjam',
            ]);
            $tarif = Tarif::where('jenis_tarif', 'peminjaman')->firstOrFail();

            $total = $tarif->tarif;

            $tanggal_transaksi= $peminjaman->tanggal_peminjaman;

            Transaksi::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_tarif' => $tarif->id_tarif,
                'total_bayar' => $total,
                'jenis_transaksi' => 'peminjaman',
                'tanggal_transaksi' => $tanggal_transaksi,
            ]);
        });

        return back()->with('success', 'Buku berhasil dipinjam');
    }
}
