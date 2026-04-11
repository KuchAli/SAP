<?php

namespace App\Http\Controllers\Admin;

use App\Models\Peminjaman;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

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
            'buku_id' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        Peminjaman::create([
            'user_id' => $request->user_id,
            'id_buku' => $request->id_buku,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return view('admin.peminjaman.edit', compact('peminjaman')); // Logika untuk menampilkan form edit peminjaman
    }

   

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        // 🔥 SIMPAN STATUS LAMA
        $statusLama = $peminjaman->status;

        $data = [
            'user_id' => $request->user_id,
            'id_buku' => $request->id_buku,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
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
                    'tanggal_pengembalian' => now(),
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
