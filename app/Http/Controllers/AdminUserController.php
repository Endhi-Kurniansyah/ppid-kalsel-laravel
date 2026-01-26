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
    public function index()
    {
        $this->checkAccess();
        $users = User::where('id', '!=', auth()->id())->get();
        return view('admin.users.index', compact('users'));
    }
    private function checkAccess()
    {
        // Kita buat fleksibel agar menerima 'super' atau 'super_admin'
        $role = trim(strtolower(auth()->user()->role));

        if ($role !== 'super' && $role !== 'super_admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI!');
        }
    }
    public function store(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,super_admin' // Pastikan role sesuai pilihan modal
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // String 'super_admin' akan tersimpan di sini
            'is_active' => true
        ]);

        return back()->with('success', 'Admin baru berhasil ditambahkan!');
    }

    public function resetPassword(Request $request, $id)
    {
        $this->checkAccess(); // <--- PENJAGA PINTU

        $user = User::findOrFail($id);

        // Proteksi Tambahan: Jangan biarkan orang lain mereset Super Admin
        if($user->role == 'super_admin' && auth()->user()->id != $user->id) {
             // Opsional: Super admin lain boleh saling reset atau tidak, tergantung kebijakan.
        }

        $request->validate(['new_password' => 'required|min:6']);
        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password berhasil direset!');
    }

    public function toggleStatus($id)
    {
        $this->checkAccess();
        $user = User::findOrFail($id);

        if ($user->id == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa mengunci akun sendiri!');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'DIAKTIFKAN' : 'DIKUNCI';
        return back()->with('success', "Akun {$user->name} berhasil $status.");
    }

    public function destroy($id)
    {
        $this->checkAccess();
        $user = User::findOrFail($id);

        // Proteksi: Jangan hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Admin berhasil dihapus secara permanen.');
    }

}
