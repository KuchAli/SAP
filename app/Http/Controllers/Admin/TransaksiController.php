<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Models\Tarif;
use App\Models\Pengembalian;


class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['peminjaman', 'tarif'])
            ->latest()
            ->get();

        return view('admin.transaksi.index', compact('transaksi'));
    }

    

    public function show($id)
    {
        $transaksi = Transaksi::with(['peminjaman', 'tarif'])
            ->findOrFail($id);

        return view('admin.transaksi.detail', compact('transaksi'));
    }
    public function dendaTerlambat($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $tarif = Tarif::where('jenis_tarif', 'terlambat')->firstOrFail();


        $tanggalKembali = \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian);
        $sekarang = now();

        $hariTerlambat = $sekarang->greaterThan($tanggalKembali)
            ? $tanggalKembali->diffInDays($sekarang)
            : 0;
        
        $total = $hariTerlambat * $tarif->tarif;


        if ($hariTerlambat <= 0) {
            return back()->with('info', 'Tidak ada keterlambatan');
        }

        // 🔥 UPDATE STATUS PEMINJAMAN
        $peminjaman->update([
            'status' => 'terlambat'
        ]);

        // cegah double
        $cek = Transaksi::where('id_peminjaman', $id)
            ->where('jenis_transaksi', 'denda')
            ->exists();

        if ($cek) {
            return back()->with('error', 'Denda terlambat sudah ada');
        }

        Transaksi::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_tarif' => $tarif->id_tarif,
            'total_bayar' => $total,
            'jenis_transaksi' => 'denda',
            'tanggal_transaksi' => now(),
        ]);

        Pengembalian::firstOrCreate([
            'id_peminjaman' => $peminjaman->id_peminjaman,
        ], [
            'tanggal_pengembalian' => $peminjaman->tanggal_pengembalian
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

        // update status
        $peminjaman->update([
            'status' => 'rusak'
        ]);

        // cegah double transaksi
        $cek = Transaksi::where('id_peminjaman', $id)
            ->where('jenis_transaksi', 'denda')
            ->exists();

        if ($cek) {
            return back()->with('error', 'Denda kerusakan sudah ada');
        }

        // otomatis total bayar
        $total = $tarif->tarif;

        Transaksi::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_tarif' => $tarif->id_tarif,
            'total_bayar' => $total,
            'jenis_transaksi' => 'denda',
            'tanggal_transaksi' => now(),
        ]);

        // 🔥 AUTO PENGEMBALIAN
       // 🔥 INSERT PENGEMBALIAN (INI YANG KAMU MAU)
        Pengembalian::firstOrCreate([
            'id_peminjaman' => $peminjaman->id_peminjaman,
        ], [
            'tanggal_pengembalian' => $peminjaman->tanggal_pengembalian
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