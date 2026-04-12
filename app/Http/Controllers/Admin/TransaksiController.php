<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Models\Tarif;
use App\Models\Pengembalian;
use Carbon\Carbon;


class TransaksiController extends Controller
{
   public function index()
    {
        $query = Transaksi::with('peminjaman');

        // FILTER STATUS
        if (request()->filled('status')) {
            $query->whereHas('peminjaman', function ($q) {
                $q->where('status', request('status'));
            });
        }

        // SEARCH
        if (request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('jenis_transaksi', 'like', "%$search%")
                ->orWhereHas('peminjaman', function ($q2) use ($search) {
                    $q2->where('status', 'like', "%$search%");
                });
            });
        }

        // JOIN untuk sorting status
        $query->join('peminjaman', 'transaksis.id_peminjaman', '=', 'peminjaman.id_peminjaman')
            ->select('transaksis.*')

            // 🔥 PRIORITAS 1: DATA TERBARU
            ->orderBy('transaksis.created_at', 'desc')

            // 🔥 PRIORITAS 2: STATUS ORDER
            ->orderByRaw("
                CASE 
                    WHEN peminjaman.status = 'dipinjam' THEN 1
                    WHEN peminjaman.status = 'terlambat' THEN 2
                    WHEN peminjaman.status = 'rusak' THEN 3
                    WHEN peminjaman.status = 'dikembalikan' THEN 4
                    ELSE 5
                END
            ");

        $transaksi = $query->paginate(5)->withQueryString();

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
        // ambil data peminjaman (pakai PK yang benar)
        $peminjaman = Peminjaman::where('id_peminjaman', $id)->firstOrFail();

        // ambil tarif denda
        $tarif = Tarif::where('jenis_tarif', 'terlambat')->firstOrFail();

        // normalisasi tanggal (hindari bug jam)
        $tanggalKembali = Carbon::parse($peminjaman->tanggal_pengembalian)->startOfDay();
        $sekarang = now()->startOfDay();

        // ❌ belum terlambat
        if ($sekarang->lessThanOrEqualTo($tanggalKembali)) {
            return back()->with('info', 'Tidak ada keterlambatan');
        }

        // ✅ hitung hari terlambat (akurat)
        $hariTerlambat = $tanggalKembali->diffInDays($sekarang);

        // total denda
        $total = $hariTerlambat * $tarif->tarif;

        // update status
        $peminjaman->update([
            'status' => 'terlambat'
        ]);

        // cegah double denda
        $cek = Transaksi::where('id_peminjaman', $peminjaman->id_peminjaman)
            ->where('jenis_transaksi', 'denda')
            ->exists();

        if ($cek) {
            return back()->with('error', 'Denda sudah dibuat sebelumnya');
        }

        // simpan transaksi denda
        Transaksi::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_tarif' => $tarif->id_tarif,
            'total_bayar' => $total,
            'jenis_transaksi' => 'denda',
            'tanggal_transaksi' => now(),
        ]);

        // simpan pengembalian (jika belum ada)
        Pengembalian::firstOrCreate(
            ['id_peminjaman' => $peminjaman->id_peminjaman],
            ['tanggal_pengembalian' => $peminjaman->tanggal_pengembalian]
        );

        return back()->with('success', "Denda berhasil dibuat ({$hariTerlambat} hari)");
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