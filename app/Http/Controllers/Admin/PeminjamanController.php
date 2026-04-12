<?php

namespace App\Http\Controllers\Admin;

use App\Models\Peminjaman;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Pengembalian;
use App\Models\Transaksi;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::all(); // Ambil semua data peminjaman
        return view('admin.peminjaman.index', compact('peminjaman')); // Logika untuk menampilkan daftar peminjaman
    }

    public function create()
    {
        $user = User::where('role', 'anggota')->get(); // Ambil semua data user untuk dropdown
        $buku = Buku::all(); // Ambil semua data buku untuk dropdown
        return view('admin.peminjaman.create', compact('user', 'buku')); // Logika untuk menampilkan form peminjaman baru
    }

   

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'id_buku' => 'required|exists:bukus,id_buku',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
        ]);

        DB::transaction(function () use ($request) {
            $buku = Buku::findOrFail($request->id_buku);

            if ($buku->stok <= 0) {
                return back()->with('error', 'Stok buku habis');
            }

            $buku->decrement('stok');

            $peminjaman = Peminjaman::create([
                'user_id' => $request->user_id,
                'id_buku' => $request->id_buku,
                'tanggal_peminjaman' => $request->tanggal_peminjaman,
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'status' => 'dipinjam',
            ]);
            $tarif = Tarif::where('jenis_tarif', 'peminjaman')->firstOrFail();

            $total = $tarif->tarif;

            Transaksi::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_tarif' => $tarif->id_tarif,
                'total_bayar' => $total,
                'jenis_transaksi' => 'peminjaman',
                'tanggal_transaksi' => now(),
            ]);
        });

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman & transaksi berhasil dibuat');
    }

    public function edit($id)
    {
        $buku = Buku::all();
        $user = User::where('role', 'anggota')->get(); // Ambil semua data user untuk dropdown
        $peminjaman = Peminjaman::findOrFail($id);
        return view('admin.peminjaman.edit', compact('peminjaman','user','buku')); // Logika untuk menampilkan form edit peminjaman
    }

   

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'id_buku' => 'required|exists:bukus,id_buku',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
            'status' => 'required|in:dipinjam,dikembalikan,rusak,terlambat',
        ]);

        // 🔥 SIMPAN STATUS LAMA
        $statusLama = $peminjaman->status;

        $data = [
            'user_id' => $request->user_id,
            'id_buku' => $request->id_buku,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => $request->status,
        ];

        $peminjaman->update($data);

        // 🔥 LOGIC UTAMA
        if ($statusLama == 'dipinjam' && $request->status == 'dikembalikan') {

            // CEK BIAR GA DOUBLE
            $cek = Pengembalian::where('id_peminjaman', $peminjaman->id_peminjaman)->first();

            if (!$cek) {
                Pengembalian::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'tanggal_pengembalian' => $peminjaman->tanggal_pengembalian  
                ]);
            }
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    }
}
