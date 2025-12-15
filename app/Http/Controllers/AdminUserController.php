<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Cek Role Dulu Sebelum Jalan
    // Kalau bukan 'super', langsung tendang keluar (403 Forbidden)
    private function checkAccess()
    {
        if (auth()->user()->role !== 'super') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI!');
        }
    }

    public function index()
    {
        $this->checkAccess(); // <--- PENJAGA PINTU

        // Ambil user lain
        $users = User::where('id', '!=', auth()->id())->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $this->checkAccess(); // <--- PENJAGA PINTU

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true
        ]);

        return back()->with('success', 'Admin baru berhasil ditambahkan!');
    }

    public function resetPassword(Request $request, $id)
    {
        $this->checkAccess(); // <--- PENJAGA PINTU

        $user = User::findOrFail($id);

        // Proteksi Tambahan: Jangan biarkan orang lain mereset Super Admin
        if($user->role == 'super' && auth()->user()->id != $user->id) {
             // Opsional: Super admin lain boleh saling reset atau tidak, tergantung kebijakan.
        }

        $request->validate(['new_password' => 'required|min:6']);
        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password berhasil direset!');
    }

    public function toggleStatus($id)
    {
        $this->checkAccess(); // <--- PENJAGA PINTU

        $user = User::findOrFail($id);

        // PENTING: Jangan sampai Super Admin mengunci dirinya sendiri atau Super Admin lain (opsional)
        if ($user->role == 'super') {
            return back()->with('error', 'Sesama Super Admin tidak boleh saling mengunci!');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun berhasil $status.");
    }

    public function destroy($id)
    {
        $this->checkAccess(); // <--- PENJAGA PINTU

        $user = User::findOrFail($id);

        if ($user->role == 'super') {
            return back()->with('error', 'Super Admin tidak bisa dihapus sembarangan!');
        }

        $user->delete();
        return back()->with('success', 'Admin berhasil dihapus.');
    }
}
