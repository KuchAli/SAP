<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::latest()->get();
        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        return view('admin.pengembalian.show', compact('pengembalian'));
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();

        return back()->with('success', 'Data pengembalian dihapus');
    }
}