<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'kategori' => 'required|in:novel,komik,pengetahuan,sejarah',
            'gambar_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slug_buku' => 'required|string|max:255|unique:buku',
            'stok' => 'required|integer|min:0',
        ]);

        Buku::create([
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori' => $request->kategori,
            'gambar_buku' => $request->file('gambar_buku') ? $request->file('gambar_buku')->store('buku', 'public') : null,
            'slug_buku' => $request->slug_buku,
            'stok' => $request->stok,
            'status' => $request->stok > 0 ? 'tersedia' : 'dipinjam',
        ]);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku'));
    }
    
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'kategori' => 'required|in:novel,komik,pengetahuan,sejarah',
            'gambar_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slug_buku' => 'required|string|max:255|unique:buku,slug_buku,' . $buku->id_buku . ',id_buku',
            'stok' => 'required|integer|min:0',
        ]);

        $buku->update([
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori' => $request->kategori,
            'gambar_buku' => $request->file('gambar_buku') ? $request->file('gambar_buku')->store('buku', 'public') : $buku->gambar_buku,
            'slug_buku' => $request->slug_buku,
            'stok' => $request->stok,
            'status' => $request->stok > 0 ? 'tersedia' : 'dipinjam',
        ]);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
