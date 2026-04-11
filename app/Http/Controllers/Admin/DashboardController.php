<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;


class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku= Buku::count();
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $kembaliHariIni = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_pengembalian', now()->toDateString())
            ->count();
        $terlambat = Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_pengembalian', '<', now()->toDateString())
            ->count();

        $dataBuku = Buku::select('id_buku', 'judul_buku', 'penulis')->get();

        $bukuPopuler = Peminjaman::select('id_buku')
            ->groupBy('id_buku')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->get();
        return view('admin.dashboard', compact('totalBuku', 
                'bukuDipinjam', 'kembaliHariIni', 'terlambat', 
                'dataBuku', 'bukuPopuler'));
    }
}
