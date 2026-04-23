<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // ✅ tambahan

class TarifController extends Controller
{
    public function index()
    {
        $tarif = Tarif::all();

        // ✅ tambahan logika tombol
        $maxJenis = 3;
        $jumlahJenis = Tarif::distinct()->count('jenis_tarif');
        $bolehTambah = $jumlahJenis < $maxJenis;

        return view('admin.tarif.index', compact('tarif', 'bolehTambah')); // ✅ tambah variable
    }

    public function create()
    {
        $tarif = Tarif::all();

        // ✅ proteksi akses langsung ke URL
        $jumlahJenis = Tarif::distinct()->count('jenis_tarif');

        if ($jumlahJenis >= 3) {
            return redirect()->route('admin.tarif.index')
                ->with('error', 'Semua jenis tarif sudah tersedia');
        }

        return view('admin.tarif.create', compact('tarif'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis_tarif' => [
                'required',
                'in:peminjaman,kerusakan,terlambat',
                Rule::unique('tarifs')->whereNull('deleted_at'), // ✅ FIX
            ],
            'tarif' => 'required|numeric|min:0',
        ]);

        // Simpan data tarif baru
        Tarif::create([
            'jenis_tarif' => $request->jenis_tarif,
            'tarif' => $request->tarif,
        ]);

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);
        $tarif->delete();

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus');
    }
}