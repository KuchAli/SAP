<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['peminjaman', 'tarif'])
            ->latest()
            ->get();

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $peminjaman = Peminjaman::all();
        $tarif = Tarif::all();

        return view('admin.transaksi.create', compact('peminjaman', 'tarif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'id_tarif' => 'required|exists:tarifs,id_tarif',
            'total_bayar' => 'required|numeric',
            'jenis_transaksi' => 'required|in:peminjaman,denda',
            'tanggal_transaksi' => 'required|date',
        ]);

        Transaksi::create([
            'id_peminjaman' => $request->id_peminjaman,
            'id_tarif' => $request->id_tarif,
            'total_bayar' => $request->total_bayar,
            'jenis_transaksi' => $request->jenis_transaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['peminjaman', 'tarif'])
            ->findOrFail($id);

        return view('admin.transaksi.show', compact('transaksi'));
    }
    public function dendaTerlambat($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $tarif = Tarif::where('jenis_tarif', 'terlambat')->first();

        $tanggalKembali = $peminjaman->tanggal_kembali;
        $sekarang = now();

        $hariTerlambat = 0;

        if ($sekarang > $tanggalKembali) {
            $hariTerlambat = $sekarang->diffInDays($tanggalKembali);
        }

        if ($hariTerlambat <= 0) {
            return back()->with('info', 'Tidak ada keterlambatan');
        }

        $total = $hariTerlambat * $tarif->tarif;

        // cegah double denda
        $cek = Transaksi::where('id_peminjaman', $id)
            ->where('jenis_transaksi', 'denda_terlambat')
            ->exists();

        if ($cek) {
            return back()->with('error', 'Denda terlambat sudah ada');
        }

        Transaksi::create([
            'id_peminjaman' => $id,
            'id_tarif' => $tarif->id_tarif,
            'total_bayar' => $total,
            'jenis_transaksi' => 'denda_terlambat',
            'tanggal_transaksi' => now(),
        ]);

        return back()->with('success', 'Denda terlambat dibuat');
    }

    public function dendaKerusakan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $tarif = Tarif::where('jenis_tarif', 'kerusakan')->first();

        if (!$tarif) {
            return back()->with('error', 'Tarif kerusakan belum ada');
        }

        // cegah double
        $cek = Transaksi::where('id_peminjaman', $id)
            ->where('jenis_transaksi', 'denda_kerusakan')
            ->exists();

        if ($cek) {
            return back()->with('error', 'Denda kerusakan sudah ada');
        }

        Transaksi::create([
            'id_peminjaman' => $id,
            'id_tarif' => $tarif->id_tarif,
            'total_bayar' => $tarif->tarif,
            'jenis_transaksi' => 'denda_kerusakan',
            'tanggal_transaksi' => now(),
        ]);

        return back()->with('success', 'Denda kerusakan ditambahkan');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}