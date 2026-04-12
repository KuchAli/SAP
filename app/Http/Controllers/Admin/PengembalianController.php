<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    public function index()
    {
         $sortMap = [
            'newest' => ['created_at', 'desc'],
            'oldest' => ['created_at', 'asc'],
           
        ];
        
        $query = Pengembalian::query();

        //search & sort

        if (request()->has('search')) {
            $search = request('search');
           $query->where('tanggal_pengembalian', 'like', "%$search%")
                ->orWhereHas('peminjaman', function ($q) use ($search) {
                    $q->where('status', 'like', "%$search%");
                });
        } else {
            $query = Pengembalian::query();
        }


        if (request()->has('sort') && isset($sortMap[request('sort')])) {
            $query->orderBy(...$sortMap[request('sort')]);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $pengembalian = $query->paginate(3)->withQueryString();

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