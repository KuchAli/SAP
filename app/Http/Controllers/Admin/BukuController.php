<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.buku.create', compact('kategori'));
    }

  public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'id_kategori' => 'required|exists:kategoris,id',
            'gambar_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        // upload gambar
        $path = null;
        if ($request->hasFile('gambar_buku')) {
            $path = $request->file('gambar_buku')->store('buku', 'public');
        }

        // ambil kategori
        $kategori = Kategori::find($request->id_kategori);

        // ambil slug kategori
        $slugKategori = $kategori ? $kategori->slug : 'kategori';

        // buat slug buku (gabungan kategori + judul)
        $slugBuku = Str::slug($slugKategori . '-' . $request->judul_buku);
        $slugBuku = Str::slug($slugKategori . '-' . $request->judul_buku);

        $count = Buku::where('slug_buku', 'like', $slugBuku . '%')->count();

        if ($count > 0) {
            $slugBuku .= '-' . ($count + 1);
        }

        Buku::create([
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'id_kategori' => $request->id_kategori,
            'gambar_buku' => $path,
            'slug_buku' => $slugBuku,
            'stok' => $request->stok,
            'status' => $request->stok > 0 ? 'tersedia' : 'dipinjam',
        ]);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::all();
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku','kategori'));
    }
    
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'id_kategori' => 'required|exists:kategoris,id',
            'gambar_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        $kategori = Kategori::find($request->id_kategori);
        $slugKategori = $kategori ? $kategori->slug : 'kategori';

        $slugBuku = Str::slug($slugKategori . '-' . $request->judul_buku);

        $count = Buku::where('slug_buku', 'like', $slugBuku . '%')
            ->where('id_buku', '!=', $buku->id_buku)
            ->count();

        if ($count > 0) {
            $slugBuku .= '-' . ($count + 1);
        }

        $data = [
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
           'id_kategori' => $request->id_kategori,
            'gambar_buku' => $request->file('gambar_buku') ? $request->file('gambar_buku')->store('buku', 'public') : $buku->gambar_buku,
            'slug_buku' => $slugBuku,
            'stok' => $request->stok,
            'status' => $request->stok > 0 ? 'tersedia' : 'dipinjam',
        ];

        $buku -> update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
