<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\DataTables\LaporanHasilAuditTable;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 'Super Admin' || $user->role == 'Admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role == 'User') {
                return redirect()->route('rekomendasi.index');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' =>  'required|string',
            'terms' => 'required'
        ], [
            'terms.required' => 'You must agree to the terms and conditions.'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        Auth::login($user);

        return redirect()->intended('login');
    }




    public function registerAsAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' =>  'required|string',
            'divisi' =>  'required|string',

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->divisi = $request->divisi;
        $user->save();


        return redirect()->back()->with('success', 'Akun berhasil di daftarkan!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }


    public function tampilPengguna()
    {

        $pengguna = User::paginate(5);

        return view('Super-Admin.manage-pengguna', ['pengguna' => $pengguna]);
    }

    public function halamanUpdatePengguna($id_user)
    {
        $pengguna = User::findOrFail($id_user);

        return view('Super-Admin.update-pengguna', ['pengguna' => $pengguna]);
    }

    public function updatePengguna(Request $request, $id_user)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'password' => 'nullable|min:6',
            'role' =>  'nullable|string',
            'divisi' =>  'nullable|string',
        ]);

        $pengguna = User::findOrFail($id_user);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'divisi' => $request->divisi,

        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect('/manage-pengguna')->with('success', 'Akun Pengguna Berhasil Diperbarui');
    }




    public function selfHalamanUpdatePengguna($id_user)
    {
        $pengguna = User::findOrFail($id_user); // Ambil berdasarkan id_user dari URL
        return view('Super-Admin.self-update', ['pengguna' => $pengguna]);
    }
}
