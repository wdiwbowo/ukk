<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        // Jika ada kata pencarian, filter berdasarkan nama
        if ($search) {
            $users = User::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $users = User::all(); // Ambil semua jika tidak ada pencarian
        }
    
        return view('admin.UserAdmin', compact('users', 'search'));
    }

    public function addUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|string'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role
    ]);

    return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan!');
}
public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|string',
        'password' => 'nullable|string|min:6|confirmed'
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    // Update password jika diisi
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui!');
}
public function deleteUser($id)
{
    $user = User::findOrFail($id);

    $user->delete();

    return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
}


}