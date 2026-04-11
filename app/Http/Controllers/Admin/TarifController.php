<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarif = Tarif::all();
        return view('admin.tarif.index', compact('tarif'));
    }

    public function create()
    {
        $tarif = Tarif::all();
        return view('admin.tarif.create', compact('tarif'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis_tarif' => 'required|in:peminjaman,kerusakan,terlambat',
            'tarif' => 'required|numeric|min:0',
        ]);

        // Simpan data tarif baru
        Tarif::create([
            'jenis_tarif' => $request->jenis_tarif,
            'tarif' => $request->tarif,
        ]);

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, $id)
    {
        $tarif = Tarif::findOrFail($id);

        // Validasi input
        $request->validate([
            'jenis_tarif' => 'required|in:peminjaman,kerusakan,terlambat',
            'tarif' => 'required|numeric|min:0',
        ]);

        $data = [
            'jenis_tarif' => $request->jenis_tarif,
            'tarif' => $request->tarif,
        ];

        // Update data tarif
        $tarif->update($data);

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil diperbarui');
    }  

    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);
        $tarif->delete();

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus');
    }
}
