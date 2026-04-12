<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
       $sortMap = [
            'newest' => ['created_at', 'desc'],
            'oldest' => ['created_at', 'asc'],
            'az' => ['name', 'asc'],
            'za' => ['name', 'desc'],
        ];
        
        $query = User::query();

        //search & sort

        if (request()->has('search')) {
            $search = request('search');
            $query = User::where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        } else {
            $query = User::query();
        }


        if (request()->has('sort') && isset($sortMap[request('sort')])) {
            $query->orderBy(...$sortMap[request('sort')]);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $anggota = $query->paginate(3)->withQueryString();

        return view('admin.user.index', compact('anggota'));
    }

    public function create()
    {
        $user = User::all();   
        return view('admin.user.create', compact('user'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,anggota',
        ]);

        // Simpan user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id. ',user_id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update data user
        $data=[
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? 'anggota',
        ];

        // hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = $request->password; // auto-hash
        }

        $user->update($data);
       

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }



}
