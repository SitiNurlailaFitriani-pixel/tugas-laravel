<?php
namespace App\Http\Controllers\nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // 1. Memaparkan halaman borang log masuk
    public function show()
    {
        return view('nasabah.login');
    }

    // 2. Memproses data daripada borang log masuk
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // A. Pengecekan Khusus Login ADMIN (Hardcode)
        if ($request->username === 'admin' && $request->password === 'bankmini') {
            session([
                'is_login' => true,
                'role'     => 'admin',
                'username' => 'admin',
                'nama'     => 'Administrator',
            ]);

            session()->save();

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        }

        // B. Pengecekan Khusus Login PETUGAS (Hardcode)
        if ($request->username === 'petugasbankmini' && $request->password === 'gridas123') {
            session([
                'is_login'   => true,
                'role'       => 'petugas',
                'is_petugas' => true,
                'username'   => 'petugasbankmini',
                'nama'       => 'Petugas',
            ]);

            session()->save();

            return redirect()->route('petugas.dashboard')->with('success', 'Selamat datang kembali, Petugas!');
        }

        // C. Cari data akaun di database 'users' (Nasabah / Admin dari DB)
        $user = DB::table('users')
            ->where('username', $request->username)
            ->first();

        // Pengesahan Kata Laluan (Menyokong Hash & Plaintext)
        $isPasswordValid = false;
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $isPasswordValid = true;
            } elseif ($request->password === $user->password) {
                $isPasswordValid = true;
            }
        }

        // Jika user ditemukan dan password valid
        if ($user && $isPasswordValid) {
            
            // Cek jika akun di database memiliki role 'admin'
            if (isset($user->role) && $user->role === 'admin') {
                session([
                    'is_login' => true,
                    'role'     => 'admin',
                    'username' => $user->username,
                    'nama'     => $user->name ?? 'Admin',
                ]);

                session()->save();

                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
            }

            // Jika bukan admin -> Login sebagai NASABAH
            session([
                'is_login'      => true,
                'role'          => 'nasabah',
                'is_petugas'    => false,
                'nasabah_id'    => $user->id,
                'no_rekening'   => $user->no_rekening ?? '-',
                'nama_rekening' => $user->name ?? $user->username,
                'username'      => $user->username,
            ]);

            session()->save();

            return redirect()->route('homenasabah')->with('success', 'Selamat datang kembali, ' . ($user->name ?? $user->username));
        }

        return back()->withErrors(['login_error' => 'Username atau password salah!'])->withInput();
    }

    // 3. Memproses log keluar
    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}