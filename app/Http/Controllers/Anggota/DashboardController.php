<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;


class DashboardController extends Controller
{
     public function index()
    {
        $userId = auth()->id();

        // total semua buku
        $totalBuku = Buku::count();

        // buku yang sedang dipinjam user
        $bukuDipinjam = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();

        // total riwayat peminjaman user
        $riwayatPinjam = Peminjaman::where('user_id', $userId)->count();

        $search = request('search');

        // buku terbaru
        $bukuTerbaru = Buku::when($search, function ($q) use ($search) {
            $q->where(function ($q2) use ($search) {
                $q2->where('judul_buku', 'like', "%$search%")
                ->orWhere('penulis', 'like', "%$search%")
                ->orWhere('penerbit', 'like', "%$search%");
            });
        })
        ->latest()
         ->latest()
        ->paginate(8);

        return view('anggota.dashboard', compact(
            'totalBuku',
            'bukuDipinjam',
            'riwayatPinjam',
            'bukuTerbaru'
        ));
    }
}
